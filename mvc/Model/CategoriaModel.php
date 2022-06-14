<?php

namespace Mvc\Model;


class CategoriaModel extends BaseModel
{
    private $id;
    private $title;
    private $slug;
    protected $table = 'categorias';

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
        $create = $pdo->prepare("INSERT INTO `$this->table`( `titulo`, `slug`) VALUES (:title,:slug)");
        $create->bindParam(':title', $this->title);
        $create->bindParam(':slug', $this->slug);

        return ($create->execute() ? true : false);
    }


    public function put()
    {
        $pdo = $this->returnConnection();
        $update = $pdo->prepare("UPDATE `$this->table` SET `titulo`=:title,`slug`=:slug WHERE `id`=:id");
        $update->bindParam(':id', $this->id);
        $update->bindParam(':title', $this->title);
        $update->bindParam(':slug', $this->slug);

        return ($update->execute() ? true : false);
    }

    public function destroy()
    {
        $pdo = $this->returnConnection();
        $destroy = $pdo->prepare("DELETE FROM `$this->table` WHERE id=:id");
        $destroy->bindParam(':id', $this->id);
        return ($destroy->execute() ? true : false);
    }
}
