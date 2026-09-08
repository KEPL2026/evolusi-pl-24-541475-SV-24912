<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_tasks_api_is_available(): void
    {
        $response = $this->getJson('/api/tasks');

        $response->assertOk()->assertJson(['tasks' => []]);
    }

    public function test_a_task_can_be_added_to_the_session_list(): void
    {
        $response = $this->postJson('/api/tasks', ['title' => 'Review the sprint backlog']);

        $response->assertCreated()->assertJsonPath('task.title', 'Review the sprint backlog');
        $this->getJson('/api/tasks')->assertJsonPath('tasks.0.title', 'Review the sprint backlog');
    }

    public function test_task_title_is_required(): void
    {
        $this->postJson('/api/tasks', ['title' => ''])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('title');
    }

    public function test_task_title_cannot_exceed_120_characters(): void
    {
        $this->postJson('/api/tasks', ['title' => str_repeat('a', 121)])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('title');
    }
}
