<?php
// file: model/Campeonato.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Championship
*
* Represents a Championship in the web. A Championship
* contains a list of Categories
*
* @author Marcos Vázquez Fernández
*/
class Championship {

	/**
	* The id of this championship
	* @var int
	*/
	private $championshipId;

	/**
	* The name of this championship
	* @var string
	*/
	private $name;

	/**
	* The max number of participants of this championship
	* @var int
	*/
	private $maxParticipants;

	/**
	* The normative of this championship
	* @var file
	*/
	private $normative;

	/**
	* The dead line of this championship
	* @var DATETIME
	*/
	private $deadLine;

	/**
	* The list of categories of this championship
	* @var mixed
	*/
	private $categories;
	

	/**
	* The constructor
	*
	* @param int $championshipId The id of the championship
	* @param string $name The name of the championship
	* @param int $maxParticipants The max participants of the championship
	* @param file $normative The normative of the championship
	* @param DATETIME $deadLine The dead line of the championship
	* @param mixed $categories The list of categories
	*/
	public function __construct($championshipId=NULL, $name=NULL, $maxParticipants=NULL, $normative=NULL, $deadLine=NULL, array $categories=NULL) {

		$this->championshipId = $championshipId;
		$this->name = $name;
		$this->maxParticipants = $maxParticipants;
		$this->normative = $normative;
		$this->deadLine = $deadLine;
		$this->categories = $categories;
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
	* Gets the name of this championship
	*
	* @return string The name of this championship
	*/
	public function getName() {

		return $this->name;
	}

	/**
	* Sets the name of this championship
	*
	* @param string $name the name of this championship
	* @return void
	*/
	public function setName($name) {

		$this->name = $name;
	}

	/**
	* Gets the number of max participants of this championship
	*
	* @return int The max participants of this championship
	*/
	public function getMaxParticipants() {

		return $this->maxParticipants;
	}

	/**
	* Sets the number of max participants of this championship
	*
	* @param int $maxParticipants the max participants of this championship
	* @return void
	*/
	public function setMaxParticipants($maxParticipants) {

		$this->maxParticipants = $maxParticipants;
	}

	/**
	* Gets the normative of this championship
	*
	* @return file The normative of this championship
	*/
	public function getNormative() {

		return $this->normative;
	}

	/**
	* Sets the normative of this championship
	*
	* @param file $normative the normative of this championship
	* @return void
	*/
	public function setNormative($normative) {

		$this->normative = $normative;
	}

	/**
	* Gets the dead line of this championship
	*
	* @return DATETIME The dead line of this championship
	*/
	public function getDeadLine() {

		return $this->deadLine;
	}

	/**
	* Sets the dead line of this championship
	*
	* @param DATETIME $deadLine the dead line of this championship
	* @return void
	*/
	public function setDeadLine($deadLine) {

		$this->deadLine = $deadLine;
	}

	/**
	* Gets the list of categories of this championship
	*
	* @return mixed The list of categories of this championship
	*/
	public function getCategories() {

		return $this->categories;
	}

	/**
	* Sets the categories of the championship
	*
	* @param mixed $categories the categories list of this championship
	* @return void
	*/
	public function setCategories(array $categories) {

		$this->categories = $categories;
	}

	/**
	* Checks if the current instance is valid
	* for being updated in the database.
	*
	* @throws ValidationException if the instance is
	* not valid
	*
	* @return void
	*/
	public function checkIsValidForCreate() {

        $errors = array();
        
		if (strlen(trim($this->name)) == 0 ) {

			$errors["name"] = "name is mandatory";
        }
        
		if (strlen(trim($this->maxParticipants)) == 0 ) {

			$errors["maxParticipants"] = "maxParticipants is mandatory";
        }
        
		if ($this->normative == NULL ) {

			$errors["normative"] = "normative is mandatory";
		}

		if ($this->deadLine == NULL ) {

			$errors["deadLine"] = "dead line is mandatory";
		}

		if (sizeof($errors) > 0){
			throw new ValidationException($errors, "championship is not valid");
		}
	}

	/**
	* Checks if the current instance is valid
	* for being updated in the database.
	*
	* @throws ValidationException if the instance is
	* not valid
	*
	* @return void
	*/
	public function checkIsValidForUpdate() {

		$errors = array();

		if (!isset($this->championshipId)) {
			$errors["championshipId"] = "championshipId is mandatory";
		}

		try{
			$this->checkIsValidForCreate();
        }
        catch(ValidationException $ex) {

			foreach ($ex->getErrors() as $key=>$error) {

				$errors[$key] = $error;
			}
        }
        
		if (sizeof($errors) > 0) {
            
			throw new ValidationException($errors, "post is not valid");
		}
	}
}
