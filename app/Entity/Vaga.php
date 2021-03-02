<?php

namespace App\Entity;

use App\Db\Database;
use \PDO;

class Vaga
{
    /**
     * Identificador único do produto
     * @var integer
     */
    private $id;

    /**
     * Nome do Produto
     * @var string
     */
    private $nome;

    /**
     * Descrição do produto
     * @var string
     */
    private $descricao;

    /**
     * Preço do produto
     * @var double
     */
    private $preco;

    /**
     * Define se o produto está ativo
     * @var string(s/n) 
     */
    private $status;

    /** 
     * Data de publicação do produto
     * @var string
     */
    private $data;

    /**
     * Nome do arquivo sem extensão
     * @@var string
     */
    private $name;

    /**
     * Extensão do arquivo (sem ponto)
     * @var string
     */
    private $extension;

    /**
     * Tipo do arquivo
     * @@var string
     */
    private $type;

    /**
     * Nome temporário/caminho do arquivo
     * @var string
     */
    private $tmpName;

    /**
     * Código de erro do upload
     * @@var integer
     */
    private $error;

    /**
     * Tamanho do arquivo
     * @@var string
     */
    private $size;


    /**
     * Conatdor de duplicação de arquivo
     * @@var integer
     */
    private $duplicates = 0;

    /**
     * Método responsável por cadastrar o produto
     * @return boolean
     */
    public function __construct($file, $descricao, $nome, $preco, $status)
    {
        $this->type = $file['type'];
        $this->tmpName = $file['tmp_name'];
        $this->error = $file['error'];
        $this->size = $file['size'];

        $info = pathinfo($file['name']);
        $this->name = $info['filename'];
        $this->extension = $info['extension'];

        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->status = $status;
    }

    public function generateNewName() {
        $this->name = time().'-'.rand(100000,999999).'-'.uniqid();
    }


    /**
     * Método responsável por alterar o nome possível para o arquivo
     * @param string $name
     * @param boolean $overwrite
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Método responsável por obter o nome possível para o arquivo
     * @param string $dir
     * @param boolean $overwrite
     * @return boolean
     */
    private function getPossibleBasename($dir, $overwrite)
    {
        //SOBRESCREVER ARQUIVO
        if ($overwrite) return $this->getBaseName();

        //NÃO PODE SOBRESCERVER
        $basename = $this->getBasename();

        //VERIFICAR DUPLICAÇÃO
        if (!file_exists($dir . '/' . $basename)) {
            return $basename;
        }

        //INCREMENTAR DUPLICAÇÕES
        $this->duplicates++;

        //RETORNO O PRÓPRIO MÉTODO
        return $this->getPossibleBasename($dir, $overwrite);
    }

    /**
     * Método responsável por retornar o arquivo com sua extensão
     * @param string $dir
     * @return string
     */
    public function getBaseName()
    {
        //VALIDA EXTENSÃO 
        $extension = strlen($this->extension) ? '.' . $this->extension : '';

        //VALIDA DUPLICAÇÃO
        $duplicates = $this->duplicates > 0 ? '-' . $this->duplicates : '';

        //RETORNA O NOME COMPLETO
        return $this->name . $duplicates . $extension;
    }

    /**
     * Método responsável por mover o arquivo de upload
     * @param string $dir
     * @param boolean $overwrite
     * @return boolean
     */
    public function upload($dir, $overwrite = true)
    {
        if ($this->error != 0) return false;

        //CAMINHO COMPLETO DE DESTINO
        $path = $dir . '/' . $this->getPossibleBasename($dir, $overwrite);
        // echo "<pre>"; print_r($path); echo "</pre>"; exit;

        //MOVE O ARQUIVO PARA A PASTA DE DESTINO
        return move_uploaded_file($this->tmpName, $path);
    }

    public function cadastrar()
    {

        // DEFINIR A DATA
        $this->data = date('Y-m-d H:i:s');

        // INSERIR A PRODUTO NO BANCO
        $obDatabase = new Database('produtos');
        $this->id = $obDatabase->insert([
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'preco' => $this->preco,
            'status' => $this->status,
            'data' => $this->data,
            'imagem' => $this->name
        ]);
        // echo "<pre>"; print_r($this); echo "</pre>"; exit;

        return true;
    }


    /**
     * Método responsável por atualizar o produto no banco
     * @return bollean
     */
    public function atualizar()
    {
        return (new Database('produtos'))->update('id = ' . $this->id, [
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'preco' => $this->preco,
            'status' => $this->status,
            'data' => $this->data
        ]);
    }

    /**
     * Método responsável por excluir a vaga do banco
     * @return bollean
     * 
     */
    public function excluir()
    {

        return (new Database('produtos'))->delete('id = ' . $this->id);
    }


    /**
     * O método é static porque vai retornar várias intâncias de vagas, 
     * mas no momento da consulta, necessita somente do response.
     * 
     * Método para listagem de vagas
     * @param string $where
     * @param $order
     * @param $limit
     * @return array
     */
    public static function getVagas($where = null, $order = null, $limit = null)
    {
        return (new Database('produtos'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * O método é static porque vai retornar várias intâncias de vagas, 
     * mas no momento da consulta, necessita somente do response.
     * 
     * Método responsável por buscar uma vaga com base em seu id
     * @param integer $id
     * @return Vaga
     */
    public static function getVaga($id)
    {
        return (new Database('produtos'))->select('id = ' . $id)->fetchObject(self::class);
    }
}
