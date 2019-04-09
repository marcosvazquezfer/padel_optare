<?php
// file: model/Match.php

require_once __DIR__ . "/../core/ValidationException.php";

class Message
{

    private $messageId;
    private $userId;
    private $message;
    private $date;

    public function __construct($messageId = null, $userId, $message, $date)
    {

        $this->messageId = $messageId;
        $this->userId = $userId;
        $this->message = $message;
        $this->date = $date;
    }
    public function getMessageId()
    {
        return $this->messageId;
    }

    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
}
