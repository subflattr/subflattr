<?php


namespace Subflattr\Controller;


use Subflattr\Application;
use Subflattr\Entity\Feed;
use Symfony\Component\HttpFoundation\Request;

class CreatorController {

	public function create(Request $request, Application $app) {
		if (!$app->isLoggedIn())
			return $app->redirect('/');

		$rendervars = [
			'loggedin' => $app->isLoggedIn(),
			'user' => $app->getUserData()
		];
		return $app->render('creator/create.twig', $rendervars);
	}

	public function createSubmit(Request $request, Application $app) {

		$greeting = $request->get('greeting');

		$feed = new Feed($app->session()->get('userid'), $greeting);

		$app->doctrine()->persist($feed);
		$app->doctrine()->flush();

		return $app->redirect('/');
	}
}