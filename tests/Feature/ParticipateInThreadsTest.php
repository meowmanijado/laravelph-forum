<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInThreadsTest extends TestCase
{
   Use DatabaseMigrations;

   /** @test */
   public function unauthenticated_users_may_not_add_replies()
   {
      $this->withExceptionHandling()
          ->post('/threads/some-channel/1/replies', [])
          ->assertRedirect('/login');
   }

   /** @test */
   public function an_authenticated_user_may_participate_in_forum_threads()
   {
    $this->signIn();

    $thread = create('App\Thread');
    $reply = create('App\Reply');

    dd($thread->path().'/replies');

    $this->post($thread->path() . '/replies', $reply->toArray());
    $this->get($thread->path())->assertSee($reply->body);
   }
}
