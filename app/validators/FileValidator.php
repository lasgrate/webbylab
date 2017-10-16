<?php

namespace App\Validators;

use App\Vendor\Validator\Validator;

class FileValidator extends Validator
{
    private function fileValidate($parameterName) {

        $this->issetFile($parameterName);
    }

    public function validate()
    {
        $this->fileValidate('films');

        return $this->error;
    }
}