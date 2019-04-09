<?php
// file: model/Couple.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Couple
*
* Represents a Couple in a championship
*
* @author Marcos Vázquez Fernández
*/
class Couple {

	/**
	* The id of the couple
	* @var int
	*/
    private $coupleId;

    /**
	* The user which is captain
	* @var User
	*/
    private $captain;

    /**
	* The user which is pair
	* @var User
	*/
    private $pair;

    /**
	* The id of the group
	* @var int
	*/
    private $groupId;
    
	/**
	* The constructor
	*
    * @param string $coupleId The id of the couple
    * @param User $captain The captain of the couple
    * @param User $pair The pair of the couple
    * @param string $groupId The id of the group
	*/
	public function __construct($coupleId=NULL, User $captain=NULL, User $pair=NULL, $groupId=NULL) {

        $this->coupleId = $coupleId;
        $this->captain = $captain;
        $this->pair = $pair;
        $this->groupId = $groupId;
	}

	/**
	* Gets the id of this couple
	*
	* @return int The id of this couple
	*/
	public function getCoupleId() {

		return $this->coupleId;
	}

	/**
	* Sets the id of this couple
	*
	* @param int $coupleId The id of this couple
	* @return void
	*/
	public function setCoupleId($coupleId) {

		$this->coupleId = $coupleId;
    }
    
    /**
	* Gets the user which is captain of this couple
	*
	* @return User The captain of this couple
	*/
	public function getCaptain() {

		return $this->captain;
	}

	/**
	* Sets the user which is captain of this couple
	*
	* @param User $captain The captain of this couple
	* @return void
	*/
	public function setCaptain(User $captain) {

		$this->captain = $captain;
    }
    
    /**
	* Gets the user which is pair of this couple
	*
	* @return User The pair of this couple
	*/
	public function getPair() {

		return $this->pair;
	}

	/**
	* Sets the user which is pair of this couple
	*
	* @param User $pair The pair of this couple
	* @return void
	*/
	public function setPair(User $pair) {

		$this->pair = $pair;
    }
    
    /**
	* Gets the id of this group
	*
	* @return int The id of this group
	*/
	public function getGroupId() {

		return $this->groupId;
	}

	/**
	* Sets the id of this group
	*
	* @param int $groupId The id of this group
	* @return void
	*/
	public function setGroupId($groupId) {

		$this->groupId = $groupId;
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
