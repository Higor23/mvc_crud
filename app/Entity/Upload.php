<?php

namespace App\Entity;

class Upload {
        /**
     * Nome do arquivo sem extensão
     * @var string
     */
    public $name;

    /**
     * Extensão do arquivo (sem ponto)
     * @var string
     */
    public $extension;

    /**
     * Tipo do arquivo
     * @@var string
     */
    public $type;

    /**
     * Nome temporário/caminho do arquivo
     * @var string
     */
    public $tmpName;

    /**
     * Código de erro do upload
     * @@var integer
     */
    public $error;

    /**
     * Tamanho do arquivo
     * @@var string
     */
    public $size;


    /**
     * Conatdor de duplicação de arquivo
     * @@var integer
     */
    public $duplicates = 0;

    /**
     * Método responsável por cadastrar o produto
     * @return boolean
     */
    public function __construct($file = null, $descricao = null, $nome = null, $preco = null, $status = null)
    {
        if(is_array($file)){
        $this->type = $file['type'];
        $this->tmpName = $file['tmp_name'];
        $this->error = $file['error'];
        $this->size = $file['size'];

        $info = pathinfo($file['name']);
        $this->name = $info['filename'];
        $this->extension = $info['extension'];
        }
    }

    public function generateNewName() {
        $this->name = time().'-'.rand(100000,999999).'-'.uniqid().'.'.$this->extension;
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
        return $this->name . $duplicates;
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
}