<?php

use Mvc\Controller\CategoriaController;

$CategoriaController = new CategoriaController;
$categorias = $CategoriaController->index(null);
$categorias = json_decode($categorias);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de categorias</title>
    <link rel="stylesheet" href="/mvc/View/assets/css/style.css">
</head>

<body>
    <header class="teste">
        <h1>Sistema finaceiro com php puro</h1>
    </header>
    <div class="app">
        <div class="configs">
            <div class="configs-header-flex" style="margin-top:10px ;">
                <span>
                    <a href="/form/categorias?acao=cadastrar">Cadastrar categoria</a>
                </span>
                <span>
                    <a href="/">Voltar</a>
                </span>
            </div>
        </div>
        <table border="1" class="tabela-categorias">
            <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Slug</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria) : ?>
                    <tr>
                        <form method="POST" action="/api/categorias?method=PUT&id=<?php echo $categoria->id ?>" class="form-tabela">
                            <td><input name="title" class="input-tabela" value="<?php echo $categoria->titulo ?>" /></td>
                            <td><input name="slug" class="input-tabela" value="<?php echo $categoria->slug ?>" /></td>
                            <td>
                                <button class="button-tabela">Editar</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

</body>

</html>