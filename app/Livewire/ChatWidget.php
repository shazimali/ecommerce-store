<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Services\AIChatbotService;
use Livewire\Component;

class ChatWidget extends Component
{
    public bool $isOpen = false;
    public string $inputMessage = '';
    public array $messages = [];
    public bool $isLoading = false;

    public function mount(): void
    {
        $this->messages[] = [
            'role' => 'assistant',
            'content' => "👋 Hi there! I'm your Everyday Plastic AI Assistant. Ask me about products, catalog prices, or track your order status!",
            'timestamp' => now()->format('h:i A'),
        ];
    }

    public function toggleWidget(): void
    {
        $this->isOpen = !$this->isOpen;
    }

    public function sendQuickPrompt(string $prompt): void
    {
        $this->inputMessage = $prompt;
        $this->sendMessage();
    }

    public function sendMessage(): void
    {
        $prompt = trim($this->inputMessage);
        if ($prompt === '') {
            return;
        }

        $this->messages[] = [
            'role' => 'user',
            'content' => $prompt,
            'timestamp' => now()->format('h:i A'),
        ];

        $this->inputMessage = '';
        $this->isLoading = true;

        $chatbotService = app(AIChatbotService::class);
        $history = array_slice($this->messages, -6);

        $reply = $chatbotService->chat($prompt, $history);

        $this->messages[] = [
            'role' => 'assistant',
            'content' => $reply,
            'timestamp' => now()->format('h:i A'),
        ];

        $this->isLoading = false;
    }

    public function clearChat(): void
    {
        $this->messages = [
            [
                'role' => 'assistant',
                'content' => "Chat history cleared. How can I help you next?",
                'timestamp' => now()->format('h:i A'),
            ]
        ];
    }

    public function render()
    {
        return view('livewire.chat-widget');
    }
}
