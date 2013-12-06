<?php

namespace Subflattr\Controller;

use Subflattr\Application;
use Subflattr\Entity\Subscription;
use Subflattr\Entity\User;
use Subflattr\Repositories\SubscriptionRepository;
use Subflattr\Repositories\ThingRepository;
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

		/** @var UserRepository $userRepo */
		$userRepo = $app->doctrine()->getRepository('Subflattr\Entity\User');
		/** @var User $profileUser */
		$profileUser = $userRepo->findByNormalizedUsername($request->get('name'));

		if(!isset($profileUser) || !$profileUser->isActive())
			return $app->render('profile/notfound.twig', $rendervars, new Response("User not found", 404));

		/** @var ThingRepository $thingrepo */
		$thingrepo = $app->doctrine()->getRepository('Subflattr\Entity\Thing');

		/** @var SubscriptionRepository $subscriptionRepo */
		$subscriptionRepo = $app->doctrine()->getRepository('Subflattr\Entity\Subscription');

		$isSubscribedTo = count($subscriptionRepo->findBy(['subscriber' => $app->session()->get('userid'), 'subscribedto' => $profileUser->getId()])) === 1;

		$rendervars = array_merge($rendervars, [
			'things' => $thingrepo->findByCreator($profileUser->getId()),
			'subscribedTo' => $isSubscribedTo,
			'name' => $profileUser->getUsername(),
			'greeting' => $profileUser->getGreeting(),
			'subheading' => $profileUser->getSubheading(),
			'description' => $profileUser->getDescription(),
			'subscribercount' =>$subscriptionRepo->getSubscriptionCountForUserId($profileUser->getId())
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

	public function unsubscribe(Request $request, Application $app) {

		/** @var UserRepository $userRepo */
		$userRepo = $app->doctrine()->getRepository('Subflattr\Entity\User');
		/** @var SubscriptionRepository $subscriptionRepo */
		$subscriptionRepo = $app->doctrine()->getRepository('Subflattr\Entity\Subscription');

		/** @var User $user */
		$subscribeToUser = $userRepo->findByNormalizedUsername($request->get('name'));

		/** @var Subscription $subscription */
		$subscription = $subscriptionRepo->findBy(['subscriber' => $app->session()->get('userid'), 'subscribedto' => $subscribeToUser->getId()]);

		$app->doctrine()->remove($subscription[0]);
		$app->doctrine()->flush();

		return $app->json(['success' => true]);
	}
}