<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

final class TicketClassifier
{
    private $gptModel = "gpt-4o-mini";

    private $temperature = 0.2;

    private $systemClassificationPrompt = "You are a classifier. Always strictly respond in JSON with keys category, explanation and confidence.";

    public function systemGenerateClassification(string $prompt): array
    {
        Log::info('Prompt of the ticket: ', [$prompt]);
        $content = [];
        try {
            Log::info('Making request to open ai');
            $response = OpenAI::chat()->create([
                'model' => $this->gptModel,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->systemClassificationPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => $this->temperature
            ]);
            Log::info('Response from open ai: ', [$response]);
            $jsonContent = $response['choices'][0]['message']['content'] ?? '{}';
            $content = json_decode($jsonContent, true);
            Log::info('Decoded response from open ai: ', [$content]);
        } catch (Exception $ex) {
            Log::error('Exception generating system classification: ', [$ex->getMessage()]);
        }
        return $content;
    }
    public function randomGenerateClassification(): array
    {
        $categories = ['Authentication', 'Billing', 'Technical', 'General Inquiry'];
        return [
            'category' => $categories[array_rand($categories)],
            'explanation' => 'This is some dummy explanation',
            'confidence' => mt_rand(50, 100) / 100,
        ];
    }
}
