<?php

require __DIR__ . '/vendor/autoload.php';

define('TITLE', 'Editar Produto');

use \App\Entity\Produto;
use \App\Entity\Upload;

if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: index.php?status=error');
    exit;
}

$obProduto = Produto::getProduto($_GET['id']);

//VALIDAÇÃO DA PRODUTO
if (!$obProduto instanceof Produto) {
    header('location: index.php?status=error');
    // exit
}


//Validação do POST
if (isset($_POST['nome'], $_POST['descricao'], $_POST['status'], $_POST['preco'])) {

    //DADOS
    $obProduto->nome    = $_POST['nome'];
    $obProduto->descricao  = $_POST['descricao'];
    $obProduto->preco  = $_POST['preco'];
    $obProduto->status     = $_POST['status'];
    $obProduto->imagem    = '';

    if (isset($_FILES['imagem'])) {

        $obUpload = new Upload($_FILES['imagem']);
    } else {
        $obUpload = '';
    }

    //ALTERA O NOME DO ARQUIVO
    $obUpload->generateNewName();

    //MOVE OS ARQUIVOS DE UPLOAD
    $sucesso = $obUpload->upload(__DIR__ . '/files', false);
    $obProduto->imagem    = $obUpload->name;

    $obProduto->atualizar();
    header('location: index.php?status=success');
    exit();

    die('Problema ao enviar o arquivo');
}

include __DIR__ . '/views/header.php';
include __DIR__ . '/views/formulario.php';
include __DIR__ . '/views/footer.php';
