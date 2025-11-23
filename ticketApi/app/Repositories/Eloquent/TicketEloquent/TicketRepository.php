<?php

namespace App\Repositories\Eloquent\TicketEloquent;

use App\Enum\Status\EnumStatus;
use App\Models\Ticket;
use App\Repositories\Interfaces\CashRegister\CashRegisterContract;
use App\Repositories\Interfaces\Customer\CustomerContract;
use App\Repositories\Interfaces\Ticket\TicketContract;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class TicketRepository implements TicketContract
{
    public function __construct(
        protected CashRegisterContract $cashRegisterRepository,
        protected CustomerContract $customerRepository
    ){}

    private function calculateTotalUsingDiscountOrIncrease(
        float $locationValue,
        float $base,
        float $discount,
        ?string $typeDiscount,
        float $increase,
        ?string $typeIncrease

    ): float
    {
        if($discount > 0)
        {
            $base -= ($typeDiscount === '%') 
                    ? ($base * $discount / 100 )
                    : $discount;
        }

        if($increase > 0)
        {
            $base += ($typeIncrease === '%') 
                    ? ($base * $increase / 100 )
                    : $increase;
        }

        if($locationValue > 0)
        {
            $base += $locationValue;

        }

        return round($base, 2);
    }

    public function index(string $id){}

    public function store(array $data, string $newCode)
    {
        $maxId = Ticket::where('owner_id', $data['owner_id'])->max('ticket_id');
        $customer = $this->customerRepository->findById($data['owner_id'], $data['customer_id']);        

        Log::channel('tickets')->debug('Cliente: ' . $customer);

        return Ticket::create([
            'ticket_id' => $maxId ? $maxId + 1 : 1,
            'ticket_code' => $newCode,
            'owner_id' => $data['owner_id'],
            'customer_id' => $customer->customer_id,
            'customer' => $customer->company_name,
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => $data['priority'],
            'location' => $data['location'],
            'location_value' => $data['location_value'],
            'increase_value' => $data['increase_value'],
            'increase_tpye' => $data['increase_tpye'],
            'discount_value' => $data['discount_value'],
            'discount_type' => $data['discount_type'],
            'base_value' => $data['base_value'],
            'total_value' => $this->calculateTotalUsingDiscountOrIncrease(
                $data['location_value'],
                $data['base_value'],
                $data['discount_value'],
                $data['discount_type'],
                $data['increase_value'],
                $data['increase_tpye']
            )
        ]);
    }

    public function update(array $data, string $id, string $typeOperation)
    {
        $ticket = $this->findByTicketCode($data['owner_id'], $data['ticket_code']);

        $ticket->update([
            'title' => $data['title'] ?? $ticket->title,
            'description' => $data['description'] ?? $ticket->description,
            'priority' => $data['priority'] ?? $ticket->priority,
            'location' => $data['location'] ?? $ticket->location,
            'location_value' => $data['location_value'] ?? $ticket->location_value,
            'increase_value' => $data['increase_value'] ?? $ticket->increase_value,
            'increase_tpye' => $data['increase_tpye'] ?? $ticket->increase_tpye,
            'discount_value' => $data['discount_value'] ?? $ticket->discount_value,
            'discount_type' => $data['discount_type'] ?? $ticket->discount_type,
            'base_value' => $data['base_value'] ?? $ticket->base_value,
            'total_value' => $this->calculateTotalUsingDiscountOrIncrease(
                $data['location_value'] ?? $ticket->location_value,
                $data['base_value'] ?? $ticket->base_value,
                $data['discount_value'] ?? $ticket->discount_value ,
                $data['discount_type'] ?? $ticket->discount_type,
                $data['increase_value'] ?? $ticket->increase_value,
                $data['increase_tpye'] ?? $ticket->increase_tpye
            )
        ]);

        switch (strtoupper($typeOperation)) {
            case 'EM_ANDAMENTO':
                $ticket->update([
                    'status' => EnumStatus::EM_ANDAMENTO,
                    'in_progress' => 1

                ]);

                break;
                
            case 'PAUSADO':
                $ticket->update([
                    'status' => EnumStatus::PAUSADO,
                    'in_progress' => 0
                ]);

                break;    

            case 'CANCELADO':
                $ticket->update([
                    'status' => EnumStatus::CANCELADO,
                    'canceled' => 1,
                    'in_progress' => 0

                ]);

                break;

            case 'FINALIZADO_E_NAO_FATURADO':
                $ticket->update([
                    'status' => EnumStatus::FINALIZADO_E_NAO_FATURADO,
                    'finish' => 1,
                    'date_paid' => null,
                    'in_progress' => 0

                ]);

                break;
                
            case 'FINALIZADO_E_FATURADO':
                $currentDate = new Carbon();

                $ticket->update([
                    'status' => EnumStatus::FINALIZADO_E_FATURADO,
                    'finish' => 1,
                    'date_paid' => $currentDate->format('Y.m.d'),
                    'in_progress' => 0
                ]);

                $cashRegisterData = [
                    'owner_id' => $ticket->owner_id,
                    'customer_id' => $ticket->customer_id,
                    'pay_ment_form_id' => $data['pay_ment_form_id'], 
                    'customer' => $ticket->customer, 
                    'input_value' => $data['amount_paid'], 
                    'output_value' => 0
                ];

                $this->cashRegisterRepository->store($cashRegisterData);

                break;
            
            default:
                throw new Exception("Um erro ocorreu ao realizar a alteração do ticket {$data['ticket_code']}");
                break;

        }

        return $ticket->fresh();
    }

    public function findById(string $ownerId)
    {
        return Ticket::where('owner_id', $ownerId)
                        ->first();
    }

    public function findByTicketCode(string $ownerId, string $ticketCode)
    {
        return Ticket::where('owner_id', $ownerId)
                        ->where('ticket_code', $ticketCode)
                        ->first();
    }
}