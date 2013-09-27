<?php

namespace Subflattr\Controller;

use Monolog\Logger;
use Subflattr\Application;
use Symfony\Component\HttpFoundation\Request;



class DashboardController
{
    public function index(Request $request, Application $app)
    {
//	    $app->log("You called /",[],Logger::INFO);
//
//	    $oauth = $app->oauth();

        return $app->render('dashboard/index.twig');
    }
}