<?php
// file: model/CouplesCategory.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class CouplesCategory
*
* Represents the couples of a category in a championship
*
* @author Marcos Vázquez Fernández
*/
class CouplesCategory {

	/**
	* A couple of the category
	* @var Couple
	*/
	private $couple;
	
	/**
	* A category of the championship
	* @var Category
	*/
	private $category;
	
	/**
	* The championship
	* @var Championship
	*/
    private $championship;
    
	/**
	* The constructor
	*
	* @param Couple $couple A couple of the category
	* @param Category $category A category of the championship
	* @param Championship $championship The championship
	*/
	public function __construct(Couple $couple=NULL, Category $category=NULL, Championship $championship=NULL) {

		$this->couple = $couple;
		$this->category = $category;
		$this->championship = $championship;
	}

	/**
	* Gets a couple of this category
	*
	* @return Couple A couple of this category
	*/
	public function getCouple() {

		return $this->couple;
	}

	/**
	* Sets a couple of this category
	*
	* @param Couple $couple A couple of this category
	* @return void
	*/
	public function setCouple(Couple $couple) {

		$this->couple = $couple;
	}

	/**
	* Gets a category of this championship
	*
	* @return Category A category of this championship
	*/
	public function getCategory() {

		return $this->category;
	}

	/**
	* Sets a category of this championship
	*
	* @param Category $category A category of this championship
	* @return void
	*/
	public function setCategory(Category $category) {

		$this->category = $category;
	}

	/**
	* Gets the championship
	*
	* @return Championship the championship
	*/
	public function getChampionship() {

		return $this->championship;
	}

	/**
	* Sets the championship
	*
	* @param Championship $championship The championship
	* @return void
	*/
	public function setChampionship(Championship $championship) {

		$this->championship = $championship;
	}
}
