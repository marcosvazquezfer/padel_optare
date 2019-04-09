<?php
// file: model/MatchMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class MatchMapper
* Database interface for Game entities
*/
class MatchMapper {

/**
* Reference to the PDO connection
* @var PDO
*/
private $db;

public function __construct() {

    $this->db = PDOConnection::getInstance();
}

public function findByGroupId($groupId){

    $stmt = $this->db->prepare("SELECT * FROM Enfrentamiento WHERE idGrupo=?");
    $stmt->execute(array($groupId));
    $matches_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $matches=array();

    foreach ($matches_db as $match) {

        array_push($matches, new Match($match["idEnfrentamiento"], $match["resultado"], $match["idPareja1"], $match["idPareja2"], $match["idGrupo"], $match["idPista"], $match["ganador"], $match["ronda"]));
    }

    return $matches;
}

public function findByGroupIdRound($groupId, $round){

    $stmt = $this->db->prepare("SELECT * FROM Enfrentamiento WHERE idGrupo=? AND ronda=?");
    $stmt->execute(array($groupId, $round));
    $matches_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $matches=array();

    foreach ($matches_db as $match) {

        array_push($matches, new Match($match["idEnfrentamiento"], $match["resultado"], $match["idPareja1"], $match["idPareja2"], $match["idGrupo"], $match["idPista"], $match["horario"], $match["ganador"], $match["ronda"]));
    }

    return $matches;
}

public function findByGroupIdRoundDist($groupId, $round){

    $stmt = $this->db->prepare("SELECT * FROM Enfrentamiento WHERE idGrupo=? AND ronda!=?");
    $stmt->execute(array($groupId, $round));
    $matches_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $matches=array();

    foreach ($matches_db as $match) {

        array_push($matches, new Match($match["idEnfrentamiento"], $match["resultado"], $match["idPareja1"], $match["idPareja2"], $match["idGrupo"], $match["idPista"], $match["horario"], $match["ganador"], $match["ronda"]));
    }

    return $matches;
}

public function save($match) {

    $stmt = $this->db->prepare("INSERT INTO Enfrentamiento(idPareja1, idPareja2, idGrupo, ronda) values (?,?,?,?)");
    $stmt->execute(array($match->getCoupleId1(), $match->getCoupleId2(), $match->getGroupId(), $match->getRound()));
}

public function savePreselectedFetch($matchId,$fePre1,$fePre2,$fePre3) {
    $stmt = $this->db->prepare("DELETE FROM FechasPreseleccionadas WHERE idEnfrentamiento = ?");
    $stmt->execute(array($matchId));
    $stmt = $this->db->prepare("INSERT INTO FechasPreseleccionadas(idEnfrentamiento, fecha) values (?,?)");
    $stmt->execute(array($matchId, $fePre1));
    $stmt = $this->db->prepare("INSERT INTO FechasPreseleccionadas(idEnfrentamiento, fecha) values (?,?)");
    $stmt->execute(array($matchId, $fePre2));
    $stmt = $this->db->prepare("INSERT INTO FechasPreseleccionadas(idEnfrentamiento, fecha) values (?,?)");
    $stmt->execute(array($matchId, $fePre3));
}

public function getPreselectedDates($matchId) {
    $stmt = $this->db->prepare("SELECT * FROM FechasPreseleccionadas WHERE idEnfrentamiento=?");
    $stmt->execute(array($matchId));
    $dates_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $dates=array();

    foreach ($dates_db as $date) {
        array_push($dates, $date["fecha"]);
    }

    return $dates;
}

public function saveDateTime($date, $matchId) {

    $stmt = $this->db->prepare("UPDATE Enfrentamiento SET horario=? WHERE idEnfrentamiento=?");
    $stmt->execute(array($date, $matchId));
}

public function updateResult($groupId, $coupleId1, $coupleId2, $result, $winner) {

    $stmt = $this->db->prepare("UPDATE Enfrentamiento SET resultado=?, ganador=? WHERE idGrupo=? AND idPareja1=? AND idPareja2=?");
    $stmt->execute(array($result, $winner, $groupId, $coupleId1, $coupleId2));
}

public function deleteResult($groupId, $coupleId1, $coupleId2, $result, $winner) {

    $stmt = $this->db->prepare("UPDATE Enfrentamiento SET resultado=?, ganador=? WHERE idGrupo=? AND idPareja1=? AND idPareja2=?");
    $stmt->execute(array($result, $winner, $groupId, $coupleId1, $coupleId2));
}

public function addAthlete($game,$idAthlete){
    $stmt = $this->db->prepare("INSERT INTO Deportistas_Partido values (?,?,?)");
    $stmt->execute(array($game->getIdPista(), $game->getDate(),$idAthlete));
}

public function findById($matchId) {
    $stmt = $this->db->prepare("SELECT idEnfrentamiento,horario FROM Enfrentamiento where idEnfrentamiento=?");
    $stmt->execute(array($matchId));
    $match = $stmt->fetch(PDO::FETCH_ASSOC);

    if($match != null) {
        return new Match(
        $match["idEnfrentamiento"],
        null,
        null,
        null,
        null,
        null,
        null,
        $match["horario"]);
    } else {
        return NULL;
    }
}


public function getMatchesByAthlete($championship,$athlete){
    $stmt = $this->db->prepare("SELECT * From Enfrentamiento,Pareja,Grupo,FechasPreseleccionadas WHERE Enfrentamiento.idGrupo=Grupo.idGrupo and Enfrentamiento.idEnfrentamiento=FechasPreseleccionadas.idEnfrentamiento and(Enfrentamiento.idPareja1=Pareja.idPareja OR Enfrentamiento.idPareja2=Pareja.idPareja) and Pareja.capitan=? and Grupo.idCampeonato=?");
    $stmt->execute(array($athlete,$championship));
    $matches_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $matches=array();

    foreach ($matches_db as $match) {
            array_push($matches, new Match($match["idEnfrentamiento"], $match["resultado"], $match["idPareja1"],$match["idPareja2"],$match["idGrupo"],$match["idPista"],$match["horario"]));
    }
    return $matches;
}
}