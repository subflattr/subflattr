<?php


namespace Subflattr\Controller;


use Subflattr\Application;
use Subflattr\Entity\User;
use Subflattr\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Request;

class CreatorController {

	public function createSubmit(Request $request, Application $app) {

		/** @var UserRepository $repo */
		$repo = $app->doctrine()->getRepository('\Subflattr\Entity\User');

		/** @var User $user */
		$user = $repo->find($app->session()->get('userid'));

		$feed = $user->getFeed();
		$feed->isActive(true);
		$feed->setOwner($user->getId());
		$feed->setGreeting($request->get('greeting'));
		$feed->setSubheading($request->get('subheading'));
		$feed->setDescription($request->get('description'));

		$app->doctrine()->persist($feed);
		$app->doctrine()->flush();

		return $app->redirect('/');
	}
}