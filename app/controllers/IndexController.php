<?php

namespace App\Controller;

use App\Validators\FilmValidator;
use App\Validators\FileValidator;
use App\Vendor\Validator\ErrorValidator;
use App\Vendor\View;
use App\Models\Film;
use App\Vendor\Controller;
use App\Vendor\Link;

class IndexController extends Controller
{
    public function index()
    {
        $data['header'] = (new HeaderController($this->registry))->index();
        $data['footer'] = (new FooterController($this->registry))->index();
        $data['films'] = $this->storage['films'];
        $data['errors'] = $this->storage['errors'];
        $data['request'] = $this->request;

        return (new View('index.tpl', $data))->render();
    }

    public function create()
    {
        $data['header'] = (new HeaderController($this->registry))->index();
        $data['footer'] = (new FooterController($this->registry))->index();

        $data['errors'] = $this->storage['errors'];
        $data['request'] = $this->request;

        $data['film'] = $this->storage['film'];
        $data['filmFormats'] = Film::getFilmFormats();

        return (new View('form.tpl', $data))->render();
    }

    public function store()
    {
        $this->storage['errors'] = (new FilmValidator($this->request))->validate();

        if ($this->storage['errors']->hasErrors()) {
            return $this->create();
        };

        $this->storage['film']->newRecord();

        $this->response->redirect(Link::getLink());
    }

    public function edit()
    {
        $this->storage['film'] = (new Film($this->registry))->getRecord($this->request->id);

        return $this->create();
    }

    public function update()
    {
        $this->storage['errors'] = (new FilmValidator($this->request))->validate();

        if ($this->storage['errors']->hasErrors()) {
            $this->storage['film'] = (new Film($this->registry))->getRecord($this->request->id);
            return $this->create();
        }

        (new Film($this->registry))->updateRecord($this->request->id);

        $this->response->redirect(Link::getLink());
    }

    public function delete()
    {
        (new Film($this->registry))->deleteRecord($this->request->id);

        $this->response->redirect(Link::getLink());
    }

    public function parser()
    {
        $this->storage['errors'] = (new FileValidator($this->request))->validate();

        if ($this->storage['errors']->hasErrors()) {
            return $this->index();
        }

        $fileContent = file_get_contents($this->request->files['films']['tmp_name']);

        $titleRegularExpression = "Title:\s*([a-zA-Z]*\s*[a-zA-Z]+)(\n\r|\n|\r)";
        $yearRegularExpression = "Release Year:\s*(\d{4})(\n\r|\n|\r)";
        $formatRegularExpression = "Format:\s*(VHS|DVD|Blu-Ray)(\n\r|\n|\r)";
        $actorsRegularExpression = "Stars:\s*(([a-zA-Z]*\s*[a-zA-Z]+,*)+)(\n\r|\n|\r)";

        $pattern = '/' . $titleRegularExpression . $yearRegularExpression . $formatRegularExpression . $actorsRegularExpression . '/';

        preg_match_all($pattern, $fileContent, $matches, PREG_SET_ORDER);

        $films = [];

        foreach ($matches as $filmRecord) {
            $films[] = [
                'name' => $filmRecord[1],
                'year' => $filmRecord[3],
                'format' => $filmRecord[5],
                'actors' => json_encode(explode(', ',$filmRecord[7]), JSON_UNESCAPED_UNICODE),
            ];
        }

        (new Film($this->registry))->saveMany($films);

        $this->response->redirect(Link::getLink());
    }

    public function preAction($actionName)
    {
        $this->storage['errors'] = new ErrorValidator();

        $this->storage['film'] = new Film($this->registry);

        $film = new Film($this->registry);

        if (in_array($actionName, ['index', 'parser'])) {
            $this->storage['films'] = $film->getAllFilms();
        } elseif (in_array($actionName, ['create'])) {
            $this->storage['film'] = [];
        } elseif (in_array($actionName, ['create'])) {
            $this->storage['film'] = $film;
        }
    }
}
