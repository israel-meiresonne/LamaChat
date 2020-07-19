<?php

require_once 'framework/Model.php';
require_once 'Message.php';

/**
 * This class represents a Discussion
 */
class Discussion extends Model
{
    /**
     * Holds discussion's identifiant
     * @var string
     */
    private $discuID;

    /**
     * Holds discussion's name given by the user
     * @var string
     */
    private $discuName;

    /**
     * Holds discussion's participants
     * + NOTE: use the user's pseudo as access key
     * @var User[]
     */
    private $participants;

    /**
     * Holds discussion's creation date
     * @var string
     */
    private $setDate;

    /**
     * Holds discussion's messages ordered from oldest to newest
     * + NOTE: use as access key the unix time of the creation date of the message
     * @var Message[]
     */
    private $messages;

    /**
     * Access key for discussion's id
     */
    public const DISCU_ID = "discuID";



    public function __construct($discuID, $setDate, $discuName = null)
    {
        $this->discuID = $discuID;
        $this->discuName = $discuName;
        $this->setDate = $setDate;
    }

    /**
     * Setter for discussion's participants attribut
     */
    public function setParticipants()
    {
        $sql = "SELECT * 
        FROM `Participants` p
        JOIN `Users` u ON p.pseudo_ = u.pseudo
        WHERE discuId = '$this->discuID'";
        $pdo = parent::executeRequest($sql);
        $this->participants = [];
        while ($pdoLine = $pdo->fetch()) {
            $user = $this->createUser($pdoLine);
            $this->participants[$user->getPseudo()] = $user;
        }
    }

    /**
     * Setter for discussion's messages attribut
     */
    public function setMessages()
    {
        if (!isset($this->participants)) {
            throw new Exception("Discussion's participants must first be initialized");
        }
        $sql = "SELECT * 
        FROM `Messages` m
        JOIN `Users` u ON m.from_pseudo  = u.pseudo
        WHERE discuId = '$this->discuID'";
        $pdo = parent::executeRequest($sql);

        $this->messages = [];
        while ($pdoLine = $pdo->fetch()) {
            $msgID = $pdoLine["msgID"];
            $pseudo = $pdoLine["from_pseudo"];
            $from = (key_exists($pseudo, $this->participants)) ? $this->participants[$pseudo] : $this->createUser($pdoLine);
            $type = $pdoLine["msgType"];
            $msg = $pdoLine["msg"];
            $status = $pdoLine["msgStatus"];
            $setDate = $pdoLine["msgSetDate"];
            $msgObj = new Message($msgID, $from, $type, $msg, $status, $setDate);
            $this->messages[strtotime($setDate)] = $msgObj;
        }
        ksort($this->messages);
    }

    /**
     * Getter for discussion's id (identifiant)
     * @return string discussion's id (identifiant)
     */
    public function getDiscuID()
    {
        return $this->discuID;
    }

    /**
     * Getter for discussion's name
     * @return string discussion's name
     */
    public function getDiscuName()
    {
        return $this->discuName;
    }

    /**
     * Getter for discussion's creation date
     * @return string discussion's creation date
     */
    public function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * Getter for discussion's messages
     * @return Message[] discussion's messages
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * To get correspondant that discuss with the current user
     * + NOTE: only work if there is two participants (the current user and his correspondant)
     * @param string $pseudo current user's pseudo
     * @return User correspondant that discuss with the current user
     */
    public function getCorrespondent($pseudo)
    {
        if (!key_exists($pseudo, $this->participants)) {
            throw new Exception("The current user don't participe to this discussion");
        }
        if (count($this->participants) > 2) {
            throw new Exception("The discussion has more than two participants");
        }
        $corresp = null;
        foreach ($this->participants as $partiPseudo => $user) {
            if ($partiPseudo != $pseudo) {
                $corresp = $user;
                break;
            }
        }
        return $corresp;
    }

    /**
     * To get a preview of the last message
     * @return string a preview of thee last message
     */
    public function getMsgPreview(){
        /**
         * @var Message
         */
        $msg = end($this->messages);
        return $msg ? $msg->getMsgPreview() : "[vide]";
    }

    /**
     * Create a new User
     * @param string[] $pdoLine line from database witch contain user's properties
     * @return User a User instance
     */
    private function createUser($pdoLine)
    {
        $user = new User();
        $user->setPseudo($pdoLine["pseudo"]);
        $user->setFirstname($pdoLine["firstname"]);
        $user->setLastname($pdoLine["lastname"]);
        $user->setPicture($pdoLine["picture"]);
        $user->setStatus($pdoLine["status"]);
        $user->setPermission($pdoLine["permission"]);
        return $user;
    }

        /**
     * Generate a alpha numerique sequence in specified length
     * @param int $length
     * @return string alpha numerique sequence in specified length
     */
    // private function generateCode($length)
    private static function generateCode($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $sequence = '';
        $nbChar = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, $nbChar);
            $sequence .= $characters[$index];
        }

        return $sequence;
    }

    /**
     * Genarate a sequence code of $length characteres in format 
     * CC...YYMMDDHHmmSSssCC... where C is a alpha numerique sequence. 
     * NOTE: length must be strictly over 14 characteres cause it's the size of the 
     * date time sequence
     * @param int $length the total length
     * @throws Exception if $length is under or equals 14
     * @return string a alpha numerique sequence with more than 14 
     * characteres 
     */
    public static function generateDateCode($length)
    {
        $sequence = date("YmdHis");
        $nbChar = strlen($sequence);
        if ($length <= $nbChar) {
            throw new Exception('$length must be strictly over 14');
        }
        $nbCharToAdd = $length - $nbChar;
        switch ($nbCharToAdd % 2) {
            case 0:
                $nbCharLeft = $nbCharRight = ($nbCharToAdd / 2);
                break;
            case 1:
                $nbCharLeft = ($nbCharToAdd - 1) / 2;
                $nbCharRight = $nbCharLeft + 1;
                break;
        }
        $sequence = self::generateCode($nbCharLeft) . $sequence . self::generateCode($nbCharRight);
        $sequence = strtolower($sequence);
        return str_shuffle($sequence);
    }
}
