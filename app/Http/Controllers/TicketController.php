<?php

namespace App\Http\Controllers;

use App\Contracts\TicketClassificationContract;
use App\Contracts\TicketContract;
use App\Http\Requests\TicketRequest;
use App\Http\Resources\TicketResource;
use App\Jobs\ClassifyTicketJob;
use Exception;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function __construct(private TicketContract $ticketContract, private TicketClassificationContract $ticketClassificationContract) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tickets = $this->ticketContract->getAllTickets();
            $ticketsResource =  TicketResource::collection($tickets);
            return response()->json(['tickets' => $ticketsResource], 200);
        } catch (Exception $ex) {
            Log::error('Exception in fetchting tickets: ', [$ex->getMessage()]);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request)
    {
        try {
            $params = $request->only('subject', 'body');
            Log::info('Ticket create parameters: ', [$params]);
            $ticket = $this->ticketContract->createData($params);
            $arrTicket = $ticket->toArray();
            Log::info('Ticket created: ', [$arrTicket]);
            return response()->json(['message' => 'Ticket creation was successful'], 200);
        } catch (Exception $ex) {
            Log::error('Exception in creating ticket: ', [$ex->getMessage()]);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            Log::info('Ticket fetching for id: ', [$id]);
            $ticket = $this->ticketContract->getDataById($id);
            $arrTicket = $ticket->toArray();
            Log::info('Ticket found: ', [$arrTicket]);
            return response()->json(['ticket' => $arrTicket], 200);
        } catch (Exception $ex) {
            Log::error('Exception in fetchting single ticket: ', [$ex->getMessage()]);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketRequest $request, string $id)
    {
        try {
            $params = $request->except('_token', '_method');
            Log::info('Ticket update params: ', [$params]);
            $paramTicket = [
                'subject' => $params['subject'],
                'body' => $params['body'],
                'status' => $params['status']
            ];
            $ticket = $this->ticketContract->updateData($params, $id);
            $arrTicket = $ticket->toArray();
            Log::info('Ticket updated: ', [$$arrTicket]);
            return response()->json([], 200);
        } catch (Exception $ex) {
            Log::error('Exception in fetchting single ticket: ', [$ex->getMessage()]);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function categories()
    {
        try {
            $categories = $this->ticketClassificationContract->getCategories();
            $arrCategories = $categories->toArray();
            $arrCategories = [
                "Billing",
                "Technical",
                "General"
            ];
            return response()->json(['categories' => $arrCategories], 200);
        } catch (Exception $ex) {
            Log::error('Exception in fetching unique category: ', [$ex->getMessage()]);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    public function classify(string $id)
    {
        try {
            ClassifyTicketJob::dispatchSync($id);
            return response()->json(['message' => 'Ticket classification was successful'], 200);
        } catch (Exception $ex) {
            Log::error('Exception in classify single ticket: ', [$ex->getMessage()]);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
