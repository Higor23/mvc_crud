<?php

$resultados = '';
foreach ($vagas as $vaga) {
    $resultados .=
        '<div class="col">
        <div class="card">
        <img src="files/<?php echo $vaga->imagem;?>" alt="">
        <img src="files/'.$vaga->imagem.'" alt="">
            
            
            <div class="card-body ">
                <h6 class="card-text";><strong> ' . $vaga->nome . '<strong> </h6>
                <h6 class="card-text">Descrição ' . $vaga->descricao . '</h6>
                <h6 class="card-text" id="titulo-ativo">Preço:' . $vaga->preco . '</h6>
                <button class="btn btn-success btn-comprar">Comprar</button>
            </div>
        </div>
    </div>';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                        <td colspan="6" class="text-center">
                                                        Nenhuma vaga encontrada
                                                        </td>
                                                        </tr>';

?>

<img src="" alt="">
<div class='container'>

    <div class="row row-cols-1 row-cols-md-5 g-2">
        <?= $resultados ?>

    </div>