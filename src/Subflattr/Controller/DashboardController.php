<?php

namespace Subflattr\Controller;

use Subflattr\Application;
use Subflattr\Entity\Thing;
use Subflattr\Repositories\ThingRepository;
use Symfony\Component\HttpFoundation\Request;


class DashboardController
{
	public function index(Request $request, Application $app)
	{
		if (!$app->isLoggedIn())
			return $app->redirect('/');


		/** @var ThingRepository $thingrepo */
		$thingrepo = $app->doctrine()->getRepository('Subflattr\Entity\Thing');

		$things = $thingrepo->findAllBySubscription($app->session()->get('userid'));

		$rendervars = [
			'loggedin' => true,
			'feed' => $things,
			'user' => $app->getUserData(),
			'name' => $app->getUserData()['username']
		];

		return $app->render('dashboard/index.twig', $rendervars);
	}
}