<?php

namespace Subflattr;

use Silex\Application as SilexApp;
use Silex\Application\MonologTrait;
use Silex\Application\TwigTrait;
use Subflattr\Auth\OAuthTrait;
use Subflattr\Doctrine\DoctrineTrait;
use Subflattr\Session\SessionTrait;
use Subflattr\User\UserTrait;

class Application extends SilexApp {
    use MonologTrait;
    use TwigTrait;
    use OAuthTrait;
	use DoctrineTrait;
	use SessionTrait;
	use UserTrait;
}