<?php

namespace Subflattr\Controller;

use Subflattr\Application;
use Subflattr\Entity\Subscription;
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
		/** @var User $profileUser */
		$profileUser = $repo->findByNormalizedUsername($request->get('name'));

		if(!isset($profileUser) || !$profileUser->isActive())
			return $app->render('profile/notfound.twig', $rendervars, new Response("User not found", 404));

		$rendervars = array_merge($rendervars, [
			'name' => $profileUser->getUsername(),
			'greeting' => $profileUser->getGreeting(),
			'subheading' => $profileUser->getSubheading(),
			'description' => $profileUser->getDescription()
		]);

		return $app->render('profile/show.twig', $rendervars);
	}

	public function subscribe(Request $request, Application $app) {

		/** @var UserRepository $userRepo */
		$userRepo = $app->doctrine()->getRepository('Subflattr\Entity\User');
		/** @var User $user */
		$user = $userRepo->find($app->session()->get('userid'));
		$subscribeToUser = $userRepo->findByNormalizedUsername($request->get('name'));

		$subscription = new Subscription($user, $subscribeToUser);

		$app->doctrine()->persist($subscription);
		$app->doctrine()->flush();

		return $app->json(['success' => true]);
	}

}