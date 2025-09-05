<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

final class TicketClassifier
{
    private $gptModel = "gpt-4o-mini";

    public function __construct()
    {
        $this->gptModel = config('openai.gptmodel');
    }

    public function systemGenerateClassification(string $prompt, string $systemPrompt, $variables = []): array
    {
        $content = [];
        Log::info('Open AI Request prompt: ', [$prompt]);
        Log::info('Open AI System prompt: ', [$systemPrompt]);
        try {
            $data = [
                'model' => $this->gptModel,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
            ];
            if (count($variables) > 0) {
                Log::info('Opena AI variables: ', [$variables]);
                $data = array_merge($data, $variables);
            }
            Log::info('Making request to open ai');
            $response = OpenAI::chat()->create($data);
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
