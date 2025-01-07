<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardItemLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function boardItem()
    {
        return $this->belongsTo(BoardItem::class, 'board_item_id', 'id');
    }
}
