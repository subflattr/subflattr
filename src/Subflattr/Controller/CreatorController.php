<?php


namespace Subflattr\Controller;


use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Subflattr\Application;
use Subflattr\Entity\User;
use Subflattr\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class CreatorController {

	public function create(Request $request, Application $app) {

		/** @var UploadedFile $file */
		$file = $request->files->get('image');
		if(isset($file) && ($file->getMimeType() == 'image/jpeg' || $file->getMimeType() == 'image/png')) {
			$imagine = new Imagine();
			$image = $imagine->open($file->getRealPath());
			$maxSize = 1000;

			/** @var Box $size */
			$size = $image->getSize();
			if($size->getWidth() > $maxSize || $size->getHeight() > $maxSize) {
				$cropStartX = floor(($size->getWidth() - $maxSize) / 2);
				$cropStartY = floor(($size->getHeight() - $maxSize) / 2);

				if($cropStartX < 0)
					$cropStartX = 0;
				if($cropStartY < 0)
					$cropStartY = 0;

				$image->crop(new Point($cropStartX, $cropStartY), new Box($maxSize, $maxSize));
			}


			$image->save('images/avatars/' . strtolower($app->getUserData()['name'] . '.png'));
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

		return $app->redirect('/');
	}
}