<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;
use Mockery\Exception;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CreatePostRequest;
use App\Notifications\YouWereMentioned;
use App\User;

class RepliesController extends Controller
{
	public function __constructor()
	{
		$this->middleware('auth', ['except' => 'index']);
    }
    
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
        if ($thread->locked) {
            return response('Thread is locked', 422);
        }
        
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');
    }

    public function update (Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => 'required|spamfree']);

        $reply->update(request(['body']));
        
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }
}
