<?php

namespace App\Entity;

use App\Db\Database;
use \PDO;

class Produto
{
    /**
     * Identificador único do produto
     * @var integer
     */
    public $id;

    /**
     * Nome do Produto
     * @var string
     */
    public $nome;

    /**
     * Descrição do produto
     * @var string
     */
    public $descricao;

    /**
     * Preço do produto
     * @var double
     */
    public $preco;

    /**
     * Define se o produto está ativo
     * @var string(s/n) 
     */
    public $status;

    /** 
     * Data de publicação do produto
     * @var string
     */
    public $data;


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
            'imagem' => $this->imagem
        ]);

        return true;
    }


    /**
     * Método responsável por atualizar o produto no banco
     * @return boolean
     */
    public function atualizar()
    {
        return (new Database('produtos'))->update('id = ' . $this->id, [
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'preco' => $this->preco,
            'status' => $this->status,
            'data' => $this->data,
            'imagem' => $this->imagem
        ]);
    }

    /**
     * Método responsável por excluir a produto do banco
     * @return bollean
     * 
     */
    public function excluir()
    {

        return (new Database('produtos'))->delete('id = ' . $this->id);
    }

    /**
     * O método é static porque vai retornar várias intâncias de produtos, 
     * mas no momento da consulta, necessita somente do response.
     * 
     * Método para listagem de produtos
     * @param string $where
     * @param $order
     * @param $limit
     * @return array
     */
    public static function getProdutos($where = null, $order = null, $limit = null)
    {
        return (new Database('produtos'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * O método é static porque vai retornar várias intâncias de produtos, 
     * mas no momento da consulta, necessita somente do response.
     * 
     * Método responsável por buscar uma produto com base em seu id
     * @param integer $id
     * @return produto
     */
    public static function getProduto($id)
    {
        return (new Database('produtos'))->select('id = ' . $id)->fetchObject(self::class);
    }
}
