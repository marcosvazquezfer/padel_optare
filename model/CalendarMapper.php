<?php
// file: model/CalendarMapper.php

require_once __DIR__ . "/../core/PDOConnection.php";

/**
 * Class CalendarMapper
 * Database interface for User entities
 */
class CalendarMapper
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

    /**
     * Saves a User into the database
     *
     * @param User $user The user to be saved
     * @throws PDOException if a database error occurs
     * @return void
     */
    public function save($calendar)
    {
        $stmt = $this->db->prepare("INSERT INTO Calendario (FechaHoraInicio, FechaHoraFin, idPista, userId, tipoReserva) values (?,?,?,?,?)");
        $stmt->execute(array($calendar->getStartDate(), $calendar->getEndDate(), $calendar->getIdCourt(), $calendar->getUserId(), $calendar->getReserveType()));
        $stmtGet = $this->db->prepare("SELECT * FROM Calendario ORDER BY idCalendario DESC LIMIT 1");
        $stmtGet->execute();
        $calendar = $stmtGet->fetch(PDO::FETCH_ASSOC);
        return $calendar["idCalendario"];
    }

    public function update($calendar)
    {
        $stmt = $this->db->prepare("UPDATE Calendario SET FechaHoraInicio=?, FechaHoraFin=?, idPista=? WHERE idCalendario=?");
        $stmt->execute(array($calendar->getStartDate(), $calendar->getEndDate(), $calendar->getIdCourt(), $calendar->getCalendarId()));
    }

    public function delete($idCourt, $startDate)
    {
        $stmt = $this->db->prepare("DELETE FROM Calendario WHERE idPista=? AND FechaHoraInicio=?");
        $stmt->execute(array($idCourt, $startDate));
    }

    public function get($calendarId)
    {
        $stmt = $this->db->prepare("SELECT * FROM Calendario where idCalendario=?");
        $stmt->execute(array($calendarId));
        $calendar = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($calendar != null) {
            return new Calendar(
                $calendar["idCalendario"],
                $calendar["FechaHoraInicio"],
                $calendar["FechaHoraFin"],
                $calendar["idPista"],
                $calendar["userId"],
                $calendar["tipoReserva"]);
        } else {
            return null;
        }

    }

    public function getByDateAndBeginTime($beginDateTime)
    {
        $stmt = $this->db->prepare("SELECT * FROM Calendario where FechaHoraInicio=?");
        $stmt->execute(array($beginDateTime));
        $calendar = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($calendar != null) {
            return new Calendar(
                $calendar["idCalendario"],
                $calendar["FechaHoraInicio"],
                $calendar["FechaHoraFin"],
                $calendar["idPista"],
                $calendar["userId"],
                $calendar["tipoReserva"]);
        } else {
            return null;
        }
    }

    public function getOcupacionPistas($calendar)
    {
        $stmt = $this->db->prepare("SELECT * FROM Calendario where idPista=?");
        $stmt->execute(array($calendar->getIdCourt()));
        $calendar = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($calendar != null) {
            return new Calendar(
                $calendar["idCalendario"],
                $calendar["FechaHoraInicio"],
                $calendar["FechaHoraFin"],
                $calendar["idPista"],
                $calendar["userId"],
                $calendar["tipoReserva"]);
        } else {
            return null;
        }

    }

    public function findOneFree($date)
    {
        $stmt = $this->db->prepare("SELECT * FROM `Calendario` WHERE NOT idPista IN(SELECT idPista FROM `Calendario` WHERE FechaHoraInicio = ?) OR NOT EXISTS (SELECT idPista FROM `Calendario` WHERE FechaHoraInicio = ?)");
        $stmt->execute(array($date, $date));
        $calendar = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($calendar != null) {
            return $calendar["idPista"];
        } else {
            return null;
        }
    }

    public function getBookingsCount($userId)
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM `Calendario` WHERE userId=?");
        $stmt->execute(array($userId));
        $count = $stmt->fetch(PDO::FETCH_ASSOC);

        return $count["count(*)"];
    }

    public function getallBookings($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM `Calendario` WHERE userId=?");
        $stmt->execute(array($userId));
        $bookings_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $bookings = array();

        if ($bookings_db != null) {
            foreach ($bookings_db as $booking) {
                array_push($bookings, new Calendar(
                    $booking["idCalendario"],
                    $booking["FechaHoraInicio"],
                    $booking["FechaHoraFin"],
                    $booking["idPista"],
                    $booking["userId"],
                    $booking["tipoReserva"])
                );
            }
        } else {
            return null;
        }
        return $bookings;
    }

    public function hourIsReserved($calendar)
    {
        $stmt = $this->db->prepare("SELECT count(username) FROM Calendario where fechInicio=? and fechFin=? and idPista=?");
        $stmt->execute(array($calendar->getStartDate(), $calendar->getEndDate(), $calendar->getIdCourt()));

        if ($stmt->fetchColumn() > 0) {
            return true;
        }
    }
}
