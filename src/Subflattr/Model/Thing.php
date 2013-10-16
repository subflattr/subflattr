<?php


namespace Subflattr\Model;


class Thing {

	private $url;
	private $title;
	private $description;

	public function __construct($url, $title, $description) {
		$this->url = $url;
		$this->title = $title;
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


}