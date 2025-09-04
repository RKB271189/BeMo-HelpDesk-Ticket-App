<?php

namespace App\Http\Controllers;

use App\Contracts\TicketContract;
use App\Http\Requests\TicketRequest;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(TicketRequest $request)
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
