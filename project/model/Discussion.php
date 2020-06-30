<?php

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
     * Getter for user's discussion id (identifiant)
     * @return string user's discussion id (identifiant)
     */
    public function getDiscuID()
    {
        return $this->discuID;
    }

    /**
     * Getter for user's discussion name
     * @return string user's discussion name
     */
    public function getDiscuName()
    {
        return $this->discuName;
    }

    /**
     * Getter for user's discussion messages
     * @return Message[] user's discussion messages
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
}
