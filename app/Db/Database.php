<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database
{

    /**
     * Host conexão com banco de dados
     * @var string
     */
    const HOST = 'mysql';

    /**
     * Nome do banco de dados
     * @var string
     */
    const NAME = 'mvc_crud';

    /**
     * Usuário do banco de dados
     * @var string
     */
    const USER = 'root';

    /**
     * Senha do banco de dados
     * @var string
     */
    const PASS = 'root';

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
    private $table;

    /**
     * Instância de conexão com o banco de dados
     * @var PDO
     */
    private $connection;

    /**
     * Define a tabela e instancia a conexão;
     * A tabela é opcional
     *@param string $table
     */
    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Método responsável por criar uma conexão com o banco de dados
     */
    public function setConnection()
    {
        try{

            $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
            
            //Serve para garantir que o PDO gere uma exception caso haja algum erro.
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            // echo "<pre>"; print_r($obDatabase); echo "</pre>"; exit

        } catch(PDOException $e){
            die('ERROR: '.$e->getMessage());
        }
    }

    /**
     * Método responsável por executar as queries dentro do banco de dados
     * @param string $query
     * @param array $params
     * return PDOStatement
     */
    public function execute($query, $params = []){
        try{
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;

        }catch(PDOException $e){
            die('ERROR: '.$e->getMessage());
        }
    }

    /**
     * Método rsponsável por inserir dados no banco
     * @param array @values [field => value]
     * @return integer
     */
    public function insert($values){
        //DADOS DA QUERY
        $fields = array_keys($values);

        //Irá verificar quantas posições existem no array e caso não tenha o número esperado, ele criará o restante com ?
        $binds = array_pad([],count($fields), '?');

        //MONTA A QUERY
        $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',', $binds).')';
        
        $this->execute($query,array_values($values));

        //RETORNA O ID INSERIDO
        return $this->connection->lastInsertId();
    }

    /**
    * Método responsável por executar uma consulta no banco
    * @param string $where
    * @param $order
    * @param $limit
    * @param $fields
    * @return PDOStatement
    */
    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        //DADOS DA QUERY - VERIFICAÇÃO DA EXISTÊNCIA OU NÃO DAS VARIÁVEIS
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'WHERE '.$order : '';
        $limit= strlen($limit) ? 'WHERE '.$limit : '';

        //MONTA A QUERY
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where. ' '.$order.' '.$limit;

        //EXECUTA A QUERY
        return $this->execute($query);
    }

    /**
    * Método responsável por executar atualizações no banco
    * @param string $where
    * @param array $values [ field => value]
    * @return bollean
    */
    public function update($where,$values) {
        //DADOS DA QUERY
        $fields = array_keys($values);

        
        // MONTA A QUERY
        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

        //EXECUTAR A QUERY
        $this->execute($query,array_values($values));


        //RETORNA SUCESSO
        return true;
    }

    /**
     * Método responsável por excluir od dados do banco
     */
    public function delete($where){

        //MONTA A QUERY
        $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

        $this->execute($query);

        //RETORNA SUCESSO
        return true;

    }
}
