<?php

use Mvc\Controller\CategoriaController;
use Mvc\Controller\FinancaController;
use Mvc\Controller\TipoController;

function adicionarZero($number)
{
    if ($number < 10) {
        return ('0' . $number);
    }
    return ($number);
}

$ano = $_GET["ano"];
$todosOsAnos = [[
    'ano' => '2022',
], [
    'ano' => '2021',
], [
    'ano' => '2020',
], [
    'ano' => '2019',
]];
$anoAtual = isset($ano) ? $ano : 2022;
$meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
$FinancasController = new FinancaController;
$TipoController = new TipoController;
$CategoriaController = new CategoriaController;

$financas = $FinancasController->index(null);
$financas = json_decode($financas);

$financasDesseAno = array_filter($financas, function ($financa) use ($anoAtual) {
    $dataFinananca = explode("-", $financa->criado);
    return ($dataFinananca[0] == $anoAtual ? true : false);
});

$tipos = $TipoController->index(null);
$tipos = json_decode($tipos);

$categorias = $CategoriaController->index(null);
$categorias = json_decode($categorias);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="mvc/View/assets/css/style.css">
</head>

<body>
    <header class="teste">
        <h1>Sistema finaceiro com php puro</h1>
    </header>
    <div class="app">
        <div class="configs">
            <div class="configs-header">
                <div class="configs-header-flex">
                    <span>
                        <strong>Ano atual: <?php echo $anoAtual ?></strong>
                    </span>
                    <span>
                        <a href="/categorias">Ver categorias</a>
                    </span>
                </div>
            </div>
            <div class="anos">
                <?php foreach ($todosOsAnos as $ano) : ?>
                    <a href="?ano=<?php echo $ano['ano'] ?>" class="ano"><?php echo $ano['ano'] ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="calendario">
            <?php foreach ($meses as $mes) : ?>
                <div class="mes">
                    <div class="titulo-mes">
                        <h3><?php echo $mes ?></h3>
                    </div>
                    <table class="tabela-financa">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th>Categoria</th>
                                <th>Perda/Ganho</th>
                                <th>Ações</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $financasDesseMes = array_filter($financasDesseAno, function ($financa) use ($mes, $meses) {
                                $dataFinananca = explode("-", $financa->criado);
                                $indexMes = array_search($mes, $meses) + 1;
                                return ($dataFinananca[1] == $indexMes ? true : false);
                            });

                            $saldo = 0;
                            $fatura = 0;
                            foreach ($financasDesseMes as $f) {
                                if ($f->tipo == 1) {
                                    $saldo = $saldo + $f->valor;
                                } else {
                                    $fatura = $fatura + $f->valor;
                                }
                            }
                            $sobra = $saldo - $fatura;
                            foreach ($financasDesseMes as $financa) :
                            ?>
                                <?php
                                $categoria = array_map(function ($categoria) {
                                    return ($categoria->titulo);
                                }, json_decode($CategoriaController->index($financa->categoria)))
                                ?>
                                <?php
                                $status = $financa->tipo == 1 ? true : false;
                                $payed = $financa->pago ? true : false;
                                $pathToPay = "/api/financas?method=PAY&pagar=$financa->id";
                                $pathToUpdate = "/api/financas?method=PUT&id=$financa->id";
                                $data = explode("-", $financa->criado);
                                ?>
                                <tr class="<?php echo $status ? 'positive' : 'negative'; ?>">
                                    <form method="POST" action="<?php echo $pathToUpdate ?>">
                                        <td><input class="input-tabela" name="criado" type="date" value="<?php echo $financa->criado ?>" /></td>
                                        <td><input class="input-tabela" name="nome" value="<?php echo $financa->nome ?>" /></td>
                                        <td><input class="input-tabela" name="valor" value="<?php echo $financa->valor ?>" /></td>
                                        <td>
                                            <select name="categoria" class="input-tabela">
                                                <?php foreach ($categorias as $categoria) : ?>
                                                    <?php if ($financa->categoria == $categoria->id) : ?>
                                                        <option selected value="<?php echo $categoria->id ?>"><?php echo $categoria->titulo ?></option>
                                                    <?php else : ?>
                                                        <option value="<?php echo $categoria->id ?>"><?php echo $categoria->titulo ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="tipo" class="input-tabela">
                                                <option value="" hidden selected>Escolha...</option>
                                                <?php foreach ($tipos as $tipo) : ?>
                                                    <?php if ($financa->tipo == $tipo->id) : ?>
                                                        <option selected value="<?php echo $tipo->id ?>"><?php echo $tipo->tipo ?></option>
                                                    <?php else : ?>
                                                        <option value="<?php echo $tipo->id ?>"><?php echo $tipo->tipo ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="container-button-tabela">
                                                <button class="button-tabela">Editar</button>
                                                <a href="/api/financas?method=DELETE&id=<?php echo $financa->id ?>" class="excluir">Excluir</a>
                                            </div>
                                        </td>
                                    </form>
                                    <td>
                                        <form method="POST" action="<?php echo $pathToPay ?>">
                                            <?php if (!$status) : ?>
                                                <?php if ($payed) : ?>
                                                    <div class="pago">
                                                        <p>Pago</p>
                                                    </div>
                                                <?php else : ?>
                                                    <button class="ok">Pagar</button>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="info-table">
                        <div class="saldo">
                            Saldo: <span><?php echo $saldo ?> R$</span>
                        </div>
                        <div class="fatura">
                            Fatura: <span><?php echo $fatura ?> R$</span>
                        </div>
                        <div class="sobra">
                            Sobra: <span><?php echo $sobra ?> R$</span>
                        </div>
                    </div>
                    <div class="info-table">
                        <?php
                        $pathToCreate = "/api/financas?method=POST";
                        ?>
                        <form action="<?php echo $pathToCreate ?>" method="POST">
                            <div class="form-financas">
                                <div class="grupo-input">
                                    <label>Nome: </label>
                                    <input name="nome" maxlength="50" />
                                </div>
                                <div class="grupo-input">
                                    <label>Valor: </label>
                                    <input name="valor" placeholder="0000.00" maxlength="7" />
                                </div>

                                <div class="grupo-input">
                                    <label>Categoria: </label>
                                    <select name="categoria">
                                        <option value="" hidden selected>Escolha...</option>
                                        <?php foreach ($categorias as $categoria) : ?>
                                            <option value="<?php echo $categoria->id ?>"><?php echo $categoria->titulo ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="grupo-input">
                                    <label>Perda/Ganho: </label>
                                    <select name="tipo">
                                        <option value="" hidden selected>Escolha...</option>
                                        <?php foreach ($tipos as $tipo) : ?>
                                            <option value="<?php echo $tipo->id ?>"><?php echo $tipo->tipo ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="grupo-input">
                                    <label>Data: </label>
                                    <input name="criado" type="date" />
                                </div>
                            </div>
                            <div class="form-financas">
                                <button class="button-submit">
                                    Cadastrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>