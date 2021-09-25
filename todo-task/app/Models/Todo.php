<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'desc',
        'status',
        'parent_id'
    ];

    public function children()
    {
        return $this->hasMany('App\Models\Todo', 'parent_id');
    }
}
