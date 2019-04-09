<?php
// file: model/Asistence.php

require_once(__DIR__."/../core/ValidationException.php");

/**
* Class Asistence
*
* Represents a calendar for the courts
*
* @author Diego Pérez Solla
*/
class Asistence {


    private $userId;
    private $idClase;
    private $fecha;
	private $control;
    

    public function __construct($userId=NULL, $idClase=NULL, $fecha=NULL, $control=NULL) {
        $this->userId = $userId;
        $this->idClase = $idClase;
        $this->fecha = $fecha;
        $this->control = $control;
    }

	public function getUserId(){
		return $this->userId;
	}

    public function setUserId($userId){
        $this->userId = $userId;
	}

	public function getClassId(){
        return $this->idClase;
	}

	public function setClassId($idClase){
        $this->idClase = $idClase;
	}

	public function getHorario(){
		return $this->fecha;
	}

    public function setHorario($fecha){
        $this->fecha = $fecha;
	}

	public function getControl(){
		return $this->control;
	}

	public function setControl($control){
		$this->control = $control;
    }
}