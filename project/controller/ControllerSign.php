<?php

require_once 'ControllerSecure.php';
require_once 'ControllerHome.php';
require_once 'model/Response.php';
require_once 'model/User.php';

class ControllerSign extends ControllerSecure
{
    /**
     * Controller's name
     */
    const CTR_NAME = "sign";

    /**
     * Action used to Perform a new user registration 
     */
    const ACTION_SIGN_UP = "sign/signUp";

    /**
     * Action used to Perform a new user registration 
     */
    const ACTION_SIGN_IN = "sign/signIn";

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
    public function signUp()
    {
        $response = new Response();
        $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response, true);
        $this->checkData(self::NAME, User::KEY_FIRSTNAME, $_POST[User::KEY_FIRSTNAME], $response, true);
        $this->checkData(self::NAME, User::KEY_LASTNAME, $_POST[User::KEY_LASTNAME], $response, true);
        $this->checkData(self::PASSWORD, User::KEY_PSW, $_POST[User::KEY_PSW], $response, true);
        if (!$response->containError()) {
            $user = new User($_POST[User::KEY_PSEUDO], $_POST[User::KEY_PSW], $_POST[User::KEY_FIRSTNAME], $_POST[User::KEY_LASTNAME]);
            $session = $this->request->getSession();
            if ($user->signUp($response, $session)) {
                $webRoot = Configuration::get("webRoot", "/");
                $response->addResult(self::ACTION_SIGN_UP, $webRoot . ControllerHome::CTR_NAME);
            }
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Perform a sign in of a user
     */
    public function signIn()
    {
        $response = new Response();
        $this->checkData(self::PSEUDO, User::KEY_PSEUDO, $_POST[User::KEY_PSEUDO], $response, true);
        $this->checkData(null, User::KEY_PSW, $_POST[User::KEY_PSW], $response, true);
        if (!$response->containError()) {
            $user = new User($_POST[User::KEY_PSEUDO], $_POST[User::KEY_PSW]);
            $session = $this->request->getSession();
            if ($user->signIn($response, $session)) {
                $webRoot = Configuration::get("webRoot", "/");
                $response->addResult(self::ACTION_SIGN_IN, $webRoot . ControllerHome::CTR_NAME);
            }
        }
        echo json_encode($response->getAttributs());
    }
}
