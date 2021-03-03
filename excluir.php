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
    echo '<script type="text/javascript"> alert("Erro ao excluir produto."); self.location.href="index.php";</script>';
    // header('location: index.php?status=error');
    // exit
}


//VALIDAÇÃO DO POST
if (isset($_POST['excluir'])) {

    $obProduto->excluir();
    echo '<script type="text/javascript"> alert("Produto excluído com sucesso"); self.location.href="index.php";</script>';
    // header('location: index.php?status=success');
    
    // exit();
 
}

include __DIR__ . '/views/header.php';
include __DIR__ . '/views/confirmar-exclusao.php';
include __DIR__ . '/views/footer.php';
