<?php

namespace Subflattr\Entity;

/**
 * @Entity
 * @Table(name="feeds")
 */
class Feed {

	/**
	 * @Id
	 * @Column(type="integer")
	 * @GeneratedValue
	 */
	protected $id;

	/**
	 * @Column(type="integer")
	 * @OneToOne(targetEntity="Subflattr\Entity\User")
	 */
	protected $owner;

	/**
	 * @Column(type="string", length=23)
	 */
	protected $greeting;

	/**
	 * @return mixed
	 */
	public function getGreeting()
	{
		return $this->greeting;
	}

}