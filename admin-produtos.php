<?php

require __DIR__.'/vendor/autoload.php';

use \App\Entity\Produto;

$produtos = Produto::getProdutos();

include __DIR__.'/views/header.php';
include __DIR__.'/views/listagem.php';
include __DIR__.'/views/footer.php';