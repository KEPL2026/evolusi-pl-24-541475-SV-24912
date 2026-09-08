<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_planner_page_is_available(): void
    {
        $response = $this->get('/');

        $response->assertOk()->assertSee('Make room for the work that matters.');
    }

    public function test_a_task_can_be_added_to_the_session_list(): void
    {
        $response = $this->post('/tasks', ['title' => 'Review the sprint backlog']);

        $response->assertRedirect('/');
        $this->get('/')->assertSee('Review the sprint backlog');
    }

    public function test_task_title_is_required(): void
    {
        $this->from('/')->post('/tasks', ['title' => ''])
            ->assertRedirect('/')
            ->assertSessionHasErrors('title');
    }

    public function test_task_title_cannot_exceed_120_characters(): void
    {
        $this->from('/')->post('/tasks', ['title' => str_repeat('a', 121)])
            ->assertRedirect('/')
            ->assertSessionHasErrors('title');
    }
}
