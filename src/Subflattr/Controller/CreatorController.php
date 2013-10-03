<?php


namespace Subflattr\Controller;


use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Subflattr\Application;
use Subflattr\Entity\User;
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
}