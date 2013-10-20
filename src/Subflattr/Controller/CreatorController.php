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
use Subflattr\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreatorController {

	public function create(Request $request, Application $app) {

		if(!$app->session()->get('userid'))
			return $app->redirect('/');

		/** @var UploadedFile $file */
		$file = $request->files->get('image');

		$app->log("Updating userprofile for " . $app->getUserData()['name']);

		if(isset($file))
			$app->log(sprintf('User %s uploaded file with type %s', $app->getUserData()['name'], $file->getMimeType()));

		if(isset($file) && ($file->getMimeType() == 'image/jpeg' || $file->getMimeType() == 'image/png')) {
			$imagine = new Imagine();
			$image = $imagine->open($file->getRealPath());
			$maxSize = 1000;

			/** @var Box $size */
			$size = $image->getSize();

			if($size->getHeight() < $maxSize || $size->getWidth() < $maxSize)
				return new JsonResponse(['success' => false, 'status' => 406]);

			if($size->getWidth() > $maxSize || $size->getHeight() > $maxSize) {
				$cropStartX = floor(($size->getWidth() - $maxSize) / 2);
				$cropStartY = floor(($size->getHeight() - $maxSize) / 2);

				if($cropStartX < 0)
					$cropStartX = 0;
				if($cropStartY < 0)
					$cropStartY = 0;

				$image->crop(new Point($cropStartX, $cropStartY), new Box($maxSize, $maxSize));
			}
			$image->save('images/avatars/' . strtolower($app->getUserData()['name'] . '.jpg'));
		}

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

		return new JsonResponse(['success' => true]);
	}

	public function submit(Request $request, Application $app) {
		if(!$app->session()->get('userid'))
			return $app->redirect('/');


		/** @var UserRepository $repo */
		$repo = $app->doctrine()->getRepository('\Subflattr\Entity\User');

		/** @var User $creator */
		$creator = $repo->find($app->session()->get('userid'));
		$creatorToken = $app->oauth()->getAccessTokenByToken($creator->getToken());

		$thing = new Thing($request->get('url'), $request->get('title'), $request->get('desc'), $creator);
		$app->doctrine()->persist($thing);
		$app->doctrine()->flush();

		$opts = array(
			'url' => trim($request->get('url')),
			'title' => trim($request->get('title')),
			'description' => trim($request->get('desc')),
		);
		try {
			$response = $creatorToken->post('https://api.flattr.com/rest/v2/things',array('params' => $opts));
			$parsedResponse = $response->parse();
		}catch (ClientErrorResponseException $e) {
			$app->log($e,[],Logger::ERROR);
			return new JsonResponse(['success' => false]);
		}
		if($parsedResponse['message'] != 'ok') {
			$app->log($parsedResponse['description'],[],Logger::ERROR);
			return new JsonResponse(['success' => false]);
		}

		$thingId = $parsedResponse['id'];
		$app->log(sprintf("Successfully created new Thing %s for User %s", $thingId, $creator->getUsername()));

		$client= new \GearmanClient();
		$client->addServer();

		/** @var SubscriptionRepository $subRepo */
		$subRepo = $app->doctrine()->getRepository('\Subflattr\Entity\Subscription');

		$subscriptions = $subRepo->findBy(
			['subscribedto' => $creator->getId()]
		);

		/** @var $subscription Subscription */
		foreach($subscriptions AS $subscription) {
			$client->doBackground("flattr", serialize(new Flattr($thingId, $subscription->getSubscriber())));
		}

		return new JsonResponse(['success' => true]);
	}
}