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
	 * @param string $subheading
	 * @param string $description
	 */
	public function __construct($userid, $greeting, $subheading, $description) {
		$this->owner = $userid;
		$this->greeting = $greeting;
		$this->subheading = $subheading;
		$this->description = $description;
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
	 * @Column(type="string", length=50)
	 */
	protected $subheading;

	/**
	 * @Column(type="string", length=200)
	 */
	protected $description;


	/**
	 * @return mixed
	 */
	public function getGreeting()
	{
		return $this->greeting;
	}

	/**
	 * @return mixed
	 */
	public function getSubheading()
	{
		return $this->subheading;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

}