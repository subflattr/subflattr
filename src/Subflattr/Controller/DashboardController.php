<?php

namespace Subflattr\Controller;

use Monolog\Logger;
use Subflattr\Application;
use Symfony\Component\HttpFoundation\Request;


class DashboardController
{
	public function index(Request $request, Application $app)
	{
		if (!$app->isLoggedIn())
			return $app->redirect('/');


		$rendervars = [
			'loggedin' => true,
			'user' => $app->getUserData()
		];

		return $app->render('dashboard/index.twig', $rendervars);
	}
}