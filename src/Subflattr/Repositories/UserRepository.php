<?php

namespace Subflattr\Repositories;


use Doctrine\ORM\EntityRepository;
use Subflattr\Entity\User;

class UserRepository extends EntityRepository{

	/**
	 * @param $username
	 * @return User
	 */
	public function findByUsername($username) {
		return $this->findOneBy(array('username'=>$username));
	}

	/**
	 * @param $username
	 * @return User
	 */
	public function findByNormalizedUsername($username) {
		return $this->findOneBy(array('normalizedUsername'=>strtolower($username)));
	}

}