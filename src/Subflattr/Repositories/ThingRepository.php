<?php

namespace Subflattr\Repositories;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Subflattr\Entity\Thing;
use Subflattr\Entity\User;

class ThingRepository extends EntityRepository{


	/**
	 * @param $userId
	 * @return array|Thing
	 */
	public function findAllBySubscription($userId) {
		$em = $this->getEntityManager();

		$rsm = new ResultSetMappingBuilder($em);
		$rsm->addRootEntityFromClassMetadata('Subflattr\Entity\Thing', 't');
//		$rsm->addRootEntityFromClassMetadata('Subflattr\Entity\User', 'u', ['id' => 'user_id', 'description' => 'user_description']);
//		$rsm->addFieldResult('u', 'user_id', 'id');
//		$rsm->addJoinedEntityFromClassMetadata('Subflattr\Entity\User', 'u', 't', 'creator', array('id' => 'user_id', 'description' => 'user_description'));

//		$query = $em->createNativeQuery('select t.* from subscriptions s, things t where s.subscriber = :userId order by t.created_at desc', $rsm);
		$query = $em->createNativeQuery('select t.* from subscriptions s INNER JOIN things t ON s.subscribedto=t.creator where s.subscriber = :userId order by t.created_at desc limit 50', $rsm);
		$result = $query->execute(['userId' => $userId]);

		return $result;
	}
}