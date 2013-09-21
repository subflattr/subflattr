<?php

namespace Subflattr\Doctrine;


use Doctrine\ORM\EntityManager;

trait DoctrineTrait {

	/**
	 * @return EntityManager
	 */
	public function doctrine() {
		return $this['orm.em'];
	}
}