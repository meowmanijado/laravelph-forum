<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
	protected $filters = ['by', 'popular', 'unanswered'];

	/**
	 * Filter the quesry by a given username.
	 * 
	 * @param  string $username
	 * @return mixed
	 */
	public function by($username)
	{
		$user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
	}

	/**
	 * Filter the quesry according to most popular thread
	 * @return $this 
	 */
	protected function popular()
	{
		$this->builder->getQuery()->orders = [];
		return $this->builder->orderBy('replies_count', 'desc');
	}

	protected function unanswered()
	{
		return $this->builder->where('replies_count', 0);
	}
}