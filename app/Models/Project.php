<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'admin','user',
    ];

    public function tasks() {
        return  $this->hasMany(Task::class);
    }

    public function categories() {
        return  $this->hasMany(Category::class);
    }
}
