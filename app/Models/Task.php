<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'category_id', 'title', 'description', 'limit_date', 'order',
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
