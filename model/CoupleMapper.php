<?php
// file: model/CampeonatoMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class CoupleMapper
* Database interface for Couple entities
*/
class CoupleMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {

		$this->db = PDOConnection::getInstance();
	}

	/**
	* Retrieves all couples from a group given its groupId
	*
	*
	* @throws PDOException if a database error occurs
	* @return mixed $coupleId
	*/
	public function findAllByGroupId($groupId) {

		$stmt = $this->db->prepare("SELECT idPareja FROM Parejas_Grupo WHERE idGrupo=?");
		$stmt->execute(array($groupId));
		$couples_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$couples = array();

		foreach ($couples_db as $couple) {
			array_push($couples, $couple["idPareja"]);
		}

		return $couples;
	}

	public function findAllByGroupIdRound($groupId, $round) {

		$stmt = $this->db->prepare("SELECT DISTINCT idPareja FROM Parejas_Grupo, Enfrentamiento WHERE Parejas_Grupo.idGrupo=Enfrentamiento.idGrupo AND Parejas_Grupo.idGrupo=? AND Enfrentamiento.ronda!=?");
		$stmt->execute(array($groupId, $round));
		$couples_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$couples = array();

		foreach ($couples_db as $couple) {
			array_push($couples, $couple["idPareja"]);
		}

		return $couples;
	}

	public function findByUserId($userId) {

		$stmt = $this->db->prepare("SELECT idPareja FROM Pareja WHERE (capitan=? OR par=?)");
		$stmt->execute(array($userId, $userId));
		$couples_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$couples = array();

		foreach ($couples_db as $couple) {
			array_push($couples, $couple["idPareja"]);
		}

		return $couples;
	}

	/**
	* Retrieves a couple entitie contains the dni of captain and pair
	*
	*
	* @throws PDOException if a database error occurs
	* @return Couple $couple
	*/
	public function findDnisById($coupleId) {

		$stmt = $this->db->prepare("SELECT * FROM Pareja WHERE idPareja=?");
		$stmt->execute(array($coupleId));
		$couple = $stmt->fetch(PDO::FETCH_ASSOC);

		if($couple != null) {

			return new Couple(
			$couple["idPareja"],
			new User($couple["capitan"]),
			new User($couple["par"]),
			$couple["idGrupo"]);
		} 
		else {
			return NULL;
		}
	}

	/**
	* Retrieves the name of the user wich dni is given dni
	*
	*
	* @throws PDOException if a database error occurs
	* @return $name
	*/
	public function findNameByDni($dni) {

		$stmt = $this->db->prepare("SELECT * FROM Usuario_Registrado WHERE userId=?");
		$stmt->execute(array($dni));
		$name = $stmt->fetch(PDO::FETCH_ASSOC);

		if($name != null) {

			return $name["nombreCompleto"];
		} 
		else {
			return NULL;
		}
	}
	
	/**
	* Retrieves all win matches of a couple given its coupleId and groupId
	*
	*
	* @throws PDOException if a database error occurs
	* @return mixed $coupleId
	*/
	public function findWin($groupId, $coupleId) {

		$stmt = $this->db->prepare("SELECT idEnfrentamiento FROM Enfrentamiento WHERE idGrupo=? AND ganador=?");
		$stmt->execute(array($groupId, $coupleId));
		$matches_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$matches = array();

		foreach ($matches_db as $match) {
			array_push($matches, $match["idEnfrentamiento"]);
		}

		return $matches;
	}
	
	/**
	* Retrieves all lost matches of a couple given its coupleId and groupId
	*
	*
	* @throws PDOException if a database error occurs
	* @return mixed $coupleId
	*/
	public function findLost($groupId, $coupleId) {

		$stmt = $this->db->prepare("SELECT idEnfrentamiento FROM Enfrentamiento WHERE idGrupo=? AND ganador!=? AND (idPareja1=? OR idPareja2=?)");
		$stmt->execute(array($groupId, $coupleId, $coupleId, $coupleId));
		$matches_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$matches = array();

		foreach ($matches_db as $match) {
			array_push($matches, $match["idEnfrentamiento"]);
		}

		return $matches;
    }

	/**
	* Retrieves the id of a couple from its categoyId and captain
	*
	*
	* @throws PDOException if a database error occurs
	* @return int $coupleId
	*/
	public function findCoupleIdByCaptainPair($captain, $pair) {

		$stmt = $this->db->prepare("SELECT idPareja FROM Pareja WHERE capitan=? AND par=?");
		$stmt->execute(array($captain, $pair));
		$couple = $stmt->fetch(PDO::FETCH_ASSOC);

		if($couple != null){

			return $couple["idPareja"];
		}
		else{
			return NULL;
		}
    }

	/**
	* Saves a Captain of a Couple into the database
	*
	* @param int $categoryId The id of the category where the user wants to inscribe
	* @param string $captain The captain of the couple
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function saveCouple($captain, $pair) {

		$stmt = $this->db->prepare("INSERT INTO Pareja(capitan, par) values (?,?)");
		$stmt->execute(array($captain, $pair));
	}

	/**
	* Saves a Couple into a Category into the database
	*
	* @param int $coupleId The id of the couple
	* @param int $categoryId The id of the category where the user wants to inscribe
	* @param int $categoryId The id of the championship where the category is
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function saveCoupleToCategory($coupleId, $categoryId, $championshipId) {

		$stmt = $this->db->prepare("INSERT INTO Parejas_Categoria(idPareja, idCategoria, IdCampeonato) values (?,?,?)");
		$stmt->execute(array($coupleId, $categoryId, $championshipId));
	}

	/**
	* Saves a Couple into a Group of a Category into the database
	*
	* @param $groupId The id of the group
	* @param $coupleId The id of the couple
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function saveCoupleIntoGroup($groupId, $coupleId) {

		$stmt = $this->db->prepare("INSERT INTO Parejas_Grupo(idGrupo, idPareja) values (?,?)");
		$stmt->execute(array($groupId, $coupleId));
	}

	/**
	* Updates a Group of a Couple in the database
	*
	* @param $coupleId The id of the couple to be updated
	* @param $groupId The id of the group to be updated
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function updateGroupOfACouple($coupleId, $groupId) {

		$stmt = $this->db->prepare("UPDATE Pareja SET idGrupo=? WHERE idPareja=?");
		$stmt->execute(array($groupId, $coupleId));
	}

}