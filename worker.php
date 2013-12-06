<?php
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Monolog\Logger;
use Silex\Provider\DoctrineServiceProvider;
use Subflattr\Application;
use Subflattr\Entity\User;
use Subflattr\Model\Flattr;
use Subflattr\Repositories\UserRepository;

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

$worker= new GearmanWorker();
$worker->addServer();
$worker->addFunction("flattr", function($job, $app){
	/** @var $app Application */
	/** @var $job GearmanJob */
	/** @var Flattr $flattr */
	$flattr = unserialize($job->workload());
	$app->log(sprintf("Received work: Thing %s flattred by userid %s", $flattr->getThingId(), $flattr->getUserId()), ['worker']);

	/** @var UserRepository $repo */
	$repo = $app->doctrine()->getRepository('\Subflattr\Entity\User');
	/** @var User $user */
	$user = $repo->find($flattr->getUserId());

	$userToken = $app->oauth()->getAccessTokenByToken($user->getToken());

	$requestUrl = "https://api.flattr.com/rest/v2/things/". $flattr->getThingId() . "/flattr";

	try {
		$response = $userToken->post($requestUrl);
		$parsedResponse = $response->parse();
	}catch (ClientErrorResponseException $e) {
		$app->log($e->getMessage(), ['worker'], Logger::ERROR);
		return;
	}

	if($parsedResponse['message'] != 'ok') {
		$app->log($parsedResponse['description'], ['worker'], Logger::ERROR);
		return;
	}
	$app->log(sprintf("Successfully Flattred %s by %s", $flattr->getThingId(), $flattr->getUserId()), ['worker']);

}, $app);


while ($worker->work());

