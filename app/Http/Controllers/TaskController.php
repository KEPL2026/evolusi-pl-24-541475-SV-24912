<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        return view('tasks.index', [
            'tasks' => $request->session()->get('tasks', []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:120'],
        ]);

        $tasks = $request->session()->get('tasks', []);
        $tasks[] = [
            'title' => $validated['title'],
            'created_at' => now()->format('d M Y'),
        ];
        $request->session()->put('tasks', $tasks);

        return to_route('tasks.index')->with('success', 'Tugas berhasil ditambahkan.');
    }
}