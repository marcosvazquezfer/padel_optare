<?php
// file: model/Match.php

require_once(__DIR__."/../core/ValidationException.php");

class Match {

	private $matchId;
	private $result;
	private $coupleId1;
	private $coupleId2;
	private $groupId;
	private $courtId;
	private $feFinal;
	private $winner;
	private $round;
	private $fePre1;
	private $fePre2;
	private $fePre3;
    

	public function __construct($matchId=NULL, $result=NULL, $coupleId1=NULL, $coupleId2=NULL, 
								$groupId=NULL, $courtId=NULL, $feFinal=NULL, $winner=NULL, $round=NULL,$fePre1=NULL,$fePre2=NULL,$fePre3=NULL) {

		$this->matchId = $matchId;
		$this->result = $result;
		$this->coupleId1 = $coupleId1;
		$this->coupleId2 = $coupleId2;
		$this->groupId = $groupId;
		$this->courtId = $courtId;
		$this->feFinal = $feFinal;
		$this->winner = $winner;
		$this->round = $round;
		$this->fePre1=$fePre1;
		$this->fePre2=$fePre2;
		$this->fePre3=$fePre3;
	}

	public function getMatchId() {

		return $this->matchId;
	}

	public function setMatchId($matchId) {

		$this->matchId = $matchId;
    }
    
    public function getResult() {

		return $this->result;
	}

	public function setResult($result) {

		$this->result = $result;
	}
    
    public function getCoupleId1() {

		return $this->coupleId1;
	}

	public function setCoupleId1($coupleId1) {

		$this->coupleId1 = $coupleId1;
    }
    
    public function getCoupleId2() {

		return $this->coupleId2;
	}

	public function setCoupleId2($coupleId2) {

		$this->coupleId2 = $coupleId2;
    }

    public function getGroupId() {

		return $this->groupId;
	}

	public function setGroupId($groupId) {

		$this->groupId = $groupId;
	}
    
  	public function getCourtId() {

		return $this->courtId;
	}

	public function setCourtId($courtId) {

		$this->courtId = $courtId;
	}

	public function getFeFinal() {

		return $this->feFinal;
	}

	public function setFeFinal($feFinal) {

		$this->feFinal = $feFinal;
	}

	public function getFePre1(){
		return $this->fePre1;
	}

	public function setFePre1($fePre1){
		$this->fePre1=$fePre1;
	}
	public function getFePre2(){
		return $this->fePre2;
	}

	public function setFePre2($fePre2){
		$this->fePre2=$fePre2;
	}
	public function getFePre3(){
		return $this->fePre3;
	}

	public function setFePre3($fePre3){
		$this->fePre3=$fePre3;
	}

	public function getWinner() {

		return $this->winner;
	}

	public function setWinner($winner) {

		$this->winner = $winner;
	}
	
	public function getRound() {

		return $this->round;
	}

	public function setRound($round) {

		$this->round = $round;
    }
}
