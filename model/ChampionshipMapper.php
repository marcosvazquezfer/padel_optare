<?php
// file: model/CampeonatoMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/CategoriesChampionship.php");
/**
* Class ChampionshipMapper
* Database interface for User entities
*/
class ChampionshipMapper {

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

		$stmt = $this->db->query("SELECT * FROM Campeonato");
		$championships_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$championships = array();

		foreach ($championships_db as $championship) {
			
			array_push($championships, new Championship($championship["idCampeonato"], $championship["nombre"], $championship["maxParticipantes"], $championship["normativa"], $championship["fechaLimite"]));
		}

		return $championships;
	}

	/**
	* Loads a Championship from the database given its id
	*
	*
	* @throws PDOException if a database error occurs
	* @return Championship The Championship instances. NULL
	* if the Championship is not found
	*/
	public function findById($championshipId){

		$stmt = $this->db->prepare("SELECT * FROM Campeonato WHERE idCampeonato=?");
		$stmt->execute(array($championshipId));
		$championship = $stmt->fetch(PDO::FETCH_ASSOC);

		if($championship != null) {

			return new Championship(
			$championship["idCampeonato"],
			$championship["nombre"],
			$championship["maxParticipantes"],
			$championship["normativa"],
			$championship["fechaLimite"]);
		} 
		else {
			return NULL;
		}
	}

	/**
	* Loads the id of a championship from the database given its name
	*
	*
	* @throws PDOException if a database error occurs
	* @return Championship The Championship instances. NULL
	* if the Championship is not found
	*/
	public function findIdByName($name){

		$stmt = $this->db->prepare("SELECT * FROM Campeonato WHERE nombre=?");
		$stmt->execute(array($name));
		$championship = $stmt->fetch(PDO::FETCH_ASSOC);

		if($championship != null) {

			return $championship["idCampeonato"];
		} 
		else {
			return NULL;
		}
	}

	/**
	* Loads Categories of a Championship from the database given championship id
	*
	*
	* @throws PDOException if a database error occurs
	* @return Championship The Championship instances. NULL
	* if the Championship is not found
	*/
	public function findCategoriesByChampionshipId($championshipId){

		$stmt = $this->db->prepare("SELECT idCategoria FROM Categorias_Campeonato WHERE idCampeonato=?");
		$stmt->execute(array($championshipId));
		$categories_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$categories = array();

		foreach ($categories_db as $category) {
			
			array_push($categories, $category["idCategoria"]);
		}

		return $categories;
	}

	/**
	* Loads the groups of a championship from the database given championship id
	*
	*
	* @throws PDOException if a database error occurs
	* @return Post The Post instances (without comments). NULL
	* if the Groups is not found
	*/
	public function findGroups($categoryId, $championshipId){
		
		$stmt = $this->db->prepare("SELECT idGrupo
		FROM Grupo
		WHERE idCampeonato=? AND idCategoria=?");
		$stmt->execute(array($championshipId, $categoryId));
		$groups_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$groups = array();

		foreach ($groups_db as $group) {
			
			array_push($groups, $group["idGrupo"]);
		}

		return $groups;
	}

	/**
	* Loads a Post from the database given its id
	*
	* It includes all the comments
	*
	* @throws PDOException if a database error occurs
	* @return Post The Post instances (without comments). NULL
	* if the Post is not found
	*/
	public function findByIdWithCategories($championshipId){

		$stmt = $this->db->prepare("SELECT * FROM Categorias_Campeonato WHERE idCampeonato=?");
		$stmt->execute(array($championshipId));
		$categories_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$categories = array();

		foreach ($categories_db as $category) {
			
			array_push($categories, new CategoriesChampionship($category["idCampeonato"], $category["idCategoria"]));
		}

		return $categories;
	}

	/**
	* Retrieves all administrators
	*
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Administrator instances
	*/
	public function findAdministrators() {

		$stmt = $this->db->query("SELECT * FROM Administrador");
		$administrators_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$administrators = array();

		foreach ($administrators_db as $administrator) {
			
			array_push($administrators, new Administrator($administrator["userId"]));
		}

		return $administrators;
	}

	/**
	* Retrieves all couples of a category
	*
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Couples instances
	*/
	public function findCouples($categoryId, $championshipId) {

		$stmt = $this->db->prepare("SELECT idPareja FROM Parejas_Categoria WHERE idCampeonato=? AND idCategoria=?");
		$stmt->execute(array($championshipId, $categoryId));
		$couples_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$couples = array();

		foreach ($couples_db as $couple) {
			
			array_push($couples, $couple["idPareja"]);
		}

		return $couples;
	}

	/**
	* Retrieves all couples of a category
	*
	*
	* @throws PDOException if a database error occurs
	* @return mixed Array of Couples instances
	*/
	public function findCouplesByGroupId($groupId) {

		$stmt = $this->db->prepare("SELECT idPareja FROM Parejas_Grupo WHERE idGrupo=?");
		$stmt->execute(array($groupId));
		$couples_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$couples = array();

		foreach ($couples_db as $couple) {
			
			array_push($couples, $couple["idPareja"]);
		}

		return $couples;
	}
	
	/**
	* Saves a Championship into the database
	*
	* @param Championship $championship The championship to be saved
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function save($championship) {

		$stmt = $this->db->prepare("INSERT INTO Campeonato(nombre, maxParticipantes, normativa, fechaLimite) values (?,?,?,?)");
		$stmt->execute(array($championship->getName(),$championship->getMaxParticipants(),$championship->getNormative(), $championship->getDeadLine()));
	}

	/**
	* Saves a Group of a Category into the database
	*
	* @param $championshipId The id of the championship
	* @param $categoryId The id of the category
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function saveGroup($championshipId, $categoryId) {

		$stmt = $this->db->prepare("INSERT INTO Grupo(idCampeonato, idCategoria) values (?,?)");
		$stmt->execute(array($championshipId, $categoryId));

		return $this->db->lastInsertId();
	}
	
	/**
	* Saves a match of a Group into the database
	*
	* @param $coupleId1 The id of the couple 1
	* @param $coupleId2 The id of the couple 2
	* @param $groupId The id of the group
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function saveMatch($coupleId1, $coupleId2, $groupId, $round) {

		$stmt = $this->db->prepare("INSERT INTO Enfrentamiento(idPareja1, idPareja2, idGrupo, ronda) values (?,?,?,?)");
		$stmt->execute(array($coupleId1, $coupleId2, $groupId, $round));
	}

	/**
	* Saves a match of a Group into the database
	*
	* @param $coupleId1 The id of the couple 1
	* @param $coupleId2 The id of the couple 2
	* @param $groupId The id of the group
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function saveCategoryIntoChampionship($championshipId, $categoryId) {

		$stmt = $this->db->prepare("INSERT INTO Categorias_Campeonato(idCampeonato, idCategoria) values (?,?)");
		$stmt->execute(array($championshipId, $categoryId));
	}
	
	/**
	* Updates a Championship in the database
	*
	* @param Championship $championship The championship to be updated
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function update(Championship $championship) {

		$stmt = $this->db->prepare("UPDATE Campeonato set nombre=?, maxParticipantes=?, normativa=?, fechaLimite=? where idCampeonato=?");
		$stmt->execute(array($championship->getName(), $championship->getMaxParticipants(), $championship->getNormative(), $championship->getDeadLine(), $championship->getChampionshipId()));
	}

	/**
	* Deletes a Championship into the database
	*
	* @param Championship $championship The championship to be deleted
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function delete(Championship $championship) {

		$stmt = $this->db->prepare("DELETE from Campeonato WHERE idCampeonato=?");
		$stmt->execute(array($championship->getChampionshipId()));
	}
}