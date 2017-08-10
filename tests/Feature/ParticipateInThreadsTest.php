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
      $this->expectException('Illuminate\Database\QueryException');
      $reply = factory('App\Reply')->create();
      $thread = factory('App\Thread')->create();
      $this->post($thread->path() . '/replies', $reply->toArray());
   }

   /** @test */
   public function an_authenticated_user_may_participate_in_forum_threads()
   {
   	  $this->be($user = factory('App\User')->create());
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create();
        $this->post($thread->path() . '/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
   }
}
