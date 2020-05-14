<?php

require_once 'framework/Controller.php';

class ControllerHome extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $this->generateView();
    }
}
