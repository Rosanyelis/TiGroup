<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(BoardItemComment::class, 'board_item_id', 'id');
    }

    public function boardItemLogs()
    {
        return $this->hasMany(BoardItemLog::class, 'board_item_id', 'id');
    }


    public function files()
    {
        return $this->hasMany(BoardItemFile::class, 'board_item_id', 'id');
    }


}
