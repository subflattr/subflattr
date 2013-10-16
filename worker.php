<?php
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Subflattr\Application;

require_once __DIR__.'/vendor/autoload.php';

$app = new Application();
$app['debug'] = true;

$basepath = __DIR__ . '/';

$app->register(new Silex\Provider\MonologServiceProvider(), array(
	'monolog.logfile' => $basepath . 'log/dev.log',
));
$app->register(new Subflattr\Auth\OAuthServiceProvider(), array(
	'oauth.client.id' => 'aOZPvC8kksY5gHJS1qmM3eSOnwv440E4',
	'oauth.client.secret' => 'FuK1WJc61018yAQpR21L6Kqk6Le1CJV73wYP50LWRDVf4BuMumnrWDBTfGLHfxF8',
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
//$app->run();


$worker= new GearmanWorker();
$worker->addServer();
$worker->addFunction("submit", function($job, $app){
	/** @var $app Application */
	$app->log("WORKER HERE!");
}, $app);
while ($worker->work());

