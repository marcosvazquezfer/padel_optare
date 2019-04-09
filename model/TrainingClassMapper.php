<?php
// file: model/TrainingClassMapper.php

require_once __DIR__ . "/../core/PDOConnection.php";

/**
 * Class TrainingClassMapper
 * Database interface for Classes entities
 */
class TrainingClassMapper
{
    /**
     * Reference to the PDO connection
     * @var PDO
     */
    private $db;

    public function __construct()
    {
        $this->db = PDOConnection::getInstance();
    }

    public function save($class)
    {
        $stmt = $this->db->prepare("INSERT INTO Clase (nivel, creador, idEntrenador, horario) values (?,?,?, ?)");
        $stmt->execute(array($class->getLevel(), $class->getCreator(), $class->getTrainer(), $class->getDate()));
        $stmtGet = $this->db->prepare("SELECT * FROM Clase ORDER BY idClase DESC LIMIT 1");
        $stmtGet->execute();
        $class = $stmtGet->fetch(PDO::FETCH_ASSOC);
        return $class["idClase"];
    }

    public function update($class)
    {
        $stmt = $this->db->prepare("UPDATE Clase SET nivel=?, idEntrenador=? WHERE idClase=?");
        $stmt->execute(array($class->getLevel(), $class->getTrainer(), $class->getClassId()));
    }

    public function saveCalendar($classId, $calendarId)
    {
        $stmt = $this->db->prepare("INSERT INTO Calendario_Clase values (?,?)");
        $stmt->execute(array($classId, $calendarId));
    }

    public function get($classId)
    {
        $stmt = $this->db->prepare("SELECT * FROM Clase where idClase=?");
        $stmt->execute(array($classId));
        $class = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($class != null) {
            return new TrainingClass($class["idClase"],
                $class["nivel"],
                $class["creador"],
                $class["idEntrenador"],
                $class["horario"]);
        } else {
            return null;
        }

    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM Clase");
        $stmt->execute();
        $classes_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $classes = array();
        foreach ($classes_db as $class) {
            array_push($classes, new TrainingClass($class["idClase"],
                $class["nivel"],
                $class["creador"],
                $class["idEntrenador"],
                $class["horario"]));
        }
        return $classes;
    }

    public function findAthletesByClassId($classId)
    {
        $stmt = $this->db->prepare("SELECT * FROM Deportistas_Clase WHERE idClase=?");
        $stmt->execute(array($classId));
        $athletes_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $athletes = array();

        foreach ($athletes_db as $athlete) {
            array_push($athletes, $athlete["userId"]);
        }

        return $athletes;
    }

    public function getAllById($trainer)
    {
        $stmt = $this->db->prepare("SELECT * FROM Clase WHERE idEntrenador=?");
        $stmt->execute(array($trainer));
        $classes_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $classes = array();
        foreach ($classes_db as $class) {
            array_push($classes, new TrainingClass($class["idClase"],
                $class["nivel"],
                $class["creador"],
                $class["idEntrenador"],
                $class["horario"]));
        }
        return $classes;
    }

    public function findByUserId($currentuser)
    {

        $stmt = $this->db->prepare("SELECT * FROM Deportistas_Clase, Clase WHERE Deportistas_Clase.idClase = Clase.idClase AND Deportistas_Clase.userId=?");
        $stmt->execute(array($currentuser));
        $classes_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $classes = array();
        foreach ($classes_db as $class) {
            array_push($classes, new TrainingClass($class["idClase"],
                $class["nivel"],
                $class["creador"],
                $class["idEntrenador"],
                $class["horario"]));
        }
        return $classes;
    }

    public function getClassCalendarMonthly($classId)
    {
        $stmt = $this->db->prepare("SELECT c.* FROM Calendario_Clase cc, Calendario c WHERE idClase=? AND cc.idCalendario=c.idCalendario");
        $stmt->execute(array($classId));
        $cuenta = $stmt->rowCount();

        if ($cuenta > 1) {
            $entry = $stmt->fetch(PDO::FETCH_ASSOC);

            return new Calendar(
                $entry["idCalendario"],
                $entry["FechaHoraInicio"],
                $entry["FechaHoraFin"],
                $entry["idPista"],
                $entry["userId"],
                $entry["tipoReserva"]);
        } else {
            return null;
        }
    }

    public function getClassCalendarParticular($classId)
    {
        $stmt = $this->db->prepare("SELECT c.* FROM Calendario_Clase cc, Calendario c WHERE idClase=? AND cc.idCalendario=c.idCalendario");
        $stmt->execute(array($classId));
        $cuenta = $stmt->rowCount();
        if ($cuenta <= 1) {
            $calendar = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $classCalendar = array();
            foreach ($calendar as $entry) {
                array_push($classCalendar, new Calendar(
                    $entry["idCalendario"],
                    $entry["FechaHoraInicio"],
                    $entry["FechaHoraFin"],
                    $entry["idPista"],
                    $entry["userId"],
                    $entry["tipoReserva"]));
            }
            return $classCalendar;
        } else {
            return null;
        }
    }

    //Borrará la clase y el calendario por las dependencias de base de datos
    public function removeClass($classId)
    {
        $stmtCalendar = $this->db->prepare("DELETE Calendario FROM Calendario JOIN Calendario_Clase ON Calendario.idCalendario=Calendario_Clase.idCalendario WHERE Calendario_Clase.idClase=?");
        $stmtClase = $this->db->prepare("DELETE FROM Clase WHERE idClase=?");

        $stmtCalendar->execute(array($classId));
        $stmtClase->execute(array($classId));
    }

    public function enroll($classId, $currentUser)
    {

        $stmt = $this->db->prepare("INSERT INTO Deportistas_Clase(userId, idClase) values (?,?)");
        $stmt->execute(array($currentUser, $classId));
    }

    public function unsubscribe($classId, $currentUser)
    {

        $stmt = $this->db->prepare("DELETE from Deportistas_Clase WHERE userId=? AND idClase=?");
        $stmt->execute(array($currentUser, $classId));
    }

    public function sendMessage($notification)
    {

        $stmt = $this->db->prepare("INSERT INTO Mensaje(userId, mensaje, fecha) values (?,?,?)");
        $stmt->execute(array($notification->getUserId(), $notification->getMessage(), $notification->getDate()));
    }
}
