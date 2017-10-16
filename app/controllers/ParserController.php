<?php

namespace App\Controllers;

use App\Vendor\Controller;
use App\Validators\FileValidator;
use App\Models\Film;
use App\Vendor\Link;

class ParserController extends Controller
{
    const TITLE_REGULAR_EXPRESSION = "Title:\s*([a-zA-Z]*\s*[a-zA-Z]+)(\n\r|\n|\r)";
    const YEAR_REGULAR_EXPRESSION = "Release Year:\s*(\d{4})(\n\r|\n|\r)";
    const FORMAT_REGULAR_EXPRESSION = "Format:\s*(VHS|DVD|Blu-Ray)(\n\r|\n|\r)";
    const ACTORS_REGULAR_EXPRESSION = "Stars:\s*(([a-zA-Z]*\s*[a-zA-Z]+,*)+)(\n\r|\n|\r)";

    public function index()
    {
        if (empty($this->request->files)) {
            $this->response->redirect(Link::getLink());
        }

        $this->storage['errors'] = (new FileValidator($this->request))->validate();

        if ($this->storage['errors']->hasErrors()) {
            return (new IndexController($this->registry, $this->storage))->index();
        }

        $fileContent = file_get_contents($this->request->files['films']['tmp_name']);

        preg_match_all(self::getPattern(), $fileContent, $matches, PREG_SET_ORDER);

        $films = [];

        foreach ($matches as $filmRecord) {
            $films[] = [
                'name' => $filmRecord[1],
                'year' => $filmRecord[3],
                'format' => $filmRecord[5],
                'actors' => json_encode(explode(', ', $filmRecord[7]), JSON_UNESCAPED_UNICODE),
            ];
        }

        (new Film($this->registry))->saveMany($films);

        $this->response->redirect(Link::getLink());
    }

    public static function getPattern()
    {
        return '/' .
            self::TITLE_REGULAR_EXPRESSION .
            self::YEAR_REGULAR_EXPRESSION .
            self::FORMAT_REGULAR_EXPRESSION .
            self::ACTORS_REGULAR_EXPRESSION .
            '/';
    }
}