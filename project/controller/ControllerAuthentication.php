<?php

require_once 'framework/Controller.php';
require_once 'model/MyError.php';

/**
 * This class is used to check user's authentications
 */
abstract class ControllerAuthentication extends Controller
{
    /**
     * Holds the input type
     */
    protected const PSEUDO = "pseudo";
    protected const NAME = "name";  // handle space and `-`
    protected const PASSWORD = "psw";

    /**
     * Holds REGEX for input type
     */
    const PSEUDO_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_]*$#";
    const NAME_REGEX = "#^[a-zA-Z-]+$#";
    const PASSWORD_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_]+$#";

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
