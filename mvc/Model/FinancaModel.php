<?php

namespace Mvc\Model;


class FinancaModel extends BaseModel
{
    private $id;
    private $nome;
    private $valor;
    private $categoria;
    private $tipo;
    private $criado;
    private $editado;
    private $pago;
    private $table = "financas";

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getValor()
    {
        return $this->valor;
    }
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
        return $this;
    }

    public function getTipo()
    {
        return $this->tipo;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }


    public function getCriado()
    {
        return $this->criado;
    }
    public function setCriado($criado)
    {
        $this->criado = $criado;
        return $this;
    }

    public function getEditado()
    {
        return $this->editado;
    }
    public function setEditado($editado)
    {
        $this->editado = $editado;
        return $this;
    }

    public function getPago()
    {
        return $this->pago;
    }
    public function setPago($pago)
    {
        $this->pago = $pago;
        return $this;
    }

    public function list()
    {
        $pdo = $this->returnConnection();
        $where = $this->id ? ' where id=' . $this->id : '';
        $list =  $pdo->prepare("select * from " . $this->table . $where);

        return ($list->execute() ? $list : false);
    }

    public function post()
    {
        $pdo = $this->returnConnection();
        $create = $pdo->prepare("INSERT INTO `$this->table`( `nome`, `valor`,`categoria`,`tipo`,`criado`, `editado`, `pago`) VALUES (:nome,:valor, :categoria, :tipo, :criado, :editado, :pago)");
        $create->bindParam(':nome', $this->nome);
        $create->bindParam(':valor', $this->valor);
        $create->bindParam(':categoria', $this->categoria);
        $create->bindParam(':tipo', $this->tipo);
        $create->bindParam(':criado', $this->criado);
        $create->bindParam(':editado', $this->editado);
        $create->bindParam(':pago', $this->pago);

        return ($create->execute() ? true : false);
    }


    public function put()
    {
        $pdo = $this->returnConnection();
        $update = $pdo->prepare("UPDATE `$this->table` SET `nome`=:nome,`valor`=:valor,`categoria`=:categoria,`tipo`=:tipo,`criado`=:criado ,`editado`=:editado WHERE `id`=:id");
        $update->bindParam(':id', $this->id);
        $update->bindParam(':nome', $this->nome);
        $update->bindParam(':valor', $this->valor);
        $update->bindParam(':categoria', $this->categoria);
        $update->bindParam(':tipo', $this->tipo);
        $update->bindParam(':editado', $this->editado);
        $update->bindParam(':criado', $this->criado);
        return ($update->execute() ? true : false);
    }

    public function pay()
    {
        $pdo = $this->returnConnection();
        $pay = $pdo->prepare("UPDATE `$this->table` SET `pago`=:pago WHERE `id`=:id");
        $pay->bindParam(':id', $this->id);
        $pay->bindParam(':pago', $this->pago);
        return ($pay->execute() ? true : false);
    }

    public function destroy()
    {
        $pdo = $this->returnConnection();
        $destroy = $pdo->prepare("DELETE FROM `$this->table` WHERE id=:id");
        $destroy->bindParam(':id', $this->id);
        return ($destroy->execute() ? true : false);
    }
}
