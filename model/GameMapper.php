<?php
// file: model/GameMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class GameMapper
* Database interface for Game entities
*/
class GameMapper {

/**
* Reference to the PDO connection
* @var PDO
*/
private $db;

public function __construct() {
    $this->db = PDOConnection::getInstance();
}

public function save($game) {
    $stmt = $this->db->prepare("INSERT INTO Partido values (?,?,?)");
    $stmt->execute(array($game->getIdGame(), $game->getDate(), $game->getCourtId()));
}

public function promote($game) {
    $stmt = $this->db->prepare("INSERT INTO Partido(horario) values (?)");
    $stmt->execute(array($game->getDate()));
}

public function update($game) {
    $stmt = $this->db->prepare("UPDATE Partido SET idPista=?");
    $stmt->execute(array($game->getCourtId()));
}

public function get($game){
    $stmt = $this->db->prepare("SELECT * FROM Partido where idPista=?");
    $stmt->execute(array($game->getCourtId()));
    $game = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($game != null) {
        return new Game(
        $game["idPartido"],  
        $game["horario"],
        $game["idPista"]);
    } else {
        return NULL;
    }
}

public function findById($idGame) {
    $stmt = $this->db->prepare("SELECT * FROM Partido where idPartido=?");
    $stmt->execute(array($idGame));
    $game = $stmt->fetch(PDO::FETCH_ASSOC);

    if($game != null) {
        return new Game(
        $game["idPartido"],   
        $game["horario"],
        $game["idPista"]);
    } else {
        return NULL;
    }
}

public function getAll() {
    $stmt = $this->db->prepare("SELECT * FROM Partido");
    $stmt->execute();
    $games_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $games=array();

    foreach ($games_db as $game) {
        array_push($games, new Game($game["idPartido"],$game["idPista"], $game["horario"]));
    }
    return $games;
}

public function countAthletes($idGame) {
    $stmt = $this->db->prepare("SELECT count(*) FROM Deportistas_Partido where idPartido=?");
    $stmt->execute(array($idGame));
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    return $count["count(*)"];
}

public function addAthlete($idGame, $userId) {
    $stmt = $this->db->prepare("INSERT INTO Deportistas_Partido(idPartido,userId) values (?,?)");
    $stmt->execute(array($idGame,$userId));
}

public function removeAthlete($idGame, $userId) {
    $stmt = $this->db->prepare("DELETE FROM Deportistas_Partido WHERE idPartido=? AND userId=?");
    $stmt->execute(array($idGame,$userId));
}

public function isAthleteInGame($idGame, $userId) {
    $stmt = $this->db->prepare("SELECT count(*) FROM Deportistas_Partido where idPartido=? and userId=?");
    $stmt->execute(array($idGame,$userId));
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    return $count["count(*)"];
}

public function getAllOpen() {
    $stmt = $this->db->prepare("SELECT * FROM Partido");
    $stmt->execute();
    $games_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $games=array();

    foreach ($games_db as $game) {
        $numAthletes = $this->countAthletes($game["idPartido"]);
        if($numAthletes < 4) {
            array_push($games, new Game($game["idPartido"], $game["horario"], $game["idPista"]));
        }
    }
    return $games;
}

}