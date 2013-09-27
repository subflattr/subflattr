<?php

namespace Subflattr\Controller;

use Monolog\Logger;
use Subflattr\Application;
use Symfony\Component\HttpFoundation\Request;



class ProfileController
{
    public function show(Request $request, Application $app)
    {

	    $app->log($request->get('name'));

        return $app->render('profile/show.twig', array('name' => $request->get('name')));
    }
}