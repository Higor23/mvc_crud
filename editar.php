<?php

require __DIR__ . '/vendor/autoload.php';

define('TITLE', 'Editar Produto');

use \App\Entity\Vaga;
use \App\Entity\Upload;

if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
    header('location: index.php?status=error');
    exit;
}

$obVaga = Vaga::getVaga($_GET['id']);

//VALIDAÇÃO DA VAGA
if(!$obVaga instanceof Vaga){
    header('location: index.php?status=error');
    // exit
}


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
    $obUpload->generateNewName();

    //MOVE OS ARQUIVOS DE UPLOAD
    $sucesso = $obUpload->upload(__DIR__ . '/files', false);
    $obVaga->imagem    = $obUpload->name;
 
    if ($sucesso) {
        $obVaga->atualizar();
        header('location: index.php?status=success');
        exit();
    }

    die('Problema ao enviar o arquivo');

}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/formulario.php';
include __DIR__ . '/includes/footer.php';
