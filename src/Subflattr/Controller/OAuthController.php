<?php

namespace Subflattr\Controller;

use Subflattr\Application;
use Subflattr\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class OAuthController {

	public function authorize(Request $request, Application $app) {

		$authCode = $request->get('code');
		$token = $app->oauth()->getAccessTokenByCode($authCode);

		$response = $token->get('https://api.flattr.com/rest/v2/user');
		$app->log($response->body());

		$user = new User();
		$user->setUsername($response->parse()['username']);
		$app->doctrine()->persist($user);
		$app->doctrine()->flush();

		return $app->render('oauth/authorize.twig', ['username' => $response->parse()['username']]);
	}
}