<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicelCommission extends Model
{
    public static function preventAccessingMissingAttributes($value = true)
    {
        return parent::preventAccessingMissingAttributes($value);
    }

    protected $table = 'technicel_commissions';

    protected $primaryKey = 'technicel_commission_id';

    protected $fillable = [
        'owner_id',
        'technicel_commission_id',
        'technical_id',
        'technical_name',
        'commission_value',
        'commission_type',
    ];
}
