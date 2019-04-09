<?php

require_once(__DIR__."/../core/ValidationException.php");

class TrainingClass {
	private $classId;
	private $level;
	private $creator;
	private $trainer;
	private $date;

	public function __construct($classId, $level, $creator, $trainer, $date) {
		$this->classId = $classId;
		$this->level = $level;
		$this->creator = $creator;
		$this->trainer = $trainer;
		$this->date = $date;
	}

	public function getClassId(){
		return $this->classId;
	}

	public function setClassId($classId){
		$this->classId = $classId;
	}

	public function getLevel(){
		return $this->level;
	}

	public function setLevel($level){
		$this->level = $level;
	}

	public function getCreator(){
		return $this->creator;
	}

	public function setCreator($creator){
		$this->creator = $creator;
	}

	public function getTrainer(){
		return $this->trainer;
	}

	public function setTrainer($trainer){
		$this->trainer = $trainer;
	}

	public function getDate(){
		return $this->date;
	}

	public function setDate($date){
		$this->date = $date;
	}
}
