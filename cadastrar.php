<?php
// ini_set('display_errors',true);
// error_reporting(E_ALL);
require __DIR__ . '/vendor/autoload.php';

define('TITLE', 'Cadastrar Produto');

use \App\Entity\Vaga;
use \App\Entity\Upload;

//INSTÂNCIA DO PRODUTO
$obVaga = new Vaga;


//Validação do POST
if (isset($_POST['nome'], $_POST['descricao'], $_POST['status'], $_POST['preco'])) {

    //INSTÂNCIA DE UPLOAD E CADASTRO
    // $obVaga = new Vaga();

    //DADOS
    $obVaga->nome    = $_POST['nome'];
    $obVaga->descricao  = $_POST['descricao'];
    $obVaga->preco  = $_POST['preco'];
    $obVaga->status     = $_POST['status'];
    $obVaga->imagem    = '';

    if (isset($_FILES['imagem'])) {

        $obUpload = new Upload($_FILES['imagem']);
    
    }

    //ALTERA O NOME DO ARQUIVO
    // $obVaga->setName('novo-arquivo-com-nome-alterado');

    $obUpload->generateNewName();

    //MOVE OS ARQUIVOS DE UPLOAD
    $sucesso = $obUpload->upload(__DIR__ . '/files', false);
    $obVaga->imagem    = $obUpload->name;
    // echo "<pre>";
    // print_r($obVaga);
    // echo "</pre>";
    // exit;
    if ($sucesso) {
        $obVaga->cadastrar();
        header('location: index.php?status=success');
        exit();
    }

    die('Problema ao enviar o arquivo');

}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/formulario.php';
include __DIR__ . '/includes/footer.php';
