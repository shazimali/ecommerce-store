import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            base: '/build/',
        }),
    ],
    server: {
        hmr: {
            host: 'everydayplastic.co',
            protocol: 'wss',
        },
        watch: {
            usePolling: true,
        },
        https: true,
        strictPort: true,
        port: 5173,
    },
    build: {
        // Raise the warning threshold (Swiper + Alpine are legitimately large)
        chunkSizeWarningLimit: 600,
        rollupOptions: {
            output: {
                // Split heavy vendor libraries into separate cached chunks
                manualChunks: {
                    'vendor-alpine': ['alpinejs', '@alpinejs/persist'],
                    'vendor-swiper': ['swiper'],
                },
            },
        },
    },
});

