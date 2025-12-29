<?php

namespace App\Repositories\Interfaces\Technicel\Config;

interface TechnicelConfigContract
{
    public function show(string $id);
    public function update(array $data);
}
