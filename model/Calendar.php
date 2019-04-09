<?php
// file: model/Calendar.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Calendar
*
* Represents a calendar for the courts
*
* @author Roi Pérez López
*/
class Calendar {

	/**
	* The calendar id
	* @var id
	*/
    private $calendarId;

	/**
	* When the occupation of the court beggins
	* @var DATETIME
	*/
    private $startDate;

    /**
	* When the occupation of the court ends
	* @var DATETIME
	*/
    private $endDate;

    /**
	* The id of the court
	* @var int
	*/
	private $idCourt;
	
	/**
	* The id of the athlete that books a court
	* @var String
	*/
	private $userId;
	
	/**
	* The type of reserve
	* @var String
	*/
    private $reserveType;
    
	/**
	* The constructor
	*
    * @param DATETIME $startDate
    * @param DATETIME $endDate
    * @param int $idCourt
	*/

	public function __construct($calendarId=NULL, $startDate=NULL, $endDate=NULL, $idCourt=NULL, $userId=NULL, $reserveType) {
        $this->calendarId = $calendarId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->idCourt = $idCourt;
		$this->userId = $userId;
		$this->reserveType = $reserveType;
    }

	public function getCalendarId(){
		return $this->calendarId;
	}

	public function setCalendarId($calendarId){
		$this->calendarId = $calendarId;
	}

	public function getStartDate(){
		return $this->startDate;
	}

	public function setStartDate($startDate){
		$this->startDate = $startDate;
	}

	public function getEndDate(){
		return $this->endDate;
	}

	public function setEndDate($endDate){
		$this->endDate = $endDate;
	}

	public function getIdCourt(){
		return $this->idCourt;
	}

	public function setIdCourt($idCourt){
		$this->idCourt = $idCourt;
	}

	public function getUserId(){
		return $this->userId;
	}

	public function setUserId($userId){
		$this->userId = $userId;
	}

	public function getReserveType(){
		return $this->reserveType;
	}

	public function setReserveType($reserveType){
		$this->reserveType = $reserveType;
	}
}
