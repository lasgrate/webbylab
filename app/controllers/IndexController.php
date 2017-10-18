<?php

namespace App\Controllers;

use App\Validators\FilmValidator;
use App\Vendor\View;
use App\Vendor\Controller;
use App\Models\Film;
use App\Vendor\Validator\ErrorValidator;

class IndexController extends Controller
{
    public function beforeAction()
    {
        $this->storage['header'] = (new HeaderController($this->registry))->index();
        $this->storage['footer'] = (new FooterController($this->registry))->index();
        $this->storage['request'] = $this->request;

        if (!isset($this->storage['errors'])) {
            $this->storage['errors'] = new ErrorValidator();
        }
    }

    public function index()
    {
        $this->getList();
    }

    public function create()
    {
        $this->getForm();
    }

    public function store()
    {
        $this->storage['errors'] = (new FilmValidator($this->request))->validate();

        if ($this->storage['errors']->hasErrors()) {
            return $this->getForm();
        };

        $this->storage['film'] = new Film($this->registry);
        $this->storage['film']->newRecord();

        $this->getList();
    }

    public function edit()
    {
        $film = new Film($this->registry);

        $this->storage['film'] = $film->getRecord($this->request->id);

        $this->getForm();
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

        $this->getList();
    }

    public function delete()
    {
        $film = new Film($this->registry);

        $film->deleteRecord($this->request->id);

        $this->getList();
    }

    private function getForm()
    {
        $this->storage['filmFormats'] = Film::getFilmFormats();

        $view = new View('form.tpl', $this->storage);

        $this->response->setOutput($view->render());
    }

    private function getList()
    {
        $film = new Film($this->registry);

        $this->storage['films'] = $film->getAllFilms();

        $view = new View('index.tpl', $this->storage);

        $this->response->setOutput($view->render());
    }
}
