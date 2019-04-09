<?php

require_once(__DIR__."/../core/ValidationException.php");

class Group {

	private $groupId;
	private $championshipId;
	private $categoryId;

	public function __construct($groupId=NULL, $championshipId=NULL, $categoryId=NULL) {

		$this->groupId = $groupId;
		$this->championshipId = $championshipId;
		$this->categoryId = $categoryId;
	}


	public function getGroupId() {

		return $this->groupId;
	}

	
	public function setGroupId($groupId) {

		$this->groupId = $groupId;
	}

	public function getChampionshipId() {

		return $this->championshipId;
	}

	
	public function setChampionshipId($championshipId) {

		$this->championshipId = $championshipId;
	}

	public function getCategoryId() {

		return $this->categoryId;
	}
	
	public function setCategoryId($categoryId) {

		$this->categoryId = $categoryId;
	}

}