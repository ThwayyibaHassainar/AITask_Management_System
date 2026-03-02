<?php

// app/Services/AIService.php
namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class AIService
{
    // public function generateSummary(Task $task): array
    // {
    //     try {
    //         // Example prompt
    //         $prompt = "Summarize the following task and suggest priority:\nTitle: {$task->title}\nDescription: {$task->description}";

    //         // Here you would call OpenAI / Gemini / Claude API
    //         // Mock response
    //         $response = [
    //             'ai_summary' => 'This is an AI generated summary.',
    //             'ai_priority' => 'high'
    //         ];

    //         return $response;
    //     } catch (\Exception $e) {
    //         Log::error('AI Service Error: '.$e->getMessage());
    //         // Fallback values
    //         return [
    //             'ai_summary' => null,
    //             'ai_priority' => 'medium'
    //         ];
    //     }
    // }

    public function generateSummary(Task $task): array
    {
        // MOCK or OpenAI API

        return [
            'ai_summary' => 'This task involves ' . $task->title,
            'ai_priority' => 'high'
        ];
    }
}

?>