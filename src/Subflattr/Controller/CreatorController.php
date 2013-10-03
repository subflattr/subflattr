<?php


namespace Subflattr\Controller;


use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Imagick\Imagine;
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
			$image = $image->thumbnail(new Box(1000,1000));
			$image->save('images/avatars/' . strtolower($app->getUserData()['name']));
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