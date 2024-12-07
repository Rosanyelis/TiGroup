<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function user_asigned()
    {
        return $this->belongsTo(User::class, 'user_assigned_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(WorkOrderItem::class, 'work_order_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(WorkOrderTask::class, 'work_order_id', 'id');
    }

}
