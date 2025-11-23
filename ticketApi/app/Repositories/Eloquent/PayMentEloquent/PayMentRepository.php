<?php

namespace App\Repositories\Eloquent\PayMentEloquent;

use App\Models\PayMentForm;
use App\Repositories\Interfaces\PayMentForm\PayMentFormContract;

class PayMentRepository implements PayMentFormContract
{
    public function index(string $id){}

    public function store(array $data)
    {
        $maxId = PayMentForm::where('owner_id', $data['owner_id'])->max('pay_ment_form_id');

        return PayMentForm::create([
            'pay_ment_form_id' => $maxId ? $maxId + 1 : 1,
            'owner_id' => $data['owner_id'],
            'pay_ment_form' => $data['pay_ment_form'],
            'type' => $data['type'],
        ]); 
    }

    public function update(array $data, string $id)
    {
        $payMent = $this->findById($data['owner_id'], $id);

        $payMent->update([
            'pay_ment_form' => $data['pay_ment_form'],
            'type' => $data['type']
        ]);

        return $payMent->fresh();
    }

    public function findById(string $ownerId, string $payMentId)
    {
        return PayMentForm::where('owner_id', $ownerId)
                            ->where('pay_ment_form_id', $payMentId)
                            ->first();
    }
}   