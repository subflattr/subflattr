<?php

namespace Subflattr\Controller;

use Subflattr\Application;
use Subflattr\Entity\User;
use Subflattr\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class OAuthController {

	public function authorize(Request $request, Application $app) {

		$authCode = $request->get('code');
		$token = $app->oauth()->getAccessTokenByCode($authCode);

		$response = $token->get('https://api.flattr.com/rest/v2/user');
		$username = $response->parse()['username'];

		/** @var UserRepository $repo */
		$repo = $app->doctrine()->getRepository('\Subflattr\Entity\User');
		$user = $repo->findByUsername($username);

		if(is_null($user)) {
			$user = new User();
			$user->setUsername($response->parse()['username']);
			$user->setNormalizedUsername(strtolower($response->parse()['username']));
			$user->setToken($token->getToken());
			$app->doctrine()->persist($user);
			$app->doctrine()->flush();
		}

		$app->session()->set('userid', $user->getId());
		return $app->redirect('/dashboard/');
	}
}