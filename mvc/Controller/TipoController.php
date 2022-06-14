<?php

namespace Mvc\Controller;

use Mvc\Model\TipoModel;

class TipoController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new TipoModel;
    }

    public function index($id)
    {
        $list = $this->model->setId($id)->list();
        return json_encode($list->fetchAll(\PDO::FETCH_ASSOC));
    }
}

BaseController::init(TipoController::class);
