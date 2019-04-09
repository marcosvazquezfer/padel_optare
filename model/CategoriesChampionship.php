<?php
// file: model/CategoriesChampionship.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class CategoriesChampionship
*
*
* @author Marcos Vázquez Fernández
*/
class CategoriesChampionship {

	/**
	* The id of the championship
	* @var int
	*/
    private $championshipId;

    /**
	* The id of the category
	* @var int
	*/
    private $categoryId;
    
	/**
	* The constructor
	*
    * @param int $championshipId The id of the championship
    * @param int $categoryId The id of the category
	*/
	public function __construct($championshipId=NULL, $categoryId=NULL) {

        $this->championshipId = $championshipId;
        $this->categoryId = $categoryId;
	}

	/**
	* Gets the id of this championship
	*
	* @return int The id of this championship
	*/
	public function getChampionshipId() {

		return $this->championshipId;
	}

	/**
	* Sets the id of this championship
	*
	* @param int $championshipId The id of this championship
	* @return void
	*/
	public function setChampionshipId($championshipId) {

		$this->championshipId = $championshipId;
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
	* Checks if the current user instance is valid
	* for being registered in the database
	*
	* @throws ValidationException if the instance is
	* not valid
	*
	* @return void
	*/
	public function checkIsValidForRegister() {

        $errors = array();
        
		//FIXME: Meter comprobación de dni correcto
		if (strlen($this->dni) < 5) {
			$errors["dni"] = "DNI must be at least 5 characters length";
        }
        
		if (sizeof($errors)>0){
			throw new ValidationException($errors, "user is not valid");
		}
	}
}
