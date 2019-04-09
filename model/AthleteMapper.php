<?php
// file: model/AthleteMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class AthleteMapper
* Database interface for User entities
*/

class AthleteMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Retrieves all championships
	*
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Championship instances
	*/
	public function findAll() {

		$stmt = $this->db->query("SELECT * FROM Deportista");
		$athletes_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$athletes = array();

		foreach ($athletes_db as $athlete) {
			
			array_push($athletes, new Athlete($athlete["userId"], $athlete["isSocio"], $athlete["nivel"], $athlete["genero"]));
		}

		return $athletes;
	}

	public function findById($captainId){

		$stmt = $this->db->prepare("SELECT * FROM Deportista WHERE userId=?");
		$stmt->execute(array($captainId));
		$athlete = $stmt->fetch(PDO::FETCH_ASSOC);

		if($athlete != null) {

			return new Athlete(
			$athlete["userId"],
			$athlete["isSocio"],
			$athlete["nivel"],
			$athlete["genero"]);
		} 
		else {
			return NULL;
		}
	}

	public function save($athlete) {
		$stmt = $this->db->prepare("INSERT INTO Deportista values (?,?,?,?)");
		$stmt->execute(array($athlete->getDni(), (int)$athlete->getIsPartner(),$athlete->getLevel(),$athlete->getGender()));
	}

    public function get($registeredUser){
        $stmt = $this->db->prepare("SELECT * FROM Deportista where userId=?");
        $stmt->execute(array($registeredUser->getUserId()));
        $athlete = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($athlete != null) {
			return new Athlete(
			$athlete["userId"],
			$athlete["isSocio"],
			$athlete["nivel"],
			$athlete["genero"]);
		} else {
			return NULL;
		}

    }
}
