<?php

namespace App\Vendor\Validator;

use App\Vendor\Request;

abstract class Validator
{
    /**
     * POST, GET and FILES parameters.
     *
     * @var array
     */
    protected $request;

    /**
     * COOKIES
     *
     * @var array
     */
    protected $cookies;

    /**
     * @var array
     */
    protected $error;

    /**
     * Validator constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = array_merge($request->get, $request->post, $request->files);
        $this->cookies = $request->cookie;
        $this->error = new ErrorValidator();
    }

    /**
     * Check if $parameterName is set.
     *
     * @param $parameterName
     * @return bool
     */
    protected function issetParameter($parameterName)
    {
        if (isset($this->request[$parameterName])) {
            return true;
        } else {
            $this->error->push($parameterName, "The {$parameterName} is require.");
            return false;
        }
    }

    protected function checkFileError($parameterName) {

        if (isset($this->request[$parameterName]) && $this->request[$parameterName]['error'] == 0) {
            return true;
        } else {
            $this->error->push($parameterName, "File error.");
            return false;
        }
    }

    /**
     * Check if $parameterName is string.
     *
     * @param $parameterName
     * @return bool
     */
    protected function isString($parameterName)
    {
        if (is_string($this->request[$parameterName])) {
            return true;
        } else {
            $this->error->push($parameterName, "The {$parameterName} must be string.");
            return false;
        }
    }

    /**
     * Check if $parameterName larger than $size.
     *
     * @param $parameterName
     * @param $size
     * @return bool
     */
    protected function minStringSize($parameterName, $size)
    {
        if (strlen($this->request[$parameterName]) >= $size) {
            return true;
        } else {
            $this->error->push($parameterName,"The {$parameterName} must have {$size} minimal size.");
            return false;
        }
    }

    /**
     * Check if $parameterName less than $size.
     *
     * @param $parameterName
     * @param $size
     * @return bool
     */
    protected function maxStringSize($parameterName, $size)
    {
        if (strlen($this->request[$parameterName]) <= $size) {
            return true;
        } else {
            $this->error->push($parameterName, "The {$parameterName} must have {$size} maximum size.");
            return false;
        }
    }

    /**
     * Check if $parameterName less than $maxSize and larger than $minSize.
     *
     * @param $parameterName
     * @param $minSize
     * @param $maxSize
     * @return bool
     */
    protected function betweenStringSize($parameterName, $minSize, $maxSize)
    {
        if ((strlen($this->request[$parameterName]) <= $maxSize) && (strlen($this->request[$parameterName]) >= $minSize)) {
            return true;
        } else {
            $this->error->push($parameterName, "The {$parameterName} size must be between {$minSize} and {$maxSize} maximum size.");
            return false;
        }
    }

    /**
     * Check $parameterName according datetime formats.
     *
     * @param $parameterName
     * @param $format
     * @return bool
     */
    protected function isDateTimeFormat($parameterName, $format)
    {
        if (\DateTime::createFromFormat($format, $this->request[$parameterName]) instanceof \DateTime) {
            return true;
        } else {
            $this->error->push($parameterName, "The {$parameterName} must be according to $format datetime format.");
            return false;
        }
    }

    /**
     * Check if $parameterName is present in $array.
     *
     * @param $parameterName
     * @param $array
     * @return bool
     */
    protected function isIn($parameterName, $array)
    {
        if (in_array($this->request[$parameterName], $array)) {
            return true;
        } else {
            $chosen = implode(', ',  $array);
            $this->error->push($parameterName, "The {$parameterName} must be chosen from [{$chosen}] datetime format.");
            return false;
        }
    }

    /**
     * @return ErrorValidator
     */
    abstract public function validate();

    /**
     * Get all errors.
     *
     * @return array
     */
    public function getErrors() {
        return $this->error->getAllErrors();
    }

    /**
     * Get first errors of each parameters
     *
     * @return mixed
     */
    public function getFirstErrors() {
        return $this->error->getFirstErrors();
    }
}