<?php

require_once 'ControllerAuthentication.php';

class ControllerHome extends ControllerAuthentication
{
    const CTR_NAME = "home";

    public function __construct()
    {
    }

    public function index()
    {
        $this->secureSession();
        $this->user->setProperties();
        $this->user->setDiscussions();
        $this->generateView(array("user" => $this->user));
    }
}
