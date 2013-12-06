<?php

namespace Subflattr\Auth;


use OAuth2\AccessToken;
use Silex\Application;
use OAuth2\Client as OAuthClient;

class OAuth {
	private $app;

	private $client;

	private $clientId;
	private $clientSecret;
	private $site;
	private $redirectUri;

	public function __construct(Application $app) {
		$this->app = $app;

		$this->clientId = $app['oauth.client.id'];
		$this->clientSecret = $app['oauth.client.secret'];
		$this->redirectUri = $this->app['oauth.redirecturi'];
		$this->site = $app['oauth.site'];

		$this->client = new OAuthClient(
			$this->clientId,
			$this->clientSecret,
			array('site' => $this->site)
		);
	}

	public function getAuthuri() {
		return $this->client->authCode()->authorizeUrl(
			array_merge(array('redirect_uri' => $this->redirectUri,'scope'=>'flattr thing', array()))
		);
	}

	/**
	 * @param $code
	 * @return AccessToken
	 */
	public function getAccessTokenByCode($code) {
		return $this->client->authCode()->getToken($code, array('redirect_uri' => $this->redirectUri, 'parse'=>'json') );
	}

	/**
	 * @param $token
	 * @return AccessToken
	 */
	public function getAccessTokenByToken($token) {
		return new AccessToken($this->client,$token);
	}
}