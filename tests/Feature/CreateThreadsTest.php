<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    Use DatabaseMigrations;

    /** @test */
    public function guests_may_not_create_threads() 
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
    	$this->signIn();

    	$thread = make('App\Thread');

    	$response = $this->post('/threads', $thread->toArray());
        
    	$this->get($response->headers->get('Location'))
    		->assertSee($thread->title)
    		->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->signIn();
        $thread = make('App\Thread', ['title' => null]);
        dd($thread);

        $this->post('/threads', $thread->toArray())
            ->assertSessionHasErrors('title');
    }
}
