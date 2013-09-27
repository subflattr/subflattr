<?php

namespace Subflattr\Controller;

use Monolog\Logger;
use Subflattr\Application;
use Symfony\Component\HttpFoundation\Request;



class IndexController
{
    public function foobar(Request $request, Application $app)
    {
	    $app->log("You called /",[],Logger::INFO);

	    $oauth = $app->oauth();


	    $rendervars = [
		    'loggedin' => $app->isLoggedIn(),
		    'url' => $oauth->getAuthuri()
	    ];

	    if($app->isLoggedIn())
		    $rendervars['user'] = $app->getUserData();
	    else
		    $rendervars['oauthlink'] = $app->oauth()->getAuthuri();

	    return $app->render('index/index.twig', $rendervars);
    }
}