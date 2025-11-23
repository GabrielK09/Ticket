<?php

namespace App\Repositories\Interfaces\Ticket;

interface TicketContract
{
    public function index(string $id);
    public function store(array $data, string $newCode);
    public function update(array $data, string $id, string $typeOperation);
    public function findById(string $ownerId);
    public function findByTicketCode(string $ownerId, string $code);
}