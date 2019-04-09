<?php
// file: model/UserMapper.php

require_once __DIR__ . "/../core/PDOConnection.php";

/**
 * Class UserMapper
 *
 * Database interface for User entities
 *
 * @author lipido <lipido@gmail.com>
 */
class UserMapper
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
    public function save($user)
    {
        $stmt = $this->db->prepare("INSERT INTO Usuario_Registrado values (?,?,?,?)");
        $stmt->execute(array($user->getDni(), $user->getPassword(), $user->getCompleteName(), $user->getEmail()));
    }

    /**
     * Checks if a given username is already in the database
     *
     * @param string $username the username to check
     * @return boolean true if the username exists, false otherwise
     */
    public function usernameExists($username)
    {
        $stmt = $this->db->prepare("SELECT count(userId) FROM Usuario_Registrado where userId=?");
        $stmt->execute(array($username));

        if ($stmt->fetchColumn() > 0) {
            return true;
        }
    }

    /**
     * Checks if a given pair of username/password exists in the database
     *
     * @param string $username the username
     * @param string $passwd the password
     * @return boolean true the username/passwrod exists, false otherwise.
     */
    public function isValidUser($username, $passwd)
    {
        $stmt = $this->db->prepare("SELECT count(userId) FROM Usuario_Registrado where userId=? and password=?");
        $stmt->execute(array($username, $passwd));

        if ($stmt->fetchColumn() > 0) {
            return true;
        }
    }

    public function isAdmin()
    {
        $stmt = $this->db->prepare("SELECT count(userId) FROM Administrador where userId=?");
        $stmt->execute(array($_SESSION["currentuser"]));

        if ($stmt->fetchColumn() > 0) {
            return true;
        }
    }

    public function isTrainer()
    {
        $stmt = $this->db->prepare("SELECT count(userId) FROM Entrenador where userId=?");
        $stmt->execute(array($_SESSION["currentuser"]));

        if ($stmt->fetchColumn() > 0) {
            return true;
        }
    }

    public function getUserNameById($userId)
    {
        $stmt = $this->db->prepare("SELECT nombreCompleto FROM Usuario_Registrado where userId=?");
        $stmt->execute(array($userId));

        $name = $stmt->fetch(PDO::FETCH_ASSOC);
        return $name["nombreCompleto"];
    }

    public function findAllCoaches()
    {

        $stmt = $this->db->query("SELECT * FROM Entrenador");
        $coaches_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $coaches = array();

        foreach ($coaches_db as $coach) {

            array_push($coaches, $coach["userId"]);
        }

        return $coaches;
    }

    public function getMessages($userId)
    {

        $stmt = $this->db->prepare("SELECT * FROM Mensaje WHERE userId=?");
        $stmt->execute(array($userId));

        $msgs_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $messages = array();

        if ($msgs_db != null) {
            foreach ($msgs_db as $msg) {
                array_push($messages, new Message(
                    $msg["idMensaje"],
                    $msg["userId"],
                    $msg["mensaje"],
                    $msg["fecha"])
                );
            }
        } else {
            return null;
        }

        return $messages;
    }
}
