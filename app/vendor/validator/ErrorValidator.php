<?php

namespace App\Vendor\Validator;

class ErrorValidator
{
    /**
     * Errors
     *
     * @var array
     */
    private $errors = [];

    /**
     * Push $message (error) to $this->>errors as key - $parameterName.
     *
     * @param $parameterName
     * @param $message
     */
    public function push($parameterName, $message)
    {
        $this->errors[$parameterName][] = $message;
    }

    /**
     * Parameter can have more than one error.
     * So this method get first errors of each parameter.
     *
     * @return array
     */
    public function getFirstErrors()
    {
        $firstErrors = [];

        foreach ($this->errors as $parameterName => $error) {
            if (isset($error[0])) {
                $firstErrors[$parameterName] = $error[0];
            }
        }

        return $firstErrors;
    }

    /**
     * Check if validator has errors.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * Get all errors.
     *
     * @return array
     */
    public function getAllErrors() {
        return $this->errors;
    }

    /**
     * Check if $parameterName has at least one errors.
     *
     * @param $parameterName
     * @return bool
     */
    public function hasError($parameterName)
    {
        return !empty($this->errors[$parameterName]);
    }

    /**
     * Get all $parameterName errors.
     *
     * @param $parameterName
     * @return mixed
     */
    public function getError($parameterName)
    {
        return $this->errors[$parameterName];
    }

    /**
     * Get first $parameterName error.
     *
     * @param $parameterName
     * @return string
     */
    public function getFirstError($parameterName)
    {
        return isset($this->errors[$parameterName][0]) ? $this->errors[$parameterName][0] : '';
    }
}