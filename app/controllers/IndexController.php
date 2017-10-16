<?php

namespace App\Controllers;

use App\Validators\FilmValidator;
use App\Vendor\View;
use App\Vendor\Controller;
use App\Vendor\Link;
use App\Models\Film;
use App\Vendor\Validator\ErrorValidator;

class IndexController extends Controller
{
    public function beforeAction()
    {
        $this->storage['header'] = (new HeaderController($this->registry))->index();
        $this->storage['footer'] = (new FooterController($this->registry))->index();
        $this->storage['request'] = $this->request;

        if (!($this->storage['errors'] instanceof ErrorValidator)) {
            $this->storage['errors'] = new ErrorValidator();
        }
    }

    public function index()
    {
        return $this->getList();
    }

    public function create()
    {
        return $this->getForm();
    }

    public function store()
    {
        $this->storage['errors'] = (new FilmValidator($this->request))->validate();

        if ($this->storage['errors']->hasErrors()) {
            return $this->getForm();
        };

        $this->storage['film'] = new Film($this->registry);
        $this->storage['film']->newRecord();

        return $this->getList();
    }

    public function edit()
    {
        $film = new Film($this->registry);

        $this->storage['film'] = $film->getRecord($this->request->id);

        return $this->getForm();
    }

    public function update()
    {
        $this->storage['errors'] = (new FilmValidator($this->request))->validate();

        $film = new Film($this->registry);

        if ($this->storage['errors']->hasErrors()) {
            $this->storage['film'] = $film->getRecord($this->request->id);

            return $this->getForm();
        }

        $film->updateRecord($this->request->id);

        return $this->getList();
    }

    public function delete()
    {
        $film = new Film($this->registry);

        $film->deleteRecord($this->request->id);

        $this->response->redirect(Link::getLink());
    }

    private function getForm()
    {
        $this->storage['filmFormats'] = Film::getFilmFormats();

        return (new View('form.tpl', $this->storage))->render();
    }

    private function getList()
    {
        $film = new Film($this->registry);

        $this->storage['films'] = $film->getAllFilms();

        return (new View('index.tpl', $this->storage))->render();
    }
}
