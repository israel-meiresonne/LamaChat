<?php

require_once 'framework/Controller.php';
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
     * datas access keys
     */
    public const KEY_PSEUDO = "pseudo";
    public const KEY_FIRSTNAME = "firstname";
    public const KEY_LASTNAME = "lastname";
    public const KEY_PSW = "password";

    /**
     * Holds the input types
     * @var string
     */
    protected const PSEUDO = "pseudo";
    protected const NAME = "name";  // handle space and `-`
    protected const PASSWORD = "psw";
    protected const KEY_SEARCH = "search";
    protected const ALPHA_NUMERIC = "alpha_numeric";

    /**
     * Holds REGEX for input type
     * @var string
     */
    private const PSEUDO_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_]*$#";
    private const NAME_REGEX = "#^[A-zÀ-ú-]+$#";
    private const PASSWORD_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_]+$#";
    const PALPHA_NUMERIC_REGEX = "#^[a-zA-Z0-9]+$#";

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
     * @param string $key data's access key
     * @param string $value value to check
     * @param boolean $isRequired set true if value is required (can NOT be empty) alse false
     * @param Response $response to push in occured errors
     */
    protected function checkData($type, $key, $value, $response, $isRequired = false)
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
                if (preg_match(self::PALPHA_NUMERIC_REGEX, $value) != 1) {
                    $errorMsg = "les valeurs autorisées pour ce champ sont les lettres et les chiffres sans espace";
                    $response->addError($errorMsg, $key);
                }
                break;
        }
    }
}
