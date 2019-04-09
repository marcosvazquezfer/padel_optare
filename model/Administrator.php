<?php
// file: model/Administrator.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Administrator
*
* Represents a Administrator in the web
*
* @author Marcos Vázquez Fernández
*/
class Administrator {

	/**
	* The dni of the user
	* @var string
	*/
    private $dni;
    
	/**
	* The constructor
	*
	* @param string $dni The dni of the user
	*/
	public function __construct($dni=NULL) {

		$this->dni = $dni;
	}

	/**
	* Gets the dni of this user
	*
	* @return string The dni of this user
	*/
	public function getDni() {

		return $this->dni;
	}

	/**
	* Sets the dni of this user
	*
	* @param string $dni The dni of this user
	* @return void
	*/
	public function setDni($dni) {

		$this->dni = $dni;
	}

}
