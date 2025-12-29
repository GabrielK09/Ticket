<?php

namespace App\Enum\MessagesRequest;

enum CommonMessagesRequest: string
{
    case USER_ID = 'O identificador do usuário precisa estar em um formato válido!';
    case OWNER_ID = 'O identificador da empresa precisa estar em um formato válido!';

    case CNPJ_CPF_REQUIRED = 'O CNPJ/CPF da empresa é obrigatório!';
    case CNPJ_CPF_INVALID_FORMAT = 'O CNPJ/CPF precisa estar em um formato válido!';
    case CNPJ_CPF_MAX = 'O CNPJ/CPF precisa estar dentro do limite de caracteres (14)!';
    case CNPJ_CPF_PROHIBITED = 'O CPF/CNPJ não pode ser alterado!';
    case CNPJ_CPF_UNIQUE = 'Esse CPF/CNPJ já está cadastrado!';

}