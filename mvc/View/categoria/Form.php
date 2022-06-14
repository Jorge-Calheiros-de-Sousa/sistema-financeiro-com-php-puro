<?php

use Mvc\Controller\CategoriaController;

$acao = $_GET["acao"];
$id = $_GET["id"];
$CategoriaController = new CategoriaController;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoria</title>
    <link rel="stylesheet" href="/mvc/View/assets/css/style.css">
</head>

<body>
    <header class="teste">
        <h1>Sistema finaceiro com php puro</h1>
    </header>
    <div class="app">
        <?php if ($acao == "cadastrar") : ?>
            <h1>Cadastrar</h1>
            <form action="/api/categorias?method=POST" method="POST" class="form-categoria">
                <div class="grupo-input-categoria">
                    <input name="title" placeholder="Digite o titulo da categoria..." />
                </div>
                <div class="grupo-input-categoria">
                    <input name="slug" placeholder="Digite o slug..." />
                </div>
                <div class="container-button">
                    <button>Cadastrar</button>
                    <a href="/categorias">Cancelar</a>
                </div>
            </form>
        <?php elseif ($acao == "alterar" && isset($id)) : ?>
            <?php
            $list = $CategoriaController->index($id);
            $path = "/api/categorias?method=PUT&id=$id";
            $obj = json_decode($list);

            foreach ($obj as $e) : ?>
                <h1>Alterar</h1>
                <form action="<?php echo $path ?>" method="POST" class="form-categoria">
                    <div class="grupo-input-categoria">
                        <input name="title" placeholder="Digite o titulo da categoria..." value="<?php echo $e->titulo ?>" />
                    </div>
                    <div class="grupo-input-categoria">
                        <input name="slug" placeholder="Digite o slug..." value="<?php echo $e->slug ?>" />
                    </div>
                    <div class="container-button">
                        <button>Cadastrar</button>
                        <a href="/categorias">Cancelar</a>
                    </div>
                </form>
            <?php endforeach; ?>
        <?php else : ?>
            <h2>Não encontrado</h2>
        <?php endif; ?>
    </div>
</body>

</html>