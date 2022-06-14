<?php

namespace Mvc\Controller;

use Mvc\Model\CategoriaModel;

class CategoriaController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new CategoriaModel;
    }
    public function index($id)
    {
        $list = $this->model->setId($id)->list();
        return json_encode($list->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function create()
    {
        $title = $_POST['title'];
        $slug = $_POST['slug'];

        $create = $this->model->setTitle($title)
            ->setSlug($slug);
        if ($create->post()) {
            $this->jsonResponse(null, 202);
            header('Location: /categorias');
        }
    }

    public function update()
    {
        $id = $_GET['id'];
        $title = $_POST['title'];
        $slug = $_POST['slug'];
        $update = $this->model->setTitle($title)
            ->setSlug($slug)
            ->setId($id);
        if ($update->put()) {
            $this->jsonResponse(null, 201);
            header('Location: /categorias');
        }
    }

    public function delete()
    {
        $id = $_GET["id"];
        $delete = $this->model->setId($id);
        if ($delete->destroy()) {
            $this->jsonResponse(null, 200);
            header('Location: /categorias');
        }
    }
}

BaseController::init(CategoriaController::class);
