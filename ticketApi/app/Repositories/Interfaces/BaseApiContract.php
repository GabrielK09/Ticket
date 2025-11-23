<?php

namespace App\Repositories\Interfaces;

interface BaseApiContract
{
    public function index(string $id);
    public function store(array $data);
    public function update(array $data, string $id);
}
