<?php


namespace Subflattr\Controller;


use Subflattr\Application;
use Subflattr\Entity\User;
use Subflattr\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class CreatorController {

	public function create(Request $request, Application $app) {

		/** @var UserRepository $repo */
		$repo = $app->doctrine()->getRepository('\Subflattr\Entity\User');

		/** @var User $user */
		$user = $repo->find($app->session()->get('userid'));

		$user->setIsActive(true);
		$user->setGreeting($request->get('greeting'));
		$user->setSubheading($request->get('subheading'));
		$user->setDescription($request->get('description'));

		$app->doctrine()->persist($user);

		$app->doctrine()->flush();

		return $app->redirect('/');
	}
}