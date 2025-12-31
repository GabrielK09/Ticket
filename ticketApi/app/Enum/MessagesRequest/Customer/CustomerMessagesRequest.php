<?php

namespace App\Enum\MessagesRequest\Customer;

enum CustomerMessagesRequest: string
{
    case COMPAYN_NAME_REQUIRED = 'A razão social do cliente é obrigatório!';
    case COMPAYN_NAME_INVALID_FORMAT = 'A razão social do cliente precisa estar em um formato válido!';
    case COMPAYN_NAME_MAX = 'A razão social do cliente precisa estar dentro do limite de caracteres (120)!';

    case TRADE_NAME_REQUIRED = 'O nome fantasia do cliente é obrigatório!';
    case TRADE_NAME_INVALID_FORMAT = 'O nome fantasia do cliente precisa estar em um formato válido!';
    case TRADE_NAME_MAX = 'O nome fantasia do cliente precisa estar dentro do limite de caracteres (120)!';

    case ADDRESS_REQUIRED = 'O endereço do cliente é obrigatório!';
    case ADDRESS_INVALID_FORMAT = 'O endereço do cliente precisa estar em um formato válido!';
    case ADDRESS_MAX = 'O endereço do cliente precisa estar dentro do limite de caracteres (60)!';

    case CEP_REQUIRED = 'O CEP do cliente é obrigatório!';
    case CEP_INVALID_FORMAT = 'O CEP do cliente precisa estar em um formato válido!';
    case CEP_MAX = 'O CEP do cliente precisa estar dentro do limite de caracteres (9)!';

    case NUMBER_ADDRESS_REQUIRED = 'O N° do endereço do cliente é obrigatório!';
    case NUMBER_ADDRESS_INVALID_FORMAT = 'O N° do endereço do cliente precisa estar em um formato válido!';
    case NUMBER_ADDRESS_MAX = 'O N° do endereço do cliente precisa estar dentro do limite de caracteres (16)!';

    case PHONE_REQUIRED = 'O número de telefone do cliente é obrigatório!';
    case PHONE_INVALID_FORMAT = 'O número de telefone do cliente precisa estar em um formato válido!';
    case PHONE_MAX = 'O número de telefone do cliente precisa estar dentro do limite de caracteres (24)!';
}
