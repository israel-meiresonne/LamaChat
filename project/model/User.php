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
     * Holds a couple of public and private key
     * @var resource of type (OpenSSL key) 
     */
    private $keys;

    /**
     * Access key for session valeus
     * @var string
     */
    private const SESSION_PRIVATE_K = "privk";
    private const SESSION_PUBLIC_K = "pubk";

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
     * @param Session $session user's session
     * @return boolean true if the user is registered else false
     */
    public function signUp($response, $session)
    {
        if (!$this->pseudoExist()) {
            $sql = "INSERT INTO `Users`(`pseudo`, `password`, `firstname`, `lastname`) VALUES (?,?,?,?)";
            $pdoState = parent::executeRequest($sql, array($this->pseudo, $this->password, $this->firstname, $this->lastname));
            if ($pdoState->errorInfo()[0] != "00000") {
                $errMsg = "désolé, une erreur s'est produite lors de votre inscription!";
                $response->addError($errMsg, MyError::FATAL_ERROR);
                return false;
            }
            return $this->saveKeys($response, $session);
        }
        $errMsg = "ce pseudo existe déjà!";
        $response->addError($errMsg, ControllerSign::INPUT_PSEUDO);
        return false;
    }

    /**
     * Sign in the user to system
     * @param Response $response to push in occured errors
     * @param Session $session user's session
     * @return boolean true if the user is sign in else false
     */
    public function signIn($response, $session)
    {
        if ($this->pseudoExist()) {
            $sql = "SELECT `password` FROM `Users` WHERE `pseudo` = '$this->pseudo'";
            $passHash = parent::executeRequest($sql)->fetch()["password"];
            if (!($this->passMatchHash($this->password, $passHash))) {
                $errMsg = "le pseudo ou le mot de passe est incorrect!";
                $response->addError($errMsg, ControllerSign::INPUT_PSEUDO);
                $response->addError($errMsg, ControllerSign::INPUT_PSW);
                return false;
            }
            return $this->saveKeys($response, $session);
        }
        $errMsg = "ce pseudo n'existe pas!";
        $response->addError($errMsg, ControllerSign::INPUT_PSEUDO);
        return false;
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

    /**
     * Set user's session key and save the keys in database      
     * @param Response $response to push in occured errors    
     * @param Session $session user's session
     * @return boolean true if user's session keys were setted and saved in database else false
     */
    private function saveKeys($response, $session)
    {
        $privK = $this->getPrivateKey();
        $pubK = $this->getPublicKey();

        // save keys in the database
        $sql = "INSERT INTO `UsersKeys`(`pseudo_`, `keySetDate`, `privateK`, `publicK`) VALUES (?,?,?,?)";
        $pdoState = parent::executeRequest($sql, array($this->pseudo, date('Y-m-d H:i:s'), $privK, $pubK));
        if ($pdoState->errorInfo()[0] != "00000") {
            $errMsg = "désolé, une erreur s'est produite lors de votre connection!";
            $response->addError($errMsg, MyError::FATAL_ERROR);
            return false;
        }
        $session->setAttribute(self::SESSION_PRIVATE_K, $privK);
        $session->setAttribute(self::SESSION_PUBLIC_K, $pubK);
        return true;
    }

    /**
     * Generate a public and private key
     */
    private function generateKeys()
    {
        $config = array(
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        $this->keys = openssl_pkey_new($config);
    }

    /**
     * To get the private key
     * @return string the private key
     */
    private function getPrivateKey()
    {
        if ((!isset($this->keys)) || empty($this->keys)) {
            $this->generateKeys();
        }
        openssl_pkey_export($this->keys, $privK);
        return $privK;
    }

    /**
     * To get the public key
     * @return string the public key
     */
    private function getPublicKey()
    {
        if ((!isset($this->keys)) || empty($this->keys)) {
            $this->generateKeys();
        }
        $pubK = openssl_pkey_get_details($this->keys);
        $pubK = $pubK["key"];
        return $pubK;
    }
}
