<?php

namespace Subflattr\User;


use Subflattr\Entity\User;
use Subflattr\Repositories\UserRepository;

trait UserTrait {

	public function isLoggedIn() {
		$userid = $this['session']->get('userid');

		return (isset($userid));
	}

	public function getUserData() {
		/** @var UserRepository */
		$repo = $this->doctrine()->getRepository('Subflattr\Entity\User');
		/** @var User $user */
		$user = $repo->find($this->session()->get('userid'));

		return [
			'name' => $user->getUsername()
		];
	}
}