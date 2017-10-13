<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'admin', 'viewer',
    ];

    public function tasks() {
        return  $this->hasMany(Task::class)->get();
    }

    public function categories() {
        return  $this->hasMany(Category::class)->get();
    }
}
