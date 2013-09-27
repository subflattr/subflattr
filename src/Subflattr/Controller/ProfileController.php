<?php

namespace Subflattr\Controller;

use Subflattr\Application;
use Subflattr\Entity\User;
use Subflattr\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Request;


class ProfileController
{
	public function show(Request $request, Application $app)
	{

		$app->log($request->get('name'));

		return $app->render('profile/show.twig', array(
			'loggedin' => $app->isLoggedIn(),
			'user' => [
				'name' => $user->getUsername()
			],
			'name' => $request->get('name')));
	}
}