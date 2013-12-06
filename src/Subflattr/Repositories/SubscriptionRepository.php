<?php

namespace Subflattr\Repositories;


use Doctrine\ORM\EntityRepository;
use Subflattr\Entity\User;

class SubscriptionRepository extends EntityRepository{

	public function getSubscriptionCountForUserId($userId) {
		$query = $this->getEntityManager()
			->createQuery('SELECT count(s.subscribedto) FROM \Subflattr\Entity\Subscription s WHERE s.subscribedto = :userId');
		$query->setParameter('userId', $userId);

		return $query->getSingleScalarResult();
	}
}