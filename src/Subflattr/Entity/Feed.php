<?php

namespace Subflattr\Entity;

/**
 * @Entity
 * @Table(name="feeds")
 */
class Feed {

	/**
	 * @param int $userid
	 * @param string $greeting
	 */
	public function __construct($userid, $greeting) {
		$this->owner = $userid;
		$this->greeting = $greeting;
	}


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