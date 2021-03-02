<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Entity\Produto;

if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
    header('location: index.php?status=error');
    exit;
}

$obProduto = Produto::getProduto($_GET['id']);

//VALIDAÇÃO DA PRODUTO
if(!$obProduto instanceof Produto){
    header('location: index.php?status=error');
    // exit
}


//VALIDAÇÃO DO POST
if (isset($_POST['excluir'])) {

    $obProduto->excluir();
    
    header('location: index.php?status=success');
    exit();
 
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/confirmar-exclusao.php';
include __DIR__ . '/includes/footer.php';
