<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractsRenewedItems extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function contractRenewed()
    {
        return $this->belongsTo(ContractsRenewed::class, 'contract_renewed_id', 'id');
    }
}
