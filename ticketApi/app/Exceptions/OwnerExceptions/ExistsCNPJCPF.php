<?php

namespace App\Exceptions\OwnerExceptions;

use Exception;
use Throwable;

class ExistsCNPJCPF extends Exception
{
    public function __construct(string $message = ""){}
}
