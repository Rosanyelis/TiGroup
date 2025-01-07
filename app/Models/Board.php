<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function workspace()
    {
        return $this->belongsTo(WorkSpace::class, 'workspace_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(BoardItem::class, 'board_id', 'id');
    }


}
