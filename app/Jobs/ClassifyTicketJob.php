<?php

namespace App\Jobs;

use App\Contracts\TicketClassificationContract;
use App\Models\Ticket;
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
    public function __construct(private Ticket $ticket, private TicketClassificationContract $ticketClassificationContract, private TicketClassifier $ticketClassifier)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Job for classifying ticket started for ticket: ', [$this->ticket]);
            if (config('openai.classify_enabled')) {
                Log::info('Open AI classification is enabled');
                $prompt = "Subject: {$this->ticket->subject}\n\nBody: {$this->ticket->body}";
                Log::info('Job for classifying ticket with prompt: ', [$prompt]);
                $response = $this->ticketClassifier->systemGenerateClassification($prompt);
                if (count($response) === 0) {
                    Log::info("Either exception occured or no response from Open AI");
                }
                Log::info('Job for classifying ticket open ai response: ', [$response]);
            } else {
                Log::info('Open AI classification is disabled');
                $response = $this->ticketClassifier->randomGenerateClassification();
            }
            $this->ticketClassificationContract->createData($response);
        } catch (Exception $ex) {
            Log::error('Exception in a job for classification ticket: ', [$ex->getMessage()]);
        }
    }
}
