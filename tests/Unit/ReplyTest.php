<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;
use App\Reply;

class ReplyTest extends TestCase
{
	use DatabaseMigrations;
    /** @test */
    public function it_has_an_owner()
    {
    	$reply = factory('App\Reply')->create();
    	$this->assertInstanceOf('App\User', $reply->owner);
    }

    /** @test  */
    public function it_knows_if_it_was_just_published()
    {
        $reply = factory('App\Reply')->create();

        $this->assertTrue($reply->wasJustPublished());
        
        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test  */
    public function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = new Reply([
            'body' => '@JaneDoe wants to talk with @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }

    /** @test  */
    public function it_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        $reply = new Reply([
            'body' => 'Hello @JaneDoe.'
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/JaneDoe">@JaneDoe</a>.', 
            $reply->body
        );  
    }

    /** @test  */
    public function it_knows_if_it_is_the_best_reply()
    {
        $reply = create('App\Reply');

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }
}
