<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LockThreadsTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test  */
    public function non_administrator_may_not_lock_threads()
    {
        $this->withExceptionHandling();
        
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))->assertStatus(403);

        $this->assertFalse(!! $thread->fresh()->locked);
    }

    /** @test  */
    public function administrators_can_lock_threads()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread));

        $this->assertTrue($thread->fresh()->locked, 'Failed asserting that the thread was locked.');
    }

    /** @test  */
    public function administrators_can_unlock_threads()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id(), 'locked' => false]);

        $this->delete(route('locked-threads.destroy', $thread));

        $this->assertFalse($thread->fresh()->locked, 'Failed asserting that the thread was unlocked.');
    }

    /** @test  */
    public function once_locked_a_thread_may_not_received_a_new_replies()
    {

        $this->signIn();

        $thread = create('App\Thread', ['locked' => true]);

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id()
        ])->assertStatus(422);
    }
}