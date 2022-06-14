<?php

namespace Mvc\Model;

use PDO;

class BaseModel
{
    private $pdo;
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=db;dbname=dbusuarios", "root", "123");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\Throwable $th) {
            echo "Falha ao se conecetar com o banco de dados" . $th->getMessage();
        }
    }

    public function returnConnection()
    {
        return $this->pdo;
    }
}
