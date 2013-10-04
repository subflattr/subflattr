<?php

namespace Subflattr\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity(repositoryClass="Subflattr\Repositories\SubscriptionRepository")
 * @Table(name="subscriptions")
 */
class Subscription {

	public function __construct(User $subscriber, User $subscribeto) {
		$this->subscriber = $subscriber->getId();
		$this->subscribedto = $subscribeto->getId();
	}


	/**
	 * @Id
	 * @Column(type="integer")
	 * @ManyToOne(targetEntity="Subflattr\Entity\User", inversedBy="subscriptions")
	 */
	protected $subscriber;

	/**
	 * @Id
	 * @Column(type="integer")
	 * @OneToMany(targetEntity="Subflattr\Entity\User", mappedBy="subscribedby")
	 * @JoinColumn(name="id", referencedColumnName="id")
	 */
	protected $subscribedto;

	/**
	 * @return User
	 */
	public function getSubscribedto()
	{
		return $this->subscribedto;
	}
}