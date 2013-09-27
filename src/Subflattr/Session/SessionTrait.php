<?php

namespace Subflattr\Session;

use Symfony\Component\HttpFoundation\Session\Session;

trait SessionTrait {

	/**
	 * @return Session
	 */
	public function session() {
		return $this['session'];
	}
}