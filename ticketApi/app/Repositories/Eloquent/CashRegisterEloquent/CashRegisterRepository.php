<?php

namespace App\Repositories\Eloquent\CashRegisterEloquent;

use App\Models\CashRegister;
use App\Repositories\Interfaces\CashRegister\CashRegisterContract;
use App\Repositories\Interfaces\PayMentForm\PayMentFormContract;

class CashRegisterRepository implements CashRegisterContract
{
    public function __construct(
        protected PayMentFormContract $payMentRepository
    ){}

    public function index(string $id){}

    private function calculateBalance(
        int $ownerId,
        float $inputValue,
        float $outputValue

    ): float {
        $cash = CashRegister::where('owner_id', $ownerId)->orderByDesc('owner_id')->first();

        $balance = $cash->balance ?? 0;

        $balance += $inputValue;
        $balance -= $outputValue;

        return round($balance, 2);
    }

    public function store(array $data)
    {
        $maxId = CashRegister::where('owner_id', $data['owner_id'])->max('cash_register_id');
        $payMent = $this->payMentRepository->findById($data['owner_id'], $data['pay_ment_form_id']);

        return CashRegister::create([
            'cash_register_id' => $maxId ? $maxId + 1 : 1,
            'owner_id' => $data['owner_id'],
            'customer_id' => $data['customer_id'],
            'pay_ment_form_id'=> $payMent->pay_ment_form_id,
            'pay_ment_form' => $payMent->pay_ment_form,
            'customer' => $data['customer'],
            'input_value' => $data['input_value'] ?? 0, 
            'output_value' => $data['output_value'] ?? 0, 
            'balance' => $this->calculateBalance($data['owner_id'], $data['input_value'], $data['output_value']) 
        ]);
    }

    public function update(array $data, string $id)
    {
        
    }
}