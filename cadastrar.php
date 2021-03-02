<?php

require __DIR__ . '/vendor/autoload.php';

define('TITLE', 'Cadastrar Produto');

use \App\Entity\Vaga;

// $obVaga = new Vaga;

//Validação do POST
if (isset($_POST['nome'], $_POST['descricao'], $_POST['status'], $_POST['preco'], $_FILES['imagem'])) {

    //INSTÂNCIA DE UPLOAD E CADASTRO
    $obVaga = new Vaga($_FILES['imagem'], $_POST['descricao'], $_POST['nome'], $_POST['preco'], $_POST['status']);

    //ALTERA O NOME DO ARQUIVO
    // $obVaga->setName('novo-arquivo-com-nome-alterado');

    $obVaga->generateNewName();

    //MOVE OS ARQUIVOS DE UPLOAD
    $sucesso = $obVaga->upload(__DIR__ . '/files', false);
    // echo "<pre>"; print_r($obVaga); echo "</pre>"; exit;
    if ($sucesso) {
        // echo 'Arquivo '.$obVaga->getBasename().' enviado com sucesso!';
        $obVaga->cadastrar();
        header('location: index.php?status=success');
        exit();
    }

    die('Problema ao enviar o arquivo');
    //DADOS
    // $obVaga->nome    = $_POST['nome'];
    // $obVaga->descricao  = $_POST['descricao'];
    // $obVaga->preco  = $_POST['preco'];
    // $obVaga->status     = $_POST['status'];
    // $obVaga->imagem    = $_FILES['imagem']['name'];
    // echo "<pre>"; print_r($obVaga); echo "</pre>"; exit;

}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/formulario.php';
include __DIR__ . '/includes/footer.php';
