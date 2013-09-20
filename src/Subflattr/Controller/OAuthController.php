<?php

namespace Subflattr\Controller;

use Doctrine\ORM\EntityManager;
use Subflattr\Application;
use Subflattr\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class OAuthController {

	public function authorize(Request $request, Application $app) {

		$authCode = $request->get('code');
		$token = $app->oauth()->getAccessTokenByCode($authCode);

		$response = $token->get('https://api.flattr.com/rest/v2/user');
		$app->log($response->body());

		/** @var EntityManager $em */
		$em = $app['orm.em'];

		$user = new User();
		$user->setUsername($response->parse()['username']);
		$em->persist($user);
		$em->flush();

		return $app->render('oauth/authorize.twig', ['username' => $response->parse()['username']]);
	}
}