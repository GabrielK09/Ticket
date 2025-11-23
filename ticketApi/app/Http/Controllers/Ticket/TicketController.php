<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\TicketPayMentRequest;
use App\Http\Requests\Ticket\TicketRequest;
use App\Http\Requests\Ticket\TicketUpdateRequest;
use App\Services\Ticket\TicketService;

class TicketController extends Controller
{

    public function __construct(
        protected TicketService $ticketService

    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request)
    {
        return apiSuccess('Ticket cadastrado com sucesso!', $this->ticketService->store($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ownerId, string $ticketCode)
    {
        return apiSuccess("Dados do ticket: [{$ticketCode}]", $this->ticketService->show($ownerId, $ticketCode));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketRequest $request, string $id)
    {
        $data = $request->validated();
        return apiSuccess('Ticket alterado com sucesso!', $this->ticketService->update($data, $id, $data['operation']));
    }

    public function finishTicket(TicketRequest $request)
    {
        $data = $request->validated();
        return apiSuccess('Ticket finalizado com sucesso!', $this->ticketService->update($data, $data['ticket_id'], 'FINALIZADO_E_FATURADO'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
