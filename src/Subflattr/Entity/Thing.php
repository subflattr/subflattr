<?php


namespace Subflattr\Entity;
use Subflattr\Entity\User;

/**
 * @Entity
 * @Table(name="things")
 */
class Thing {

	/**
	 * @Id
	 * @Column(type="integer")
	 * @GeneratedValue
	 */
	protected $id;

	/**
	 * @Column(type="string")
	 */
	protected $url;

	/**
	 * @Column(type="string", length=200)
	 */
	protected $title;

	/**
	 * @Column(type="string")
	 */
	protected $description;

	/**
	 * @Column(name="creator")
	 * @ManyToOne(targetEntity="Subflattr\Entity\User", inversedBy="things")
	 */
	protected $creator;

	public function __construct($url, $title, $description, User $creator) {
		$this->url = $url;
		$this->title = $title;
		$this->description = $description;
		$this->creator = $creator->getId();
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @return mixed
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

}