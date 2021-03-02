<?php

require __DIR__ . '/vendor/autoload.php';

define('TITLE', 'Cadastrar vaga');

use \App\Entity\Vaga;

$obVaga = new Vaga;

//Validação do POST
// if (isset($_POST['nome'], $_POST['descricao'], $_POST['status'], $_POST['preco'], $_FILES['imagem'])) {
if (isset($_POST['nome'], $_POST['descricao'], $_POST['status'], $_POST['preco'])) {
    // if (isset($_FILES['imagem'])) {
    // echo "<pre>"; print_r($_FILES); echo "</pre>"; exit;
    

    //DADOS
    $obVaga->nome    = $_POST['nome'];
    $obVaga->descricao  = $_POST['descricao'];
    $obVaga->preco  = $_POST['preco'];
    $obVaga->status     = $_POST['status'];
    // echo "<pre>"; print_r($obVaga); echo "</pre>"; exit;
    $obVaga->cadastrar();

    header('location: index.php?status=success');
    exit();
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/formulario.php';
include __DIR__ . '/includes/footer.php';
