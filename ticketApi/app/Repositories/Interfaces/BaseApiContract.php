<?php

namespace App\Repositories\Interfaces;

interface BaseApiContract
{
    public function store(array $data);
    public function update(array $data, string $id);
}
