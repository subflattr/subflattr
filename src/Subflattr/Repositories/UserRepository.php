<?php

namespace Subflattr\Repositories;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
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

	public function findBySubscriptionCountOrder() {
		$em = $this->getEntityManager();

		$rsm = new ResultSetMappingBuilder($em);
		$rsm->addRootEntityFromClassMetadata('Subflattr\Entity\FrontpageUser', 'u');

		$query = $em->createNativeQuery('SELECT u.id, u.username, u.description, u.greeting, COUNT(*) as counter FROM subscriptions s, users u WHERE s.subscribedto = u.id GROUP BY subscribedto limit 10', $rsm);
		$result = $query->execute();

		return $result;

	}
}