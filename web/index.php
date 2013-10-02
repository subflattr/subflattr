<?php
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
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
$app->register(new Subflattr\Auth\OAuthServiceProvider(), array(
	'oauth.client.id' => 'Z38YeOfCylahFxTlK8gYG0QjS3VFgP06',
	'oauth.client.secret' => 'IZUND0f2cf9ICSTdRZ1oPIxyCj4JYVFxKqaehg6jm6RPPASwqKK6j8uLhok6aPuK',
	'oauth.redirecturi' => 'http://subflattr.local:8080/oauth/',
	'oauth.site' => 'https://flattr.com',
));
$app->register(new DoctrineServiceProvider, array(
	"db.options" => array(
		"driver" => "pdo_mysql",
		"dbname" => "subflattr",
		"user" => "subflattr",
		"password" => "subflattr"
	),
));
$app->register(new DoctrineOrmServiceProvider, array(
	"orm.proxies_dir" => $basepath . "cache/proxies/",
	"orm.em.options" => array(
		"mappings" => array(
			array(
				"type" => "annotation",
				"namespace" => 'Subflattr',
				"path" => $basepath . 'src/Subflattr',
			),
		)
	)
));
$app->register(new Silex\Provider\SessionServiceProvider());


$app->get('/', 'Subflattr\Controller\IndexController::foobar');
$app->get('/oauth/', 'Subflattr\Controller\OAuthController::authorize');
$app->get('/dashboard/', 'Subflattr\Controller\DashboardController::index');
$app->get('/profile/{name}', 'Subflattr\Controller\ProfileController::show');
$app->post('/create/', 'Subflattr\Controller\CreatorController::createSubmit');
$app->get('/logout/', 'Subflattr\Controller\SessionController::logout');

$app->run();
