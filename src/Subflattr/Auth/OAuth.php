<?php

namespace Subflattr\Auth;


use Silex\Application;
use OAuth2\Client as OAuthClient;

class OAuth {
	private $app;

	private $client;

	private $clientId;
	private $clientSecret;
	private $site;

	public function __construct(Application $app) {
		$this->app = $app;

		$this->clientId = $app['oauth.client.id'];
		$this->clientSecret = $app['oauth.client.secret'];
		$this->site = $app['oauth.site'];

		$this->client = new OAuthClient(
			$this->clientId,
			$this->clientSecret,
			array('site' => $this->site)
		);
	}

	public function getAuthuri() {
		return $this->client->authCode()->authorizeUrl(
			array_merge(array('redirect_uri' => $this->app['oauth.redirecturi'],'scope'=>'flattr thing', array()))
		);
	}
}