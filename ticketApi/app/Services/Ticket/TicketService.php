<?php

namespace App\Services\Ticket;

use App\Repositories\Interfaces\Ticket\TicketContract;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TicketService 
{
    public function __construct(
        protected TicketContract $ticketRepository
    ){}

    public function index(string $id, int $paginate)
    {
        return $this->ticketRepository->index($id, $paginate);
    }

    public function store(array $data)
    {
        $safeCounter = 0;
        $maxAttempts = 6;
        $newTicketCode = null;
        
        do {
            if($safeCounter > $maxAttempts)
            {
                break;

            }

            Log::channel('tickets')->debug('Dentro do do while');
            
            $newTicketCode = Str::random(24);

            Log::channel('tickets')->debug('TicketCode gerado: ' . $newTicketCode);

            $ticketCode = $this->ticketRepository->findByTicketCode($data['owner_id'], $newTicketCode);

            $find = is_null($ticketCode) ? 'Não' : 'Sim';
            Log::channel('tickets')->debug("TicketCode encontrado? {$find}");
            $safeCounter += 1;

        } while ($ticketCode);

        Log::channel('tickets')->debug('Fora do do while, novo código do ticket: ' . $newTicketCode);

        return DB::transaction(fn() => $this->ticketRepository->store($data, $newTicketCode));
    }

    public function update(array $data, string $id, string $typeOperation)
    {
        if(strtoupper($typeOperation === 'FINALIZADO_E_FATURADO'))
        {
            $ticket = $this->show($data['owner_id'], $data['ticket_code']);

            if($ticket->finish)
            {
                throw new Exception('Ticket já finalizado!');

            } else {
                if($data['amount_paid'] < $ticket->total_value)
                {
                    throw new Exception('Valor informado menor que o valor do serviço!');
                    
                }
            }
        }

        return DB::transaction(function() use ($data, $id, $typeOperation) {
            return $this->ticketRepository->update($data, $id, $typeOperation);

        });
    }

    public function show(string $ownerId, string $ticketCode)
    {
        $ticket = $this->ticketRepository->findByTicketCode($ownerId, $ticketCode);

        if(!$ticket)
        {
            throw new Exception('Ticket não localizado!');

        }

        return $ticket;
    }
}