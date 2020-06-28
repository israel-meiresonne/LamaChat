<?php

require_once 'ControllerAuthentication.php';
require_once 'ControllerHome.php';
require_once 'model/Response.php';
require_once 'model/User.php';

class ControllerSign extends ControllerAuthentication
{
    const CTR_NAME = "sign";

    /**
     * Action used to Perform a new user registration 
     */
    const ACTION_SIGN_UP = "signUp";

    /**
     * Action used to Perform a new user registration 
     */
    const ACTION_SIGN_IN = "signIn";

    // /**
    //  * Action used to Perform a new user registration 
    //  */
    // const ACTION_SIGN_UP = "rspSignUp";

    /**
     * Input names
     */
    const INPUT_PSEUDO = "pseudo";
    const INPUT_FIRSTNAME = "firstname";
    const INPUT_LASTNAME = "lastname";
    const INPUT_PSW = "password";

    public function __construct()
    {
    }

    public function index()
    {
        $this->secureSession();
        $this->generateView();
    }

    /**
     * Perform a registration of a new user
     */
    public function signUp(){
        $response = new Response();
        $this->checkInput(self::PSEUDO, self::INPUT_PSEUDO, $_POST[self::INPUT_PSEUDO], $response, true);
        $this->checkInput(self::NAME, self::INPUT_FIRSTNAME, $_POST[self::INPUT_FIRSTNAME], $response, true);
        $this->checkInput(self::NAME, self::INPUT_LASTNAME, $_POST[self::INPUT_LASTNAME], $response, true);
        $this->checkInput(self::PASSWORD, self::INPUT_PSW, $_POST[self::INPUT_PSW], $response, true);
        if(!$response->containError()){
            $user = new User($_POST[self::INPUT_PSEUDO], $_POST[self::INPUT_PSW], $_POST[self::INPUT_FIRSTNAME], $_POST[self::INPUT_LASTNAME]);
            $session = $this->request->getSession();
            if($user->signUp($response, $session)){
                $webRoot = Configuration::get("webRoot", "/");
                $response->addResult(self::ACTION_SIGN_UP, $webRoot.ControllerHome::CTR_NAME);
            }
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Perform a sign in of a user
     */
    public function signIn(){
        $response = new Response();
        $this->checkInput(self::PSEUDO, self::INPUT_PSEUDO, $_POST[self::INPUT_PSEUDO], $response, true);
        $this->checkInput(null, self::INPUT_PSW, $_POST[self::INPUT_PSW], $response, true);
        if(!$response->containError()){
            $user = new User($_POST[self::INPUT_PSEUDO], $_POST[self::INPUT_PSW]);
            $session = $this->request->getSession();
            if($user->signIn($response, $session)){
                $webRoot = Configuration::get("webRoot", "/");
                $response->addResult(self::ACTION_SIGN_IN, $webRoot.ControllerHome::CTR_NAME);
            }
        }
        echo json_encode($response->getAttributs());
    }
}