<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function apiIndex(Request $request): JsonResponse
    {
        return response()->json([
            'tasks' => $request->session()->get('tasks', []),
        ]);
    }

    public function apiStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:120'],
        ]);

        $tasks = $request->session()->get('tasks', []);
        $task = [
            'title' => $validated['title'],
            'created_at' => now()->format('d M Y'),
        ];

        $tasks[] = $task;
        $request->session()->put('tasks', $tasks);

        return response()->json(['task' => $task, 'tasks' => $tasks], 201);
    }
}