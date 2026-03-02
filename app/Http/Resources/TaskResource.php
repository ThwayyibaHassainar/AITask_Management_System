<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,

            'priority' => $this->priority,
            'status' => $this->status,
            'due_date' => $this->due_date,

            'assigned_to' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ],

            'ai' => [
                'summary' => $this->ai_summary,
                'suggested_priority' => $this->ai_priority,
            ],

            'created_at' => $this->created_at,
        ];
    }
}