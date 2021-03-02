<?php
ini_set('display_errors',true);
error_reporting(E_ALL);
require __DIR__.'/vendor/autoload.php';

use \App\Entity\Vaga;

$vagas = Vaga::getVagas();

// echo "<pre>"; print_r($vagas); echo "</pre>"; exit;

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/listagem-produtos.php';
// include __DIR__.'/includes/listagem.php';
include __DIR__.'/includes/footer.php';