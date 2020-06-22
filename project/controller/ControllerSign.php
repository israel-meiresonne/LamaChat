<?php

require_once 'framework/Controller.php';

class ControllerSign extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $this->generateView();
    }
}