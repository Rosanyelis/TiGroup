<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrderTask extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
    }
}
