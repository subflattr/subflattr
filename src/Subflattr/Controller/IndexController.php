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

        return $app->render('index/index.twig', ['url' => $oauth->getAuthuri()]);
    }
}