<?php

namespace Subflattr\Auth;


use Silex\Application;
use Silex\ServiceProviderInterface;

trait OAuthTrait {

	/**
	 * @return OAuth
	 */
	public function oauth() {
		/** @var OAuth $oauth */
		$oauth = $this['oauth'];
		return $oauth;
	}
}