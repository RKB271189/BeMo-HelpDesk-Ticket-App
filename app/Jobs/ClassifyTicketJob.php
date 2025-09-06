<?php

namespace App\Jobs;

use App\Contracts\TicketClassificationContract;
use App\Contracts\TicketContract;
use App\Services\TicketClassifier;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ClassifyTicketJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $ticketId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(TicketContract $ticketContract, TicketClassificationContract $ticketClassificationContract,  TicketClassifier $ticketClassifier): void
    {
        Log::info('Job for classifying ticket started for ticket id: ', [$this->ticketId]);
        $ticket = $ticketContract->getDataById($this->ticketId);
        if ($ticket) {
            Log::info('Job for classifying ticket started for ticket: ', [$ticket]);
            $configOpenAIClassification = config('openai.classification');
            if ($configOpenAIClassification['classify_enabled']) {
                Log::info('Open AI classification is enabled');
                $prompt = "Subject: {$ticket->subject}\n\nBody: {$ticket->body}";
                $systemPrompt = $configOpenAIClassification['system_prompt'];
                Log::info('Job for classifying ticket with prompt: ', [$prompt]);
                $openAIVariables = $configOpenAIClassification['variables'];
                $response = $ticketClassifier->systemGenerateClassification($prompt, $systemPrompt, $openAIVariables);
                if (count($response) === 0) {
                    Log::info("Either exception(check the log) occured or no response from Open AI");
                    throw new Exception("Either exception(check the log) occured or no response from Open AI");
                }
                Log::info('Job for classifying ticket open ai response: ', [$response]);
            } else {
                Log::info('Open AI classification is disabled');
                $response = $ticketClassifier->randomGenerateClassification();
            }
            $response['ticket_id'] = $this->ticketId;
            $response['processed_at'] = date('Y-m-d H:i:s');
            $ticketContract->updateData(['status' => 'classified'], $this->ticketId);
            $ticketClassificationContract->createData($response);
        } else {
            Log::info('Job for classifying ticket id does not exist: ', [$this->ticketId]);
            throw new Exception("Ticket id passed does not exist");
        }
    }
}
