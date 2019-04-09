<?php

require_once __DIR__ . "/../core/PDOConnection.php";

class AsistenceMapper
{

    private $db;
    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function update($userId,$fecha,$control,$idClase)
    {
        $stmt = $this->db->prepare("UPDATE Asistencia SET control=? WHERE fecha=? AND idClase=? AND userId=?");
        $stmt->execute(array($control, $fecha, $idClase, $userId));
        
    }

    public function get($idClase,$fecha)
    {
        $stmt = $this->db->prepare("SELECT * FROM `Asistencia` WHERE `idClase` = ? AND `fecha` = ?");
        $stmt->execute(array($idClase,$fecha));
        $asistence_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $asistence=array();

        foreach ($asistence_db as $asist) {
            array_push($asistence, new Asistence($asist["userId"],$asist["idClase"], $asist["fecha"],$asist["control"]));
        }
        return $asistence;

    }

   
}
