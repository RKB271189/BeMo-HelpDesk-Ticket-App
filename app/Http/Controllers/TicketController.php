<?php

namespace App\Http\Controllers;

use App\Contracts\TicketContract;
use App\Http\Requests\TicketRequest;
use App\Jobs\ClassifyTicketJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function __construct(private TicketContract $ticketContract) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
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
            return response()->json(['ticket' => $arrTicket], 200);
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

    public function classify(string $id)
    {
        try {
            ClassifyTicketJob::dispatch($id);
        } catch (Exception $ex) {
            Log::error('Exception in classify single ticket: ', [$ex->getMessage()]);
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
