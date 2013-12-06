<?php

namespace Subflattr\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity
 */
class FrontpageUser {

	/**
	 * @Id
	 * @Column(type="integer")
	 * @GeneratedValue
	 */
	protected $id;

	/**
	 * @Column(type="string", length=30)
	 */
	protected $username;

	/**
	 * @Column(type="string", length=23)
	 */
	protected $greeting;

	/**
	 * @Column(type="string", length=200)
	 */
	protected $description;

	/**
	 * @Column(type="integer")
	 */
	protected $counter;

	/**
	 * @param mixed $counter
	 */
	public function setCounter($counter)
	{
		$this->counter = $counter;
	}

	/**
	 * @return mixed
	 */
	public function getCounter()
	{
		return $this->counter;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param mixed $greeting
	 */
	public function setGreeting($greeting)
	{
		$this->greeting = $greeting;
	}

	/**
	 * @return mixed
	 */
	public function getGreeting()
	{
		return $this->greeting;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}
}