<?php

namespace App\Enum\MessagesRequest\Customer;

enum CustomerMessagesRequest: string
{
    case COMPAYN_NAME_REQUIRED = 'A razão social da empresa é obrigatório!';
    case COMPAYN_NAME_INVALID_FORMAT = 'A razão social da empresa precisa estar em um formato válido!';
    case COMPAYN_NAME_MAX = 'A razão social da empresa precisa estar dentro do limite de caracteres (120)!';

    case TRADE_NAME_REQUIRED = 'O nome fantasia da empresa é obrigatório!';
    case TRADE_NAME_INVALID_FORMAT = 'O nome fantasia da empresa precisa estar em um formato válido!';
    case TRADE_NAME_MAX = 'O nome fantasia da empresa precisa estar dentro do limite de caracteres (120)!';

    case ADDRESS_REQUIRED = 'O endereço da empresa é obrigatório!';
    case ADDRESS_INVALID_FORMAT = 'O endereço da empresa precisa estar em um formato válido!';
    case ADDRESS_MAX = 'O endereço da empresa precisa estar dentro do limite de caracteres (60)!';

    case CEP_REQUIRED = 'O CEP da empresa é obrigatório!';
    case CEP_INVALID_FORMAT = 'O CEP da empresa precisa estar em um formato válido!';
    case CEP_MAX = 'O CEP da empresa precisa estar dentro do limite de caracteres (9)!';

    case NUMBER_ADDRESS_REQUIRED = 'O N° do endereço da empresa é obrigatório!';
    case NUMBER_ADDRESS_INVALID_FORMAT = 'O N° do endereço da empresa precisa estar em um formato válido!';
    case NUMBER_ADDRESS_MAX = 'O N° do endereço da empresa precisa estar dentro do limite de caracteres (16)!';

    case PHONE_REQUIRED = 'O número de telefone da empresa é obrigatório!';
    case PHONE_INVALID_FORMAT = 'O número de telefone da empresa precisa estar em um formato válido!';
    case PHONE_MAX = 'O número de telefone da empresa precisa estar dentro do limite de caracteres (24)!';
}
