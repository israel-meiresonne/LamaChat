<?php

require_once 'ControllerAuthentication.php';

class ControllerHome extends ControllerAuthentication
{
    const HOME = "home";

    public function __construct()
    {
    }

    public function index()
    {
        $this->generateView();
    }
}
