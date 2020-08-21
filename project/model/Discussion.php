<?php

require_once 'framework/Model.php';
require_once 'model/User.php';
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

    /**
     * Access key for new discussion request
     */
    public const KEY_NEW_DISCU = "new_chat";

    /**
     * Access key for new discussion's html code for navbar
     */
    public const KEY_DISCU_MENU = "menu_discu";

    /**
     * Access key for new discussion's feed
     */
    public const KEY_DISCU_FEED = "feed_discu";



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
        $this->participants = [];
        $sql = "SELECT * 
        FROM `Participants` p
        JOIN `Users` u ON p.pseudo_ = u.pseudo
        WHERE discuId = '$this->discuID'";
        $pdo = parent::executeRequest($sql);
        while ($pdoLine = $pdo->fetch()) {
            // $user = $this->createUser($pdoLine);
            $user = User::createUser($pdoLine);
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
            // $from = (key_exists($pseudo, $this->participants)) ? $this->participants[$pseudo] : $this->createUser($pdoLine);
            $from = (key_exists($pseudo, $this->participants)) ? $this->participants[$pseudo] : User::createUser($pdoLine);
            $privK = $pdoLine["msgPrivateK"];
            $type = $pdoLine["msgType"];
            $msg = $pdoLine["msg"];
            $status = $pdoLine["msgStatus"];
            $setDate = $pdoLine["msgSetDate"];
            $msgObj = new Message($privK, $from, $type, $msg, $status, $msgID, $setDate);
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
     * Getter for discussion's participants
     * @return string discussion's name
     */
    public function getParticipants()
    {
        (!isset($this->participants)) ? $this->setParticipants() : null;
        return $this->participants;
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
     * To get one message from discussion
     * @param string $msgID message's identifiant
     * @return Message a message from discussion
     */
    public function getMessage($msgID)
    {
        $messages = $this->getMessages();
        foreach ($messages as $unix => $message) {
            if ($message->getMessageID() == $msgID) {
                return $messages[$unix];
                break;
            }
        }
        $discuID = $this->getDiscuID();
        throw new Exception("Message with id '$msgID' don't exist in discussion '$discuID'");
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
    public function getMsgPreview()
    {
        /**
         * @var Message
         */
        $msg = end($this->messages);
        return $msg ? $msg->getPreview() : "[vide]";
    }

    /**
     * Check if the discussion contain unread message by the current user
     * @param string $pseudo currrent user's pseudo
     * @return boolean true its contain unread message else false
     */
    public function containUnread($pseudo)
    {
        $messages = $this->getMessages();
        if(!empty($messages)){
            foreach($messages as $message){
                $senderPseudo = $message->getSender()->getPseudo();
                if(($senderPseudo != $pseudo) && ($message->getStatus() != Message::MSG_STATUS_READ)){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Create a new User
     * @param string[] $pdoLine line from database witch contain user's properties
     * @return User a User instance
     */
    // private function createUser($pdoLine)
    // {
    //     $user = new User();
    //     $user->setPseudo($pdoLine["pseudo"]);
    //     $user->setFirstname($pdoLine["firstname"]);
    //     $user->setLastname($pdoLine["lastname"]);
    //     $user->setPicture($pdoLine["picture"]);
    //     $user->setStatus($pdoLine["status"]);
    //     $user->setPermission($pdoLine["permission"]);
    //     return $user;
    // }

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

    /*———————————————————————————— STATS ————————————————————————————————————*/
    /**
     * To get number of discussion open by users
     * @return int number of discussion open by users
     */
    public static function getNbDiscussion()
    {
        $sql = "SELECT COUNT(*) as 'nbDiscussion' FROM `Discussions`";
        $pdo = parent::executeRequest($sql);
        return ((int) $pdo->fetchAll(PDO::FETCH_COLUMN)[0]);
    }

    /**
     * To get number Discussions open per time
     * @param string $id id of the chart's container
     * + also used to name the chart function builder in Js code
     * @param string the sql function to get time
     * @return Chart 
     */
    public static function discussionPerTime($id, $func)
    {
        $sql = "SELECT $func(`discuSetDate`) as 'time', COUNT(`discuSetDate`) as 'number' FROM `Discussions` GROUP BY $func(`discuSetDate`) ORDER BY 'time'  ASC";
        $pdo = parent::executeRequest($sql);
        $tab = $pdo->fetchAll();
        $rows = [];
        foreach ($tab as $tabLine) {
            $line = [$tabLine['time'], ((int)$tabLine['number'])];
            array_push($rows, $line);
        }
        $colNames = ["time", "chats"];
        $chart = new Chart($id, $colNames, $rows);
        $chart->setTitle("Nombre the chat ouvert par jour");
        $chart->setXTitle("Dates");
        $chart->setYTitle("Nombre de chat ouvert");
        return $chart;
    }
}
