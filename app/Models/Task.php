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
        'task_id'
    ];

    public static function where(string $string, $input)
    {
    }

    public function parent()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function children()
    {
        return $this->hasMany(Task::class, 'task_id');
    }
}
