<?php
// file: model/CouplesGroup.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class CouplesCategory
*
* Represents the couples of a group in a category
*
* @author Marcos Vázquez Fernández
*/
class CouplesCategory {

	/**
	* A couple of the group
	* @var Couple
	*/
    private $couple;
    
    /**
	* The id of the group
	* @var int
	*/
    private $groupId;
	
	/**
	* The category
	* @var Category
	*/
	private $category;
	
	
    
	/**
	* The constructor
	*
	* @param Couple $couple A couple of the group
    * @param int $groupId The id of the group
    * @param Category $category The category
	*/
	public function __construct(Couple $couple=NULL, $groupId=NULL, Category $category=NULL) {

		$this->couple = $couple;
		$this->groupId = $groupId;
		$this->category = $category;
	}

	/**
	* Gets a couple of this group
	*
	* @return Couple A couple of this group
	*/
	public function getCouple() {

		return $this->couple;
	}

	/**
	* Sets a couple of this group
	*
	* @param Couple $couple A couple of this group
	* @return void
	*/
	public function setCouple(Couple $couple) {

		$this->couple = $couple;
    }
    
    /**
	* Gets the id of the group
	*
	* @return int the id of the group
	*/
	public function getGroupId() {

		return $this->groupId;
	}

	/**
	* Sets the id of the group
	*
	* @param int $groupId The id of the group
	* @return void
	*/
	public function setGroupId($groupId) {

		$this->groupId = $groupId;
	}

	/**
	* Gets the category
	*
	* @return Category The category
	*/
	public function getCategory() {

		return $this->category;
	}

	/**
	* Sets the category
	*
	* @param Category $category The category
	* @return void
	*/
	public function setCategory(Category $category) {

		$this->category = $category;
	}
}