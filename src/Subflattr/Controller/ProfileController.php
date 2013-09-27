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

		$userid = $app->session()->get('userid');

		if (isset($userid)) {
			$loggedin = true;
		}else{
			$loggedin = false;
		}

		/** @var UserRepository */
		$repo = $app->doctrine()->getRepository('Subflattr\Entity\User');
		/** @var User $user */
		$user = $repo->find($app->session()->get('userid'));

		return $app->render('profile/show.twig', array(
			'loggedin' => $loggedin,
			'user' => [
				'name' => $user->getUsername()
			],
			'name' => $request->get('name')));
	}
}