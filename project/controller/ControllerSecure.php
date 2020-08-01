<?php

require_once 'framework/Controller.php';
require_once 'model/User.php';
require_once 'model/MyError.php';
require_once 'ControllerHome.php';
require_once 'ControllerSign.php';

/**
 * This class is used to check user's authentications
 */
abstract class ControllerSecure extends Controller
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Holds the input types
     * @var string
     */
    protected const PSEUDO = "pseudo";
    protected const NAME = "name";  // handle space and `-`
    protected const PASSWORD = "psw";
    protected const KEY_SEARCH = "search";
    protected const ALPHA_NUMERIC = "alpha_numeric";
    protected const TEXT = "text";
    protected const DATE = "date";
    protected const FILE = "file";

    /**
     * Holds REGEX for input type
     * @var string
     */
    private const PSEUDO_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_]*$#";
    private const NAME_REGEX = "#^[A-zÀ-ú-]+$#";
    private const PASSWORD_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_]+$#";
    protected const ALPHA_NUMERIC_REGEX = "#^[a-zA-Z0-9]+$#";
    public const DATE_REGEX = "#^([1-9]|[1-2][0-9]|3[0-1])[/ ]([1-9]|1[0-2]|janvier|fevrier|mars|avril|mai|juin|juillet|aout|septembre|octobre|novembre|decembre)[/ ]([1-9]|[1-9][0-9]*)$#";

    /**
     * Check if user's is allowed to access to one page
     */
    protected function secureSession()
    {
        $ctr = get_class($this);
        switch ($ctr) {
            case ControllerSign::class:
                if ($this->keysExist()) {
                    $this->setUser();
                    $class = $this->extractControllerName(ControllerHome::class);
                    ($this->user->userExist()) ? $this->redirect($class) : null;
                }
                break;

            case ControllerHome::class:
                if ($this->keysExist()) {
                    $this->setUser();
                    $class = $this->extractControllerName(ControllerSign::class);
                    (!$this->user->userExist()) ? $this->redirect($class) : null;
                    $permi = $this->user->getPermission();
                    $action = ($this->request->existingParameter("action")) ? $this->request->getParameter("action") : null;
                    switch ($action) {
                        case ControllerHome::ACTION_BANISHED:
                            if ($permi != User::PERMIT_BANISHED) {
                                $class = $this->extractControllerName(ControllerHome::class);
                                $this->redirect($class);
                            }
                            break;
                        case ControllerHome::ACTION_DELETED:
                            if ($permi != User::PERMIT_DELETED) {
                                $class = $this->extractControllerName(ControllerHome::class);
                                $this->redirect($class);
                            }
                            break;
                        default:
                            switch ($permi) {
                                case User::PERMIT_BANISHED:
                                    $hclass = $this->extractControllerName(ControllerHome::class);
                                    $this->redirect($hclass, ControllerHome::ACTION_BANISHED);
                                    break;

                                case User::PERMIT_DELETED:
                                    $hclass = $this->extractControllerName(ControllerHome::class);
                                    $this->redirect($hclass, ControllerHome::ACTION_DELETED);
                                    break;
                            }
                            break;
                    }
                } else {
                    $class = $this->extractControllerName(ControllerSign::class);
                    $this->redirect($class);
                }
                break;

            case ControllerAdmin::class:
                if ($this->keysExist()) {
                    $this->setUser();
                    if ($this->user->getPermission() == User::PERMIT_ADMIN) {
                        $class = $this->extractControllerName(ControllerSign::class);
                        (!$this->user->userExist()) ? $this->redirect($class) : null;
                    } else {
                        $class = $this->extractControllerName(ControllerSign::class);
                        $this->redirect($class);
                    }
                } else {
                    $class = $this->extractControllerName(ControllerSign::class);
                    $this->redirect($class);
                }
                break;
        }
    }

    protected function extractControllerName($class)
    {
        return strtolower(str_replace("Controller", "", $class));
    }

    /**
     * Destroy user's access to perform a sign out
     * @return boolean true if its success else false
     */
    protected function destroyAccess()
    {
        $session = $this->request->getSession();
        $session->destroy();
    }

    /**
     * Initialize the user attribut
     */
    private function setUser()
    {
        $session = $this->request->getSession();
        $privK = $session->getAttribute(User::SESSION_PRIVATE_K);
        $pubK = $session->getAttribute(User::SESSION_PUBLIC_K);
        $this->user = new user();
        $this->user->setkeys($privK, $pubK);
    }

    /**
     * Check if private and public keys exist in user's session
     * @return boolean true if keys exist else false
     */
    private function keysExist()
    {
        $session = $this->request->getSession();
        return ($session->existingAttribute(User::SESSION_PRIVATE_K)) && ($session->existingAttribute(User::SESSION_PUBLIC_K));
    }

    /**
     * Check if data's format is correct
     * @param string $type data's type
     * @param string $key data's access key in $reponse if there is error
     * @param string $value value to check
     * @param boolean $isRequired set true if value is required (can NOT be empty) alse false
     * @param Response $response to push in occured errors
     */
    protected function checkData($type, $key, $value, Response $response, $isRequired = false, $length = null)
    {
        // var_dump($value);
        if ($isRequired && (empty($value))) {
            $errorMsg = "ce champ ne paut pas être vide!";
            $response->addError($errorMsg, $key);
            return $response;
        }
        switch ($type) {
            case self::PSEUDO:
                if (preg_match(self::PSEUDO_REGEX, $value) != 1) {
                    $errorMsg = "les valeurs autorisées pour ce champ sont les lettres, les chiffres, '-' et '_' sans espace";
                    $response->addError($errorMsg, $key);
                }
                break;
            case self::NAME:
                if (preg_match(self::NAME_REGEX, $value) != 1) {
                    $errorMsg = "les valeurs autorisées pour ce champ sont les lettres et '-'";
                    $response->addError($errorMsg, $key);
                }
                break;
            case self::PASSWORD:
                if (preg_match(self::PASSWORD_REGEX, $value) != 1) {
                    $errorMsg = "les valeurs autorisées pour ce champ sont les lettres, les chiffres, '-' et '_' sans espace";
                    $response->addError($errorMsg, $key);
                }
                break;

            case self::ALPHA_NUMERIC:
                if (preg_match(self::ALPHA_NUMERIC_REGEX, $value) != 1) {
                    $errorMsg = "les valeurs autorisées pour ce champ sont les lettres et les chiffres sans espace";
                    $response->addError($errorMsg, $key);
                }
                break;
            case self::DATE:
                if (preg_match(self::DATE_REGEX, strtolower($value), $matches) != 1) {
                    $errorMsg = "la date doit être au format dd/mm/yyyy.";
                    $response->addError($errorMsg, $key);
                } else {
                    $d = $matches[1];
                    $m = $matches[2];
                    $y = $matches[3];
                    if (!is_numeric($m)) {
                        $m = $this->monthToint($m);
                    }
                    if (!checkdate($m, $d, $y)) {
                        $errorMsg = "Cette date n'existe pas.";
                        $response->addError($errorMsg, $key);
                    }
                }
                break;
            case self::TEXT:
                if (!isset($length)) {
                    throw new Exception('Attribut "$length" must be set to check a text\'s size.');
                }
                if (strlen($value) > $length) {
                    $errorMsg = "la valeur de ce champ est trop longue, la longueur maximal est $length caractères";
                    $response->addError($errorMsg, $key);
                }
                break;

            case self::FILE:
                $ext = pathinfo($value, PATHINFO_EXTENSION);

                if (!in_array(strtolower($ext), User::VALID_EXTENSIONS)) {
                    $errorMsg = "ce type de fichier n'est pas supporté";
                    $response->addError($errorMsg, $key);
                }
                break;
        }
    }

    /**
     * To check picture submited
     * @param string $key data's access key in $reponse if there is error
     * @param string $value file's name
     * @param Response $response to push in occured errors
     */
    // protected function checkFile($key, $filename, Response $response)
    // {
    //     // $filename = $_FILES[$key]['name'];
    //     // $location = "upload/" . $filename;
    //     $ext = pathinfo($filename, PATHINFO_EXTENSION);

    //     if (!in_array(strtolower($ext), User::VALID_EXTENSIONS)) {
    //         $errorMsg = "ce type de fichier n'est pas supporté";
    //         $response->addError($errorMsg, $key);
    //     }
    // }

    /**
     * Convert frech textual month to its integer value
     * @param string $m month to convert
     */
    private function monthToint($m)
    {
        switch (strtolower($m)) {
            case "janvier":
                return 1;
                break;
            case "fevrier":
                return 2;
                break;
            case "mars":
                return 3;
                break;
            case "avril":
                return 4;
                break;
            case "mai":
                return 5;
                break;
            case "juin":
                return 6;
                break;
            case "juillet":
                return 7;
                break;
            case "aout":
                return 8;
                break;
            case "septembre":
                return 9;
                break;
            case "octobre":
                return 10;
                break;
            case "novembre":
                return 11;
                break;
            case "decembre":
                return 12;
                break;
            default:
                throw new Exception("Unknow month '$m'");
                break;
        }
    }
}
