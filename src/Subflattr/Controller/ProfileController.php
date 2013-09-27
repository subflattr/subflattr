<?php

namespace Subflattr\Controller;

use Subflattr\Application;
use Symfony\Component\HttpFoundation\Request;


class ProfileController
{
	public function show(Request $request, Application $app)
	{
		$rendervars = [
			'loggedin' => $app->isLoggedIn(),
			'name' => $request->get('name')
		];

		if($app->isLoggedIn())
			$rendervars['user'] = $app->getUserData();
		else
			$rendervars['oauthlink'] = $app->oauth()->getAuthuri();


		return $app->render('profile/show.twig', $rendervars);
	}
}