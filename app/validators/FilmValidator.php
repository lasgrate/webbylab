<?php

namespace App\Validators;

use App\Vendor\Validator\Validator;

class FilmValidator extends Validator
{
    private function nameValidate($parameterName)
    {
        if ($this->issetParameter($parameterName)) {

            $this->isString($parameterName);

            $this->betweenStringSize($parameterName, 2, 255);
        }
    }

    private function yearValidate($parameterName)
    {
        if ($this->issetParameter($parameterName)) {

            $this->isString($parameterName);

            $this->isDateTimeFormat($parameterName, 'Y');
        }
    }

    private function formatValidate($parameterName)
    {
        if ($this->issetParameter($parameterName)) {
            $this->isIn($parameterName, \App\Models\Film::getFilmFormats());
        }
    }

    private function actorsValidate($parameterName)
    {
        if ($this->issetParameter($parameterName) && $this->isString($parameterName)) {

            $this->minStringSize($parameterName, 10);

            $actors = preg_split("/\r\n|\n|\r/", $this->request['actors'], -1, PREG_SPLIT_NO_EMPTY);

            foreach ($actors as $actor) {
                if(strlen($actor) < 2) {
                    $this->error->push($parameterName, 'Actor name and surname must have at lease 2 characters.');
                }
            }
        }
    }

    public function validate()
    {
        $this->nameValidate('name');
        $this->yearValidate('year');
        $this->formatValidate('format');
        $this->actorsValidate('actors');

        return $this->error;
    }
}