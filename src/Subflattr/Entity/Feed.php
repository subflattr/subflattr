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

	/**
	 * @param mixed $greeting
	 */
	public function setGreeting($greeting)
	{
		$this->greeting = $greeting;
	}

	/**
	 * @param mixed $subheading
	 */
	public function setSubheading($subheading)
	{
		$this->subheading = $subheading;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @param mixed $owner
	 */
	public function setOwner($owner)
	{
		$this->owner = $owner;
	}

	/**
	 * @return boolean
	 */
	public function isActive()
	{
		return $this->isActive;
	}

	/**
	 * @param boolean $isActive
	 */
	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;
	}


	public function toArray() {
		return [
			'greeting' => $this->greeting,
			'subheading' => $this->subheading,
			'description' => $this->description,
			'isActive' => $this->isActive
		];
	}
}