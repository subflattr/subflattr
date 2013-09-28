<?php


namespace Subflattr\Controller;


use Subflattr\Application;
use Symfony\Component\HttpFoundation\Request;

class SessionController {

	public function logout(Request $request, Application $app) {
		$app->session()->invalidate();
		return $app->redirect('/');
	}
}