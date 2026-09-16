<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_tasks(): void
    {
        Task::create(['title' => 'Task 1', 'description' => 'First task']);
        Task::create(['title' => 'Task 2', 'description' => 'Second task']);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    public function test_can_create_task(): void
    {
        $payload = [
            'title' => 'New Task',
            'description' => 'Task description',
            'is_completed' => false,
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'New Task']);

        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);
    }

    public function test_can_show_task(): void
    {
        $task = Task::create(['title' => 'Single Task', 'description' => 'Details']);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Single Task']);
    }

    public function test_can_update_task(): void
    {
        $task = Task::create(['title' => 'Old Title']);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'is_completed' => true,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Updated Title', 'is_completed' => true]);

        $this->assertDatabaseHas('tasks', ['title' => 'Updated Title', 'is_completed' => true]);
    }

    public function test_can_delete_task(): void
    {
        $task = Task::create(['title' => 'Task to delete']);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
