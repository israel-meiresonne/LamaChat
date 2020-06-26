<?php

require_once 'framework/Model.php';

/**
 * This class represents an User
 */
class User extends Model
{
    /**
     * Holds the user's pseudo
     * @var string
     */
    private $pseudo;

    /**
     * Holds the user's lastname
     * @var string
     */
    private $firstname;

    /**
     * Holds the user's lastname
     * @var string
     */
    private $lastname;

    /**
     * Holds the user's password
     * @var string
     */
    private $password;

    /**
     * Holds the user's informations 
     * + NOTE: use the information name as access key
     * @var string[]
     */
    private $informations;

    /**
     * Holds the user's profil picture
     * @var string
     */
    private $picture;

    /**
     * Holds the user's profil status
     * @var string
     */
    private $status;

    /**
     * Holds the user's permission
     * @var string
     */
    private $permission;

    /**
     * Holds user's discussion. 
     * + NOTE: use as access key the UNIX time of the last message sended in one discussion
     * @var Discussion[]
     */
    private $discussions;

    /**
     * Constructor for user unregistered
     * @param string $pseudo user's pseudo
     * @param string $password user's password
     * @param string $firstname user's firstname
     * @param string $lastname user's lastname
     */
    function __construct($pseudo, $password, $firstname = null, $lastname = null)
    {
        $this->pseudo = $pseudo;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = (isset($firstname) && isset($lastname)) ? $this->encrypt($password) : $password;
    }

    /**
     * Register a new user in the database
     * @param Response $response to push in occured errors
     * @return boolean true if the user is registered else false
     */
    public function signUp($response)
    {
        if (!$this->pseudoExist()) {
            $sql = "INSERT INTO `Users`(`pseudo`, `password`, `firstname`, `lastname`) VALUES (?,?,?,?)";
            $pdoState = parent::executeRequest($sql, array($this->pseudo, $this->password, $this->firstname, $this->lastname));
            if ($pdoState->errorInfo()[0] != "00000") {
                $errMsg = "une erreur s'est produite lors de votre inscription!";
                $response->addError($errMsg, MyError::FATAL_ERROR);
                return false;
            } else {
                return true;
            }
        }
        $errMsg = "ce pseudo existe déjà!";
        $response->addError($errMsg, ControllerSign::INPUT_PSEUDO);
        return false;
    }

    /**
     * Sign in the user to system
     * @param Response $response to push in occured errors
     * @return boolean true if the user is sign in else false
     */
    public function signIn($response)
    {
        if ($this->pseudoExist()) {
            $sql = "SELECT `password` FROM `Users` WHERE `pseudo` = '$this->pseudo'";
            $passHash = parent::executeRequest($sql)->fetch()["password"];
            if ($this->passMatchHash($this->password, $passHash)) {
                return true;
            } else {
                $errMsg = "le pseudo ou le mot de passe est incorrect!";
                $response->addError($errMsg, ControllerSign::INPUT_PSEUDO);
                $response->addError($errMsg, ControllerSign::INPUT_PSW);
            }
        } else {
            $errMsg = "ce pseudo n'existe pas!";
            $response->addError($errMsg, ControllerSign::INPUT_PSEUDO);
        }
    }

    /**
     * Check if the user's pseudo is already in the database
     * @return boolean true if the pseudo exist in the database else false
     */
    public function pseudoExist()
    {
        $sql = "SELECT `pseudo` FROM `Users` WHERE `pseudo` = '$this->pseudo'";
        $pseudos = parent::executeRequest($sql);
        return ($pseudos->rowCount() > 0);
    }

    /** 
     * Crypt the password passed in parm
     * @param string $password password to crypt
     * @return string password's hashcode
     */
    private function encrypt($password)
    {
        return password_hash(sha1($password), PASSWORD_BCRYPT);
    }

    /** 
     * Check if the hashcode of password passed match the hashcode given in param
     * @param string $password the password to check
     * @param string $hashcode the hashcode to match
     * @return boolean true if the password match the hashcode given in param else false
     */
    private function passMatchHash($password, $hashcode)
    {
        return password_verify(sha1($password), $hashcode);
    }
}
