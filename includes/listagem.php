<?php

    $mensagem = '';

    if(isset($_GET['status'])){
        switch ($_GET['status']){
            case 'success':
                $mensagem = '<div class="alert alert-success">Ação executada com sucesso!</div>';
            break;

            case 'error':
                $mensagem = 'div class="alert alert-danger">Ação não executada.</div>';
            break;
        }
    }

    $resultados = '';
    foreach($produtos as $produto){
        $resultados .= '<tr>
                            <td>'.$produto->id.'</td>
                            <td>'.$produto->nome.'</td>
                            <td>'.$produto->descricao.'</td>
                            <td>'.($produto->status == 's' ? 'Ativo' : 'Inativo').'</td>
                            <td>'.$produto->preco.'</td>
                            <td>'.date('d/m/Y à\s H:i:s', strtotime($produto->data)).'</td>
                            <td>
                                <a href="editar.php?id='.$produto->id.'"><button type="button" class="btn btn-primary">Editar</button></a>
                                
                                <a href="excluir.php?id='.$produto->id.'"><button type="button" class="btn btn-danger">Excluir</button></a>
                            </td>
                        <tr>';
    }

    $resultados = strlen($resultados) ? $resultados : '<tr>
                                                            <td colspan="6" class="text-center">
                                                            Nenhum produto encontrado
                                                            </td>
                                                            </tr>';

?>
<main>
    <?=$mensagem?>
    <section>
        <a href="cadastrar.php">
            <button class="btn btn-success">Novo produto</button>
        </a>
    </section>

    <section>
        <table class="table bg-light mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Preço</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?=$resultados?>
        </tbody>
        </table>
    </section>

</main>