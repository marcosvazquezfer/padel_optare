<?php

require_once(__DIR__."/../core/PDOConnection.php");

class GroupMapper {

    /**
    * Reference to the PDO connection
    * @var PDO
    */
    private $db;

    public function __construct() {
        $this->db = PDOConnection::getInstance();
    }

    public function save($group) {
        $stmt = $this->db->prepare("INSERT INTO Grupo values (?,?)");
        $stmt->execute(array($group->getIdGroup(), $track->getIdCategory()));
    }

    public function getAll(){
        $stmt = $this->db->prepare("SELECT * FROM Grupo");
        $stmt->execute();
        $groups_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $groups=array();
        foreach ($groups_db as $group) {
            array_push($groups, new Group($group["idGrupo"], $group["idCategoria"]));
        }
        return $groups;
    }
}