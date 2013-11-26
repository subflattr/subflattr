<?php

namespace Subflattr\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Entity(repositoryClass="Subflattr\Repositories\UserRepository")
 * @Table(name="users")
 */
class User {

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
	 * @Column(type="string", length=30, name="normalized_username")
	 */
	protected $normalizedUsername;

	/**
	 * @Column(type="string", length=32)
	 */
	protected $token;

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
	 * @Column(type="boolean", name="isactive")
	 */
	protected $isActive;

	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * @param String $token
	 */
	public function setToken($token)
	{
		$this->token = $token;
	}

	/**
	 * @param mixed $normalizedUsername
	 */
	public function setNormalizedUsername($normalizedUsername)
	{
		$this->normalizedUsername = $normalizedUsername;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getGreeting()
	{
		return $this->greeting;
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
	public function getSubheading()
	{
		return $this->subheading;
	}

	/**
	 * @param mixed $subheading
	 */
	public function setSubheading($subheading)
	{
		$this->subheading = $subheading;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
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
	public function isActive()
	{
		return $this->isActive;
	}

	/**
	 * @param mixed $isActive
	 */
	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;
	}

	/**
	 * @return string
	 */
	public function getToken() {
		return $this->token;
	}

	public function toArray()
	{
		return [
			'name' => $this->username,
			'feed' => [
				'greeting' => $this->greeting,
				'subheading' => $this->subheading,
				'description' => $this->description,
				'isActive' => $this->isActive
			]
		];
	}
}