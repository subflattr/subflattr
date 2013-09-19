<?php

namespace Subflattr;

use Silex\Application as SilexApp;
use Silex\Application\MonologTrait;
use Silex\Application\TwigTrait;

class Application extends SilexApp {
    use MonologTrait;
    use TwigTrait;
}