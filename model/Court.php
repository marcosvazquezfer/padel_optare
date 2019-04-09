<?php

require_once(__DIR__."/../core/ValidationException.php");

class Court {
	private $idCourt;
	private $typeCourt;
	private $timeStart;
	private $timeEnd;

	public function __construct($idCourt=NULL, $typeCourt=NULL, $timeStart=NULL, $timeEnd=NULL) {

		$this->idCourt = $idCourt;
		$this->typeCourt = $typeCourt;
		$this->timeStart = $timeStart;
		$this->timeEnd = $timeEnd;
	}


	public function getIdCourt() {
		return $this->idCourt;
	}

	
	public function setIdCourt($idCourt) {
		$this->idCourt = $idCourt;
	}

	public function getTypeCourt() {
		return $this->typeCourt;
	}
	
	public function setTypeCourt($typeCourt) {
		$this->typeCourt = $typeCourt;
	}

	public function getTimeStart() {
		return $this->timeStart;
	}
	
	public function setTimeStart($timeStart) {
		$this->timeStart = $timeStart;
	}
	public function getTimeEnd() {
		return $this->timeEnd;
	}
	
	public function setTimeEnd($timeEnd) {
		$this->timeEnd = $timeEnd;
	}
}
