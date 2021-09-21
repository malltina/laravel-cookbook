<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title','scheduled_for','parent_id','completed'];

    public function children()
  {
    return $this->hasMany('App\Models\Task', 'parent_id');
  }
}
