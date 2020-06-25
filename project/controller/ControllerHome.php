<?php

require_once 'ControllerAuthentication.php';

class ControllerHome extends ControllerAuthentication
{

    public function __construct()
    {
    }

    public function index()
    {
        $this->generateView();
    }
}
