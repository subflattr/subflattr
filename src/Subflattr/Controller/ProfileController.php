<?php

namespace Subflattr\Controller;

use Subflattr\Application;
use Subflattr\Entity\Feed;
use Subflattr\Entity\User;
use Subflattr\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ProfileController
{
	public function show(Request $request, Application $app)
	{
		$rendervars = [
			'loggedin' => $app->isLoggedIn()
		];
		if($app->isLoggedIn())
			$rendervars['user'] = $app->getUserData();
		else
			$rendervars['oauthlink'] = $app->oauth()->getAuthuri();


		/** @var UserRepository $repo */
		$repo = $app->doctrine()->getRepository('Subflattr\Entity\User');
		/** @var User $user */
		$user = $repo->findByNormalizedUsername($request->get('name'));

		if(!isset($user))
			return $app->render('profile/notfound.twig', $rendervars, new Response("User not found", 404));

		/** @var Feed $feed */
		$feed = $user->getFeed();
		if(!isset($user))
			return $app->render('profile/notfound.twig', $rendervars, new Response("User not found", 404));


		$rendervars = array_merge($rendervars, [
			'name' => $user->getUsername(),
			'greeting' => $feed->getGreeting(),
			'subheading' => $feed->getSubheading(),
			'description' => $feed->getDescription()
		]);

		if($app->isLoggedIn())
			$rendervars['user'] = $app->getUserData();
		else
			$rendervars['oauthlink'] = $app->oauth()->getAuthuri();


		return $app->render('profile/show.twig', $rendervars);
	}
}