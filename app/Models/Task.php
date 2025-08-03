<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'status',
        'due_date',
        'title',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
