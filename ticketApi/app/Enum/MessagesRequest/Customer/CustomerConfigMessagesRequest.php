<?php

namespace App\Enum\MessagesRequest\Customer;

enum CustomerConfigMessagesRequest: string
{
    case DEFAULT_TYPE_MAX = 'O tipo de cadastro padrão do cliente precisa estar dentro do limite de caracteres (1)!';
    case DEFAULT_TYPE_INVALID_FORMAT = 'O tipo de cadastro padrão do cliente precisa estar em um formato válido!';
    case DEFAULT_TYPE_IN = 'O tipo de cadastro padrão do cliente precisa estar entre F e J';
}
