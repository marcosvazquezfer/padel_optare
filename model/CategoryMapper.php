<?php
// file: model/CategoryMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class CategoryMapper
* Database interface for User entities
*/
class CategoryMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;
	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Loads all Categories from the database
	*
	*
	* @throws PDOException if a database error occurs
	* @return all Categories The Category instances. NULL
	* if the Category is not found
	*/
	public function findAll(){

		$stmt = $this->db->query("SELECT * FROM Categoria");
		$categories_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$categories = array();

		foreach ($categories_db as $category) {
			
			array_push($categories, new Category($category["idCategoria"], $category["genero"], $category["nivel"]));
		}

		return $categories;
	}

	/**
	* Loads a Category from the database given its id
	*
	*
	* @throws PDOException if a database error occurs
	* @return Category The Category instances. NULL
	* if the Category is not found
	*/
	public function findById($categoryId){

		$stmt = $this->db->prepare("SELECT * FROM Categoria WHERE idCategoria=?");
		$stmt->execute(array($categoryId->getCategoryId()));
		$category = $stmt->fetch(PDO::FETCH_ASSOC);

		if($category != null) {

			return new Category(
			$category["idCategoria"],
			$category["genero"],
			$category["nivel"]);
		} 
		else {
			return NULL;
		}
	}

	public function findById2($categoryId){

		$stmt = $this->db->prepare("SELECT * FROM Categoria WHERE idCategoria=?");
		$stmt->execute(array($categoryId));
		$category = $stmt->fetch(PDO::FETCH_ASSOC);

		if($category != null) {

			return new Category(
			$category["idCategoria"],
			$category["genero"],
			$category["nivel"]);
		} 
		else {
			return NULL;
		}
	}

	public function findChampionshipIdByCoupleId($coupleId) {

		$stmt = $this->db->prepare("SELECT idCampeonato FROM Parejas_Categoria WHERE idPareja=?");
		$stmt->execute(array($coupleId));
		$championships_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$championships = array();

		foreach ($championships_db as $championship) {
			array_push($championships, $championship["idCampeonato"]);
		}

		return $championships;
	}

	/**
	* Loads Categories of a Championship from the database given championship id
	*
	* @throws PDOException if a database error occurs
	* @return Championship The Championship instances. NULL
	* if the Championship is not found
	*/
	public function findByChampionshipId($championshipId){

		$stmt = $this->db->prepare("SELECT * FROM Categorias_Campeonato WHERE idCampeonato=?");
		$stmt->execute(array($championshipId));
		$categories_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$categories = array();

		foreach ($categories_db as $category) {
			
			array_push($categories, $category["idCategoria"]);
		}

		return $categories;
	}

	public function findCategoriesByChampionshipId($championshipId){

		$stmt = $this->db->prepare("SELECT
		C.idCategoria as 'Category.categoryId',
		C.genero as 'Category.genre',
		C.nivel as 'Category.level'

		FROM Categorias_Campeonato A LEFT OUTER JOIN Categoria C
		ON A.idCategoria = C.idCategoria
		WHERE
		A.idCampeonato=?");

		$stmt->execute(array($championshipId));
		$arrays_db= $stmt->fetchAll(PDO::FETCH_ASSOC);

		$arrays = array();

		foreach($arrays_db as $array){

			array_push($arrays, new Category($array["Category.categoryId"],
			$array["Category.genre"],
			$array["Category.level"]));
		}
		return $arrays;
	}
}