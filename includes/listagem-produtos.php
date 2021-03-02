<?php

$resultados = '';
foreach ($produtos as $produto) {
    $resultados .=
        '<div class="col">
        <div class="card">
        <div class="div-image-card" >
        <img class="img-responsive image" src="files/'.$produto->imagem.'" alt="">
        </div>
            
            <div class="card-body ">
                <h6 class="card-text";><strong> ' . $produto->nome . '<strong> </h6>
                <h6 class="card-text">Descrição ' . $produto->descricao . '</h6>
                <h6 class="card-text" id="titulo-ativo">Preço:' . $produto->preco . '</h6>
                <div class="div-image-card" >
                <button class="btn btn-success btn-comprar">Comprar</button>
                </div>
            </div>
        </div>
    </div>';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                        <td colspan="6" class="text-center">
                                                        Nenhum produto encontrado
                                                        </td>
                                                        </tr>';

?>

<div class='container'>

    <div class="row row-cols-1 row-cols-md-4 g-2">
        <?= $resultados ?>

    </div>