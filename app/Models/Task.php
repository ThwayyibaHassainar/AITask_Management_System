<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'priority', 'status',
        'due_date', 'assigned_to', 'ai_summary', 'ai_priority'
    ];

    protected $casts = [
        'priority' => TaskPriority::class,
        'status' => TaskStatus::class,
        'due_date' => 'date',
        'ai_priority' => TaskPriority::class
    ];

    public function user() {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Optional Scope for filtering
    public function scopeFilter($query, $filters)
    {
        if(isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if(isset($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }
        if(isset($filters['assigned_to'])) {
            $query->where('assigned_to', $filters['assigned_to']);
        }
        return $query;
    }
}
