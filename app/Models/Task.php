<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'is_completed',
        'due_at',
        'parent_id'
    ];



    public function children()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }
}
