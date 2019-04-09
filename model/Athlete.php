<?php
// file: model/User.php

require_once(__DIR__."/../core/ValidationException.php");

class Athlete {

	/**
	* The dni of the user
	* @var string
	*/
    private $dni;

    /**
	* Tells if the user is partner
	* @var boolean
	*/
	private $isPartner;

    /**
	* The user play level
	* @var int
	*/
    private $level;

    /**
	* The user gender
	* @var char
	*/
    private $gender;

	/**
	* The constructor
	*
	* @param string $username The name of the user
	* @param string $passwd The password of the user
	*/
	public function __construct($dni=NULL, $isPartner=NULL, $level=NULL, $gender=NULL) {
		$this->dni = $dni;
		$this->isPartner = false;
		$this->level = 0;
		$this->gender = $gender;
	}

	public function getDni() {
		return $this->dni;
	}

	public function setDni($dni) {
		$this->dni = $dni;
    }
    
    public function getLevel() {
		return $this->level;
	}

	public function setLevel($level) {
		$this->level = $level;
    }
    
    public function getIsPartner() {
		return $this->isPartner;
	}

	public function setPartner() {
		$this->partner = true;
    }

    public function unsetPartner() {
		$this->partner = false;
    }
    
    public function getGender() {
		return $this->gender;
	}

	public function setGender($gender) {
		$this->gender = $gender;
	}

}
