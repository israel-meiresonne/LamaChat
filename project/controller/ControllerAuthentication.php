<?php

require_once 'framework/Controller.php';
require_once 'model/MyError.php';
require_once 'ControllerHome.php';
require_once 'ControllerSign.php';

/**
 * This class is used to check user's authentications
 */
abstract class ControllerAuthentication extends Controller
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

    /**
     * Holds REGEX for input type
     * @var string
     */
    private const PSEUDO_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_]*$#";
    private const NAME_REGEX = "#^[A-zÀ-ú]+$#";
    private const PASSWORD_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_]+$#";

    /**
     * Check if user's is allowed to access to one page
     */
    protected function secureSession()
    {
        $ctr = strtolower(str_replace("Controller", "", get_class($this)));
        switch ($ctr) {
            case ControllerSign::CTR_NAME:
                if ($this->keysExist()) {
                    $this->setUser();
                    ($this->user->userExist()) ? $this->redirect(ControllerHome::CTR_NAME) : null;
                }
                break;

            case ControllerHome::CTR_NAME:
                if ($this->keysExist()) {
                    $this->setUser();
                    !($this->user->userExist()) ? $this->redirect(ControllerSign::CTR_NAME) : null;
                } else {
                    $this->redirect(ControllerSign::CTR_NAME);
                }
                break;
        }
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
     * @param string $key input's name
     * @param string $input input value to check
     * @param boolean $isRequired set true if value is required (can NOT be empty) alse false
     * @param Response $response to push in occured errors
     */
    protected function checkInput($type, $key, $inputVal, $response, $isRequired = false)
    {
        // var_dump($inputVal);
        if ($isRequired && (empty($inputVal))) {
            $errorMsg = "ce champ ne paut pas être vide!";
            $response->addError($errorMsg, $key);
            return $response;
        }
        switch ($type) {
            case self::PSEUDO:
                if (preg_match(self::PSEUDO_REGEX, $inputVal) != 1) {
                    $errorMsg = "les valeurs autorisées pour ce champ sont les lettres, les chiffres, '-' et '_' sans espace";
                    $response->addError($errorMsg, $key);
                }
                break;
            case self::NAME:
                if (preg_match(self::NAME_REGEX, $inputVal) != 1) {
                    $errorMsg = "les valeurs autorisées pour ce champ sont les lettres et '-'";
                    $response->addError($errorMsg, $key);
                }
                break;
            case self::PASSWORD:
                if (preg_match(self::PASSWORD_REGEX, $inputVal) != 1) {
                    $errorMsg = "les valeurs autorisées pour ce champ sont les lettres, les chiffres, '-' et '_' sans espace";
                    $response->addError($errorMsg, $key);
                }
                break;
        }
    }
}
