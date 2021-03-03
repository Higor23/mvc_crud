<?php
ini_set('display_errors',true);
error_reporting(E_ALL);
require __DIR__.'/vendor/autoload.php';

use \App\Entity\Produto;

$produtos = Produto::getProdutos();

// echo "<pre>"; print_r($vagas); echo "</pre>"; exit;

include __DIR__.'/views/header.php';
include __DIR__.'/views/listagem-produtos.php';
include __DIR__.'/views/footer.php';