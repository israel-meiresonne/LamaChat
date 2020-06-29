<?php

/**
 * This class represents a Discussion
 */
class Message
{
    /**
     * Holds the message's identifiant
     * @var string
     */
    private $msgID;

    /**
     * Holds the message's sender
     * @var User
     */
    private $from;

    /**
     * Holds the message's type(text, picture, file, audio,...)
     * @var string
     */
    private $type;

    /**
     * Holds the message's content
     * @var string
     */
    private $message;

    /**
     * Holds the message's status(send, read)
     * @var string
     */
    private $status;

    /**
     * Holds message's send date
     * @var string
     */
    private $setDate;

    /**
     * Message type available
     * @var string
     */
    public const MSG_TYPE_TEXT = "text";
    public const MSG_TYPE_FILE = "file";

    /**
     * Message type available
     * @var string
     */
    public const MSG_STATUS_SEND = "send";
    public const MSG_STATUS_READ = "read";

    public function __construct($msgID, $from, $type, $message, $status, $setDate)
    {
        $this->msgID = $msgID;
        $this->from = $from;
        $this->type = $type;
        $this->message = $message;
        $this->status = $status;
        $this->setDate = $setDate;
    }

    /**
     * Getter for message's sender
     * @return User message's sender
     */
    public function getSender(){
        return $this->from;
    }

    /**
     * Getter for message's type
     * @return string message's type
     */
    public function getType(){
        return $this->type;
    }

    /**
     * Getter for message's content
     * @return string message's content
     */
    public function getMessage(){
        return $this->message;
    }

    /**
     * Getter for message's status
     * @return string message's status
     */
    public function getStatus(){
        return $this->status;   
    }

    /**
     * To get a preview of the message
     * @return string a preview of thee message
     */
    public function getMsgPreview()
    {
        if ($this->type == self::MSG_TYPE_TEXT) {
            return substr($this->message, 0, 55);
        }
        return self::MSG_TYPE_FILE;
    }

    /**
     * Getter for message's send hour
     * @return string message's send hour
     */
    public function getHour(){
        $unix = strtotime($this->setDate);
        return date("H:i", $unix);
    }

    /**
     * To get the message's send date in format "mercredi 23 juin 2020"
     * @return string the date in format
     */
    public function getFormatDate()
    {
        $unix = strtotime($this->setDate);
        $dayTxt = $this->getDay(date("N", $unix));
        $dayNum = date("j", $unix);
        $mont = $this->getMonth(date("n", $unix));
        $year = date("Y", $unix);
        return "$dayTxt $dayNum $mont $year";
    }

    /**
     * Convert the numeric day of the week to textual day of the week in French
     * @param int $dayWeek the numeric day of the week
     * @return string textual day of the week in French
     */
    private function getDay($dayWeek)
    {
        $day = null;
        switch ($dayWeek) {
            case 1:
                $day = "lundi";
                break;
            case 2:
                $day = "mardi";
                break;
            case 3:
                $day = "mercredi";
                break;
            case 4:
                $day = "jeudi";
                break;
            case 5:
                $day = "vendredi";
                break;
            case 6:
                $day = "samedi";
                break;
            case 7:
                $day = "dimanche";
                break;
        }
        return $day;
    }

    /**
     * Convert the numeric month to textual month in French
     * @param int $monthNum the numeric month
     * @return string textual month in French
     */
    private function getMonth($monthNum)
    {
        $monthFr = null;
        switch ($monthNum) {
            case 1:
                $monthFr = "janvier";
                break;
            case 2:
                $monthFr = "février";
                break;
            case 3:
                $monthFr = "mars";
                break;
            case 4:
                $monthFr = "avril";
                break;
            case 5:
                $monthFr = "mai";
                break;
            case 6:
                $monthFr = "juin";
                break;
            case 7:
                $monthFr = "juillet";
                break;
            case 8:
                $monthFr = "août";
                break;
            case 9:
                $monthFr = "septembre";
                break;
            case 10:
                $monthFr = "octobre";
                break;
            case 11:
                $monthFr = "novembre";
                break;
            case 12:
                $monthFr = "décembre";
                break;
        }
        return $monthFr;
    }
}
