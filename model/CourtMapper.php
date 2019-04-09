<?php
// file: model/CourtMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

require_once(__DIR__."/../model/Calendar.php");

/**
* Class GameMapper
* Database interface for Game entities
*/
class CourtMapper {

    /**
    * Reference to the PDO connection
    * @var PDO
    */
    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    /**
	* Retrieves all courts
	*
	*/
	public function findAll() {

		$stmt = $this->db->query("SELECT * FROM Pista");
		$courts_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$courts = array();

		foreach ($courts_db as $court) {
			
			array_push($courts, new Court($court["idPista"], $court["tipoSuelo"]));
		}

		return $courts;
    }
    
    /**
	* Retrieves the occupation of a given court
	*
	*/
	public function findOccupation($now, $courtId) {

        $stmt = $this->db->prepare("SELECT * FROM Calendario WHERE FechaHoraInicio>=? AND idPista=?");
        $stmt->execute(array($now, $courtId));
		$occupations_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $occupations = array();

		foreach ($occupations_db as $occupation) {
			
			array_push($occupations, new Calendar($occupation["idCalendario"], $occupation["FechaHoraInicio"], $occupation["FechaHoraFin"], $occupation["idPista"], $occupation["userId"], $occupation["tipoReserva"]));
		}

		return $occupations;
	}

    public function getAll(){
        $stmt = $this->db->prepare("SELECT * FROM Pista");
        $stmt->execute();
        $courts_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $courts=array();
        foreach ($courts_db as $court) {
            array_push($courts, new Court($court["idPista"], $court["tipoPista"]));
        }
        return $courts;
    }

    public function findById($courtId){

        $stmt = $this->db->prepare("SELECT * FROM Pista where idPista=?");
        $stmt->execute(array($courtId));
        $court = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($court != null) {
            return new Court(
                $court["idPista"],
                $court["tipoSuelo"],
                $court["horaInicio"],
                $court["horaFin"]
            );
        } else {
            return NULL;
        }
    }

    public function get($court){
        $stmt = $this->db->prepare("SELECT * FROM Pista where idPista=?");
        $stmt->execute(array($court->getIdCourt()));
        $court = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($court != null) {
            return new Court(
                $court["idPista"],
                $court["tipoPista"]
            );
        } else {
            return NULL;
        }
    }

    /**
	* Adds a new Court into database
	*
	*/
	public function add($courtType, $timeStart, $timeEnd) {

        $stmt = $this->db->prepare("INSERT INTO Pista(tipoSuelo,horaInicio,horaFin) values (?,?,?)");
        $stmt->execute(array($courtType, $timeStart, $timeEnd));
	}

    public function save($court) {
        $stmt = $this->db->prepare("INSERT INTO Pista values (?,?)");
        $stmt->execute(array($court->getIdCourt(), $court->getTypeCourt()));
    }

    /**
	* Deletes a Court into the database
	*
	*/
	public function delete($courtId) {

		$stmt = $this->db->prepare("DELETE from Pista WHERE idPista=?");
		$stmt->execute(array($courtId));
	}
}