<?php
use Subflattr\Application;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Application();
$app['debug'] = true;

$basepath = __DIR__ . '/../';

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => $basepath . 'log/dev.log',
));
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $basepath .'views',
));


$app->get('/', 'Subflattr\Controller\IndexController::foobar');

$app->run();
