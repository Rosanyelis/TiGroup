<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSpace extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function boards()
    {
        return $this->hasMany(Board::class, 'workspace_id', 'id');
    }
}
