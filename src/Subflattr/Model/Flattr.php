<?php


namespace Subflattr\Model;


class Flattr {

	private $thingId;
	private $userId;

	public function __construct($thingId, $userId) {
		$this->thingId = $thingId;
		$this->userId = $userId;
	}

	/**
	 * @return int
	 */
	public function getThingId()
	{
		return $this->thingId;
	}

	/**
	 * @return int
	 */
	public function getUserId()
	{
		return $this->userId;
	}


}