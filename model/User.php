<?php
// file: model/User.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class User
*
* Represents a User in the blog
*
* @author lipido <lipido@gmail.com>
*/
class User {

	/**
	* The user name of the user
	* @var string
	*/
	private $dni;

	/**
	* The password of the user
	* @var string
	*/
	private $password;

	/**
	* The name of the user
	* @var string
	*/
	private $completeName;

	/**
	* The email of the user
	* @var string
	*/
	private $email;

	/**
	* The constructor
	*
	* @param string $username The name of the user
	* @param string $passwd The password of the user
	*/
	public function __construct($dni=NULL, $password=NULL, $completeName=NULL, $email=NULL) {
		$this->dni = $dni;
		$this->password = $password;
		$this->completeName = $completeName;
		$this->email = $email;
	}

	/**
	* Gets the username of this user
	*
	* @return string The username of this user
	*/
	public function getDni() {
		return $this->dni;
	}

	/**
	* Sets the username of this user
	*
	* @param string $username The username of this user
	* @return void
	*/
	public function setDni($dni) {
		$this->dni = $dni;
	}

	/**
	* Gets the password of this user
	*
	* @return string The password of this user
	*/
	public function getPassword() {
		return $this->password;
	}
	/**
	* Sets the password of this user
	*
	* @param string $passwd The password of this user
	* @return void
	*/
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	* Gets the password of this user
	*
	* @return string The password of this user
	*/
	public function getCompleteName() {
		return $this->completeName;
	}
	/**
	* Sets the password of this user
	*
	* @param string $passwd The password of this user
	* @return void
	*/
	public function setCompleteName($completeName) {
		$this->completeName = $completeName;
	}

	/**
	* Gets the password of this user
	*
	* @return string The password of this user
	*/
	public function getEmail() {
		return $this->email;
	}
	/**
	* Sets the password of this user
	*
	* @param string $passwd The password of this user
	* @return void
	*/
	public function setEmail($email) {
		$this->email = $email;
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
		if (strlen($this->dni) < 5) {
			$errors["dni"] = "DNI must be at least 5 characters length";

		}
		if (strlen($this->password) < 5) {
			$errors["password"] = "Password must be at least 5 characters length";
		}
		if (sizeof($errors)>0){
			throw new ValidationException($errors, "user is not valid");
		}
	}
}
