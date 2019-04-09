<?php
// file: model/Game.php

require_once(__DIR__."/../core/ValidationException.php");

class Game {
	private $idGame;
	private $courtId;
	private $date;

	public function __construct($idGame=NULL, $date) {
		$this->idGame = $idGame;
		$this->date = $date;
		$this->courtId = null;
	}

	public function getIdGame(){
		return $this->idGame;
	} 

	public function setIdGame($idGame){
		$this->idGame= $idGame;
	}

	public function getCourtId() {
		return $this->courtId;
	}

	public function setCourtId($courtId) {
		$this->courtId = $courtId;
    }
    
    public function getDate() {
		return $this->date;
	}

	public function setDate($date) {
		$this->date = $date;
    }
    
}
