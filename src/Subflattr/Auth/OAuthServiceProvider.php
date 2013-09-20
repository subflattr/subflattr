<?php

namespace Subflattr\Auth;


use Silex\Application;
use Silex\ServiceProviderInterface;

class OAuthServiceProvider implements ServiceProviderInterface{

	/**
	 * Registers services on the given app.
	 *
	 * This method should only be used to configure services and parameters.
	 * It should not get services.
	 *
	 * @param Application $app An Application instance
	 * @throws \Exception when OAuth is missing parameters
	 */
	public function register(Application $app)
	{
		$app['oauth'] = function($app) {
			return new OAuth($app);
		};
	}

	/**
	 * Bootstraps the application.
	 *
	 * This method is called after all services are registered
	 * and should be used for "dynamic" configuration (whenever
	 * a service must be requested).
	 */
	public function boot(Application $app) {
		if(	empty($app['oauth.client.id']) ||
			empty($app['oauth.client.secret']) ||
			empty($app['oauth.redirecturi']) ||
			empty($app['oauth.site'])
		) {
			throw new \Exception("OAuth needs all parameters");
		}
	}
}