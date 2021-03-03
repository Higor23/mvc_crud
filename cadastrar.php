<?php
// ini_set('display_errors',true);
// error_reporting(E_ALL);
require __DIR__ . '/vendor/autoload.php';

define('TITLE', 'Cadastrar Produto');

use \App\Entity\Produto;
use \App\Entity\Upload;


        //INSTÂNCIA DO PRODUTO
        $obProduto = new Produto;


        //Validação do POST
        if (isset($_POST['nome'], $_POST['descricao'], $_POST['status'], $_POST['preco'])) {

            //INSTÂNCIA DE UPLOAD E CADASTRO
            //DADOS
            $obProduto->nome    = $_POST['nome'];
            $obProduto->descricao  = $_POST['descricao'];
            $obProduto->preco  = $_POST['preco'];
            $obProduto->status     = $_POST['status'];
            $obProduto->imagem    = '';

            if (isset($_FILES['imagem'])) {

                $obUpload = new Upload($_FILES['imagem']);
            }

            //ALTERA O NOME DO ARQUIVO
            $obUpload->generateNewName();

            //MOVE OS ARQUIVOS DE UPLOAD
            $sucesso = $obUpload->upload(__DIR__ . '/files', false);
            $obProduto->imagem    = $obUpload->name;

            if ($sucesso) {
                $obProduto->cadastrar();
                header('location: index.php?status=success');
                echo "<script>alert('Senha modificada com sucesso!'); </script>";
                // exit();
            }


  
        }
        include __DIR__ . '/views/header.php';
        include __DIR__ . '/views/formulario.php';
        include __DIR__ . '/views/footer.php';