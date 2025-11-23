<?php

namespace App\Enum\Status;

enum EnumStatus: string
{
    case PENDENTE = 'Pendente';
    case EM_ANDAMENTO = 'Em andamento';
    case PAUSADO = 'Pausado';
    case CANCELADO = 'Cancelado';
    case FINALIZADO_E_NAO_FATURADO = 'Finalizado e não faturado';
    case FINALIZADO_E_FATURADO = 'Finalizado e faturado';
}
