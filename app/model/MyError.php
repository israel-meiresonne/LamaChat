<?php

class MyError {
    public $message;

    const ERROR_FILE = "error";
    const FATAL_ERROR = "fat_err";

    function __construct($message)
    {
        $this->message = $message;
    }
}