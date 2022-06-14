<?php

namespace Mvc\Model;


class TipoModel extends BaseModel
{
    private $id;
    private $tipo;
    private $table = "tipo";

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function setTipo(string $tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function list()
    {
        $pdo = $this->returnConnection();
        $where = $this->id ? ' where id=' . $this->id : '';
        $list =  $pdo->prepare("select * from " . $this->table . $where);

        return ($list->execute() ? $list : false);
    }
}
