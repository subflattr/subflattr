<?php

namespace Subflattr\Controller;

use Monolog\Logger;
use Subflattr\Application;
use Subflattr\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Request;



class IndexController
{
    public function index(Request $request, Application $app)
    {
	    $rendervars = [
		    'loggedin' => $app->isLoggedIn(),
	    ];

	    if($app->isLoggedIn())
		    $rendervars['user'] = $app->getUserData();
	    else
		    $rendervars['oauthlink'] = $app->oauth()->getAuthuri();


	    /** @var UserRepository $repo */
	    $repo = $app->doctrine()->getRepository('Subflattr\Entity\User');

	    $rendervars['frontpageUsers'] = $repo->findBySubscriptionCountOrder();

	    return $app->render('index/index.twig', $rendervars);
    }

	public function about(Request $request, Application $app) {
		$rendervars = [
			'loggedin' => $app->isLoggedIn(),
		];

		if($app->isLoggedIn())
			$rendervars['user'] = $app->getUserData();
		else
			$rendervars['oauthlink'] = $app->oauth()->getAuthuri();


		return $app->render('index/about.twig', $rendervars);

	}
}