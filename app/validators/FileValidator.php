<?php

namespace App\Validators;

use App\Vendor\Validator\Validator;

class FileValidator extends Validator
{
    public function validate()
    {
        $this->checkFileError('films');

        return $this->error;
    }
}