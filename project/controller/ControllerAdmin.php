<?php

require_once 'ControllerSecure.php';

class ControllerAdmin extends ControllerSecure
{
    public function index()
    {
        $this->secureSession();
        $this->user->setProperties();
        $this->user->setDiscussions();
        $this->user->setContacts();
        $this->generateView(array("user" => $this->user));
    }
}
