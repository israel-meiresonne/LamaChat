<?php

class Response
{
    /**
     * Holds the response's status
     * @var boolean $isSuccess set true if it's success else false
     */
    private $isSuccess;

    /**
     * Holds a list of result
     * @var mixed[]
     */
    private $results;

    /**
     * Holds list of error
     * @var MyError
     */
    private $errors;

    /**
     * Constuctor
     */
    function __construct()
    {
        $this->isSuccess = false;
        $this->results = [];
        $this->errors = [];
    }

    /**
     * Setter for response's success status
     * @param boolean $isSuccess success status
     */
    public function setIsSuccess($isSuccess){
        $this->isSuccess = $isSuccess;
    }

    /**
     * To get a result stored at the key given in param
     * @return string result stored at the key given in param
     */
    public function getResult($key)
    {
        return $this->results[$key];
    }

    /**
     * To get a error stored at the key given in param
     * @return string error stored at the key given in param
     */
    public function getError($key)
    {
        return $this->errors[$key];
    }

    /**
     * Add a result in in the key given
     * @param string $key
     * @param string $result
     */
    public function addResult($key, $result)
    {
        if (count($this->errors) > 0) {
            throw new Exception('Cannot add result when $error is not empty');
        }
        !($this->isSuccess) ? ($this->isSuccess = true) : null;
        // $this->results[$key] = $result;
        if (!empty($key)) {
            $this->results[$key] = $result;
        } else {
            array_push($this->results, $result);
        }
    }

    /**
     * Add a result in the key given
     * @param MyError $errorMsg
     */
    public function addError($errorMsg, $key = null)
    {
        if (count($this->results) > 0) {
            throw new Exception('Cannot add error when $result is not empty');
        } else {
            $this->isSuccess = false;
        }
        $error = new MyError($errorMsg);
        if (!empty($key)) {
            $this->errors[$key] = $error;
        } else {
            array_push($this->errors, $error);
        }
    }

    /**
     * To get Response's attributs
     * @return string[] Response's attributs in a map format
     */
    public function getAttributs()
    {
        return get_object_vars($this);
    }

    /**
     * Check if the Response is successful
     * @return boolean true if Response is successful else false
     */
    public function isSuccess()
    {
        return ((count($this->results) > 0) || $this->isSuccess);
    }

    /**
     * Check if there if an error in Response
     * @return boolean true if there is a error else false
     */
    public function containError()
    {
        return (count($this->errors) > 0);
    }

    /**
     * Unset the result at the position given in param
     * @param string $key
     * @return boolean true if value is found and unseted else false and unset value
     */
    public function unsetResult($key)
    {
        if (isset($this->results[$key])) {
            unset($this->results[$key]);
            return true;
        }
        unset($this->results[$key]);
        return false;
    }
}
