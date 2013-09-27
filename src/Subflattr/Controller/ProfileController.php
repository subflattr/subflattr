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

		/** @var UserRepository $repo */
		$repo = $app->doctrine()->getRepository('Subflattr\Entity\User');
		/** @var User $user */
		$user = $repo->findByNormalizedUsername($request->get('name'));

		$rendervars = [
			'loggedin' => $app->isLoggedIn(),
			'name' => $user->getUsername(),
			'greeting' => $user->getFeed()->getGreeting(),
			'subheading' => $user->getFeed()->getSubheading(),
			'description' => $user->getFeed()->getDescription()
		];

		if($app->isLoggedIn())
			$rendervars['user'] = $app->getUserData();
		else
			$rendervars['oauthlink'] = $app->oauth()->getAuthuri();


		return $app->render('profile/show.twig', $rendervars);
	}
}