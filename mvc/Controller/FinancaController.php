<?php

namespace Mvc\Controller;

use Mvc\Model\FinancaModel;

class FinancaController extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new FinancaModel;
    }
    public function index($id)
    {
        $list = $this->model->setId($id)->list();
        return json_encode($list->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function create()
    {
        $nome = $_POST['nome'];
        $valor = $_POST['valor'];
        $categoria = $_POST['categoria'];
        $tipo = $_POST['tipo'];
        $data = $_POST['criado'];
        $criado = $data;
        $editado = $data;
        $pago = null;

        $create = $this->model
            ->setNome($nome)
            ->setValor($valor)
            ->setCategoria($categoria)
            ->setTipo($tipo)
            ->setCriado($criado)
            ->setEditado($editado)
            ->setPago($pago);
        if ($create->post()) {
            $this->jsonResponse(null, 202);
            header('Location: /');
        }
    }

    public function update()
    {
        $id = $_GET['id'];
        $nome = $_POST['nome'];
        $criado = $_POST["criado"];
        $valor = $_POST['valor'];
        $categoria = $_POST['categoria'];
        $tipo = $_POST['tipo'];
        $editado = date('Y-m-d');

        $update = $this->model
            ->setNome($nome)
            ->setValor($valor)
            ->setCategoria($categoria)
            ->setTipo($tipo)
            ->setCriado($criado)
            ->setEditado($editado)
            ->setId($id);
        if ($update->put()) {
            $this->jsonResponse(null, 201);
            header('Location: /');
        }
    }

    public function delete()
    {
        $id = $_GET["id"];
        $delete = $this->model->setId($id);
        if ($delete->destroy()) {
            $this->jsonResponse(null, 200);
            header('Location: /');
        }
    }

    public function payFinanca()
    {
        $id = $_GET['pagar'];
        $payed = $this->model
            ->setId($id)
            ->setPago(date('Y-m-d'));
        if ($payed->pay()) {
            $this->jsonResponse(null, 200);
            header('Location: /');
        }
    }
}

BaseController::init(FinancaController::class);
