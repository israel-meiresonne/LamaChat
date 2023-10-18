<?php

require_once 'framework/Model.php';
require_once 'model/User.php';
require_once 'model/Chart.php';
require_once 'model/MyError.php';

/**
 * This class represents a Discussion
 */
class Message extends Model
{
    /**
     * Holds the message's identifiant
     * @var string
     */
    private $msgID;

    /**
     * Holds a private key to decrypt the message
     * @var string
     */
    private $privK;

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
     * Holds the encrypted message
     * @var string
     */
    private $encrypted;

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
     * Holds message's max length
     */
    public const MSG_MAX_LENGTH = 260000; // 262144 UTF-8

    /**
     * Attributs access key
     * @var string
     */
    public const KEY_MSG_ID = "msgID";
    public const KEY_MESSAGE = "message";
    public const KEY_STATUS = "status";

    /**
     * Holds feed's last message
     */
    public const KEY_LAST_MSG = "last_message";

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
    public const MSG_STATUS_SEND = "sent";
    public const MSG_STATUS_READ = "read";

    /**
     * Constructor
     * @param string $privK private key to decrypte the encryted message
     * @param User $from sender of the message's sender
     * @param string $type message's type(text, picture, file, audio,...)
     * @param string $encryted message encryted
     * @param string $status message's status(send, read)
     * @param string $msgID message's identifiant
     * @param string $setDate message's sent date
     */
    public function __construct($privK, $from, $type, $encryted, $status, $msgID = null, $setDate = null)
    {
        if (($status != self::MSG_STATUS_SEND) && ($status != self::MSG_STATUS_READ)) {
            throw new Exception("Message's status '$status' is not supported");
        }
        $this->msgID = (!empty($msgID)) ? $msgID : Discussion::generateDateCode(20);
        $this->privK = $privK;
        $this->from = $from;
        $this->type = $type;
        $this->encrypted = $encryted;
        $this->status = $status;
        $this->setDate = (!empty($setDate)) ? $setDate : date('Y-m-d H:i:s');
    }

    /**
     * Getter for message's id
     * @return string message's id
     */
    public function getMessageID()
    {
        return $this->msgID;
    }

    /**
     * Getter for message's sender
     * @return User message's sender
     */
    public function getSender()
    {
        return $this->from;
    }

    /**
     * Getter for message's type
     * @return string message's type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Getter message decrypted
     * @return string message decrypted
     */
    public function getMessage()
    {
        openssl_private_decrypt($this->encrypted, $decrypted, $this->privK);
        return $decrypted;
    }

    /**
     * Getter for message's status
     * @return string message's status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Getter for message's set date
     * @return string message's set date
     */
    public function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * To get a preview of the message
     * @return string a preview of thee message
     */
    public function getPreview()
    {
        if ($this->type == self::MSG_TYPE_TEXT) {
            return substr($this->getMessage(), 0, 55);
        }
        return self::MSG_TYPE_FILE;
    }

    /**
     * Getter for message's send hour
     * @return string message's send hour
     */
    public function getHour()
    {
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

    /**
     * To send a message
     * @param Response $response to push in occured errors
     * @param string $discuID discussion's id
     */
    public function sendMessage(Response $response, $discuID)
    {
        $sql = "INSERT INTO `Messages`(`msgID`, `discuId`, `from_pseudo`, `msgPrivateK`, `msgType`, `msg`, `msgStatus`, `msgSetDate`) VALUES (?,?,?,?,?,?,?,?)";
        $params = [
            $this->msgID,
            $discuID,
            $this->from->getPseudo(),
            $this->privK,
            $this->type,
            $this->encrypted,
            $this->status,
            $this->setDate
        ];
        $pdo = $this->executeRequest($sql, $params);
        if ($pdo->errorInfo()[0] != User::PDO_SUCCEESS) {
            $errMsg = $pdo->errorInfo()[1];
            $response->addError($errMsg, MyError::FATAL_ERROR);
        }
    }

    /**
     * To encrypte a message with a public key
     * @param string $pubK public key to encrypt a message
     * @param string $message message to encrypt
     * @return string the message encrypted
     */
    public static function encrypt($pubK, $message)
    {
        openssl_public_encrypt($message, $encrypted, $pubK);
        return $encrypted;
    }

    /*———————————————————————————— STATS ————————————————————————————————————*/
    /**
     * To get number of messages sent by users
     * @return int number of messages sent by users
     */
    public static function getNbMessage()
    {
        $sql = "SELECT COUNT(*) as 'nbMessage' FROM `Messages`";
        $pdo = parent::executeRequest($sql);
        return ((int) $pdo->fetchAll(PDO::FETCH_COLUMN)[0]);
    }

    /**
     * To get number message sent per time
     * @param string $id id of the chart's container
     * + also used to name the chart function builder in Js code
     * @param string the sql function to get time
     * @return Chart 
     */
    public static function messagePerTime($id, $func)
    {
        $sql = "SELECT $func(`msgSetDate`) as 'time', COUNT(`msgSetDate`) as 'number' FROM `Messages` GROUP BY $func(`msgSetDate`) ORDER BY 'time'  ASC";
        $pdo = parent::executeRequest($sql);
        $tab = $pdo->fetchAll();
        $rows = [];
        foreach ($tab as $tabLine) {
            $line = [$tabLine['time'], ((int)$tabLine['number'])];
            array_push($rows, $line);
        }
        $colNames = ["time", "messages"];
        $chart = new Chart($id, $colNames, $rows);
        $chart->setTitle("Nombre the message échangé par jour");
        $chart->setXTitle("Dates");
        $chart->setYTitle("Nombre de message échangé");
        return $chart;
    }
}
