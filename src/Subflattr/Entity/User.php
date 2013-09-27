<?php

namespace Subflattr\Entity;

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
	 * @OneToOne(targetEntity="Subflattr\Entity\Feed")
	 * @JoinColumn(name="id", referencedColumnName="owner")
	 */
	protected $feed;

	/**
	 * @Column(type="string", length=32)
	 */
	protected $token;

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
	 * @return Feed
	 */
	public function getFeed()
	{
		return $this->feed;
	}
}