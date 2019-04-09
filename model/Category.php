<?php
// file: model/Category.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Category
*
* Represents a Category in a championship
*
* @author Marcos Vázquez Fernández
*/
class Category {

	/**
	* The id of the category
	* @var int
	*/
    private $categoryId;

    /**
	* The gender of the category
	* @var char
	*/
    private $gender;

    /**
	* The level of the category
	* @var int
	*/
    private $level;
    
	/**
	* The constructor
	*
    * @param string $categoryId The id of the category
    * @param char $gender The gender of the category
    * @param int $level The level of the category
	*/
	public function __construct($categoryId=NULL, $gender=NULL, $level=NULL) {

        $this->categoryId = $categoryId;
        $this->gender = $gender;
        $this->level = $level;
    }
    
    /**
	* Gets the id of this category
	*
	* @return int The id of this category
	*/
	public function getCategoryId() {

		return $this->categoryId;
	}

	/**
	* Sets the id of this category
	*
	* @param int $categoryId The id of this category
	* @return void
	*/
	public function setCategoryId($categoryId) {

		$this->categoryId = $categoryId;
	}

	/**
	* Gets the gender of this category
	*
	* @return char The gender of this category
	*/
	public function getGender() {

		return $this->gender;
	}

	/**
	* Sets the gender of this category
	*
	* @param int $gender The gender of this category
	* @return void
	*/
	public function setGender($gender) {

		$this->gender = $gender;
    }
    
    /**
	* Gets the level of this category
	*
	* @return int The level of this category
	*/
	public function getLevel() {

		return $this->level;
	}

	/**
	* Sets the level of this category
	*
	* @param int $level The level of this category
	* @return void
	*/
	public function setLevel($level) {

		$this->level = $level;
    }
}
