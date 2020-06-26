<?php

require_once 'ControllerAuthentication.php';
require_once 'model/Response.php';

class ControllerSign extends ControllerAuthentication
{
    /**
     * Action used to Perform a new user registration 
     */
    const ACTION_SIGN_UP = "signUp";

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
        $this->generateView();
    }

    /**
     * Perform a registration of a new user
     */
    public function signUp(){
        $response = new Response();
        // try {
        //     $request = new Request(array_merge($_GET, $_POST));
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
        $this->checkInput(self::PSEUDO, self::INPUT_PSEUDO, $_POST[self::INPUT_PSEUDO], $response, true);
        $this->checkInput(self::NAME, self::INPUT_FIRSTNAME, $_POST[self::INPUT_FIRSTNAME], $response, true);
        $this->checkInput(self::NAME, self::INPUT_LASTNAME, $_POST[self::INPUT_LASTNAME], $response, true);
        $this->checkInput(self::PASSWORD, self::INPUT_PSW, $_POST[self::INPUT_PSW], $response, true);
        echo json_encode($response->getAttributs());
    }
}