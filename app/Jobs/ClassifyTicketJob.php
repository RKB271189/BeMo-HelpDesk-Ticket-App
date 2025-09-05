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
        try {
            Log::info('Job for classifying ticket started for ticket id: ', [$this->ticketId]);
            $ticket = $ticketContract->getDataById($this->ticketId);
            Log::info('Job for classifying ticket started for ticket: ', [$ticket]);
            if (config('openai.classify_enabled')) {
                Log::info('Open AI classification is enabled');
                $prompt = "Subject: {$ticket->subject}\n\nBody: {$ticket->body}";
                Log::info('Job for classifying ticket with prompt: ', [$prompt]);
                $response = $ticketClassifier->systemGenerateClassification($prompt);
                if (count($response) === 0) {
                    Log::info("Either exception(check the log) occured or no response from Open AI");
                }
                Log::info('Job for classifying ticket open ai response: ', [$response]);
            } else {
                Log::info('Open AI classification is disabled');
                $response = $ticketClassifier->randomGenerateClassification();
            }
            $ticketClassificationContract->createData($response);
        } catch (Exception $ex) {
            Log::error('Exception in a job for classification ticket: ', [$ex->getMessage()]);
        }
    }
}
