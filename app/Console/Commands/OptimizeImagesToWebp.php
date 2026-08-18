<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Badge;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Bundle;
use App\Models\BundleColor;
use App\Models\Category;
use App\Models\Collection;
use App\Models\ProductColor;
use App\Models\ProductHead;
use App\Models\ProductReview;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class OptimizeImagesToWebp extends Command
{
    protected $signature = 'images:optimize-webp
                            {--dry-run : Preview changes and estimated savings without modifying files or database}
                            {--keep-original : Keep old PNG/JPG files on disk instead of deleting them}
                            {--scan-disk : Also convert any unreferenced PNG/JPG files in storage/app/public}
                            {--quality=80 : WebP quality percentage (1-100)}
                            {--max-width=1200 : Maximum width to scale down images}';

    protected $description = 'Batch convert all stored PNG/JPG product and media images to optimized WebP format';

    private ImageManager $manager;
    private int $totalOriginalBytes = 0;
    private int $totalOptimizedBytes = 0;
    private int $convertedCount = 0;
    private int $skippedCount = 0;

    public function __construct()
    {
        parent::__construct();
        $this->manager = new ImageManager(new Driver());
    }

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $keepOriginal = (bool) $this->option('keep-original');
        $scanDisk = (bool) $this->option('scan-disk');
        $quality = (int) $this->option('quality');
        $maxWidth = (int) $this->option('max-width');

        $this->info("🚀 Starting Image Optimization to WebP...");
        if ($dryRun) {
            $this->warn("⚠️  Running in DRY-RUN mode. No files or database records will be modified.");
        }
        $this->line("• Quality: {$quality}% | Max Width: {$maxWidth}px\n");

        $targets = [
            [
                'model' => ProductHead::class,
                'name' => 'ProductHead',
                'fields' => ['image', 'nav_image', 'mobile_image', 'image1', 'image2', 'image3', 'image4', 'image5'],
            ],
            [
                'model' => ProductColor::class,
                'name' => 'ProductColor',
                'fields' => ['color_image', 'image1', 'image2', 'image3', 'image4', 'image5'],
            ],
            [
                'model' => Bundle::class,
                'name' => 'Bundle',
                'fields' => ['image', 'nav_image', 'mobile_image', 'image1', 'image2', 'image3', 'image4', 'image5'],
            ],
            [
                'model' => BundleColor::class,
                'name' => 'BundleColor',
                'fields' => ['color_image', 'image1', 'image2', 'image3', 'image4', 'image5'],
            ],
            [
                'model' => Category::class,
                'name' => 'Category',
                'fields' => ['image'],
            ],
            [
                'model' => SubCategory::class,
                'name' => 'SubCategory',
                'fields' => ['image'],
            ],
            [
                'model' => Collection::class,
                'name' => 'Collection',
                'fields' => ['image', 'mob_image'],
            ],
            [
                'model' => Banner::class,
                'name' => 'Banner',
                'fields' => ['image', 'mob_image'],
            ],
            [
                'model' => Blog::class,
                'name' => 'Blog',
                'fields' => ['image'],
            ],
            [
                'model' => Badge::class,
                'name' => 'Badge',
                'fields' => ['image'],
            ],
            [
                'model' => ProductReview::class,
                'name' => 'ProductReview',
                'fields' => ['image1', 'image2', 'image3'],
            ],
            [
                'model' => Website::class,
                'name' => 'Website',
                'fields' => ['logo'],
            ],
            [
                'model' => User::class,
                'name' => 'User',
                'fields' => ['profile_image'],
            ],
        ];

        $disk = Storage::disk('public');
        $processedFiles = [];

        foreach ($targets as $target) {
            $modelClass = $target['model'];
            $modelName = $target['name'];
            $fields = $target['fields'];

            $this->comment("Scanning {$modelName}...");

            $records = $modelClass::all();

            foreach ($records as $record) {
                $hasUpdates = false;

                foreach ($fields as $field) {
                    $originalPath = $record->{$field};

                    if (!$originalPath || !is_string($originalPath)) {
                        continue;
                    }

                    // Skip already converted WebP or SVGs
                    $extension = strtolower(pathinfo($originalPath, PATHINFO_EXTENSION));
                    if ($extension === 'webp' || $extension === 'svg') {
                        $this->skippedCount++;
                        continue;
                    }

                    if (!$disk->exists($originalPath)) {
                        continue;
                    }

                    $processedFiles[] = $originalPath;
                    $absoluteSourcePath = $disk->path($originalPath);
                    $originalSize = @filesize($absoluteSourcePath) ?: 0;

                    try {
                        $image = $this->manager->read($absoluteSourcePath);

                        if ($image->width() > $maxWidth) {
                            $image->scaleDown(width: $maxWidth);
                        }

                        $encoded = $image->toWebp($quality);
                        $newRelativePath = preg_replace('/\.[^.]+$/', '.webp', $originalPath);

                        if ($newRelativePath === $originalPath) {
                            $newRelativePath .= '.webp';
                        }

                        $optimizedSize = strlen((string) $encoded);

                        $this->totalOriginalBytes += $originalSize;
                        $this->totalOptimizedBytes += $optimizedSize;
                        $this->convertedCount++;

                        $savedPct = $originalSize > 0 ? round((1 - ($optimizedSize / $originalSize)) * 100, 1) : 0;
                        $this->line("  ✓ [{$modelName} #{$record->id} -> {$field}] " . $this->formatBytes($originalSize) . " → " . $this->formatBytes($optimizedSize) . " (-{$savedPct}%)");

                        if (!$dryRun) {
                            // Save new WebP file
                            $disk->put($newRelativePath, (string) $encoded);

                            // Update DB attribute
                            $record->{$field} = $newRelativePath;
                            $hasUpdates = true;

                            // Delete original file if distinct and keepOriginal is false
                            if (!$keepOriginal && $newRelativePath !== $originalPath) {
                                $disk->delete($originalPath);
                            }
                        }
                    } catch (\Throwable $e) {
                        $this->error("  ✗ Failed processing {$originalPath}: " . $e->getMessage());
                    }
                }

                if ($hasUpdates && !$dryRun) {
                    $record->save();
                }
            }
        }

        // Scan direct files on disk if requested
        if ($scanDisk) {
            $this->newLine();
            $this->comment("Scanning remaining files in storage/app/public...");
            $allFiles = $disk->allFiles();

            foreach ($allFiles as $file) {
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (!in_array($ext, ['png', 'jpg', 'jpeg', 'bmp', 'gif']) || in_array($file, $processedFiles)) {
                    continue;
                }

                $absoluteSourcePath = $disk->path($file);
                $originalSize = @filesize($absoluteSourcePath) ?: 0;

                try {
                    $image = $this->manager->read($absoluteSourcePath);
                    if ($image->width() > $maxWidth) {
                        $image->scaleDown(width: $maxWidth);
                    }

                    $encoded = $image->toWebp($quality);
                    $newPath = preg_replace('/\.[^.]+$/', '.webp', $file);
                    $optimizedSize = strlen((string) $encoded);

                    $this->totalOriginalBytes += $originalSize;
                    $this->totalOptimizedBytes += $optimizedSize;
                    $this->convertedCount++;

                    $savedPct = $originalSize > 0 ? round((1 - ($optimizedSize / $originalSize)) * 100, 1) : 0;
                    $this->line("  ✓ [File: {$file}] " . $this->formatBytes($originalSize) . " → " . $this->formatBytes($optimizedSize) . " (-{$savedPct}%)");

                    if (!$dryRun) {
                        $disk->put($newPath, (string) $encoded);
                        if (!$keepOriginal && $newPath !== $file) {
                            $disk->delete($file);
                        }
                    }
                } catch (\Throwable $e) {
                    $this->error("  ✗ Failed processing {$file}: " . $e->getMessage());
                }
            }
        }

        // Summary
        $this->newLine();
        $this->info("==========================================");
        $this->info("🎉 Image Optimization Complete!");
        $this->info("==========================================");
        $this->line("• Images Processed: <fg=green>{$this->convertedCount}</>");
        $this->line("• Images Skipped (already WebP/SVG): <fg=yellow>{$this->skippedCount}</>");
        $this->line("• Original Total Size: " . $this->formatBytes($this->totalOriginalBytes));
        $this->line("• Optimized WebP Size: " . $this->formatBytes($this->totalOptimizedBytes));

        $totalSaved = $this->totalOriginalBytes - $this->totalOptimizedBytes;
        $totalSavedPct = $this->totalOriginalBytes > 0 ? round(($totalSaved / $this->totalOriginalBytes) * 100, 1) : 0;

        $this->info("• Total Bandwidth Saved: <fg=green>" . $this->formatBytes(max(0, $totalSaved)) . " (-{$totalSavedPct}%)</>");

        return Command::SUCCESS;
    }

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
