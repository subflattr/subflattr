<?php


namespace Subflattr\Controller;


use Guzzle\Http\Exception\ClientErrorResponseException;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Monolog\Logger;
use Subflattr\Application;
use Subflattr\Entity\Subscription;
use Subflattr\Entity\Thing;
use Subflattr\Entity\User;
use Subflattr\Model\Flattr;
use Subflattr\Repositories\SubscriptionRepository;
use Subflattr\Repositories\ThingRepository;
use Subflattr\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RssController {

	public function get(Request $request, Application $app) {

		$token = strtolower($request->get('id'));
		if(strlen($token) != 40)
			return new Response("Feed not found", 404);

		/** @var UserRepository $userRepo */
		$userRepo = $app->doctrine()->getRepository('Subflattr\Entity\User');

		/** @var User $user */
		$user = $userRepo->findOneBy(['rssToken' => $token]);
		if($user == null)
			return new Response("Feed not found", 404);

		/** @var ThingRepository thingRepo*/
		$thingRepo = $app->doctrine()->getRepository('Subflattr\Entity\Thing');

		$things = $thingRepo->findAllBySubscription($user->getId());

		$rendervars = [
			'things' => $things,
			'user' => $user->getUsername()
		];
		return $app->render('rss/list.twig', $rendervars, new Response('', 200, ['Content-Type'=> 'application/rss+xml']));
	}
}