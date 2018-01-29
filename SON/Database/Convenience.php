<?php

namespace SON\Database;

use PDO;

/**
 * Trait que contém os métodos que abstraem alguns comandos em SQL
 *
 */
trait Convenience
{
  /**
   * Retorna um array com todos os campos de um registro
   * a partir da primary key
   *
   * @param  int $id [Valor da Primary Key (Mais conhecido como id)]
   * @param  string $fields [Campos que serão trazidos (Default = "*")]
   * @return array     [Array com todos os campos do registro ou campos = ]
   */
  public function find($id, $fields = "*")
  {
    $this->statement = "SELECT $fields FROM $this->table WHERE $this->primaryKey = $id";
    $result = $this->run();

    return isset($result[0]) ? $result[0] : "ERRO: Nenhum registro encontrado" ;
  }


  /**
   * Retorna todos os dados de uma tabela
   *
   * @param  string $fields [Campos que serão trazidos]
   * @return array         [Retorna resultado da consulta]
   */
  public function all($fields = "*")
  {
    $this->statement = "SELECT $fields FROM $this->table";
    return $this->run();
  }


  /**
   * Inica a montagem da string da SELECT a ser executada
   *
   * @param  string $fields [Campos que serão trazidos]
   * @return this         [Retorna o Próprio Objeto]
   */
  public function select($fields = "*")
  {
    $this->statement = "SELECT $fields FROM $this->table ";

    return $this;
  }


  /**
   * Finaliza a montagem da string da SELECT a ser executada
   * adicionando a cláusula WHERE
   *
   * @param  string|array $fetch    [Campos que serão utilizado na cláusula WHERE]
   * @param  boolean $value    [description]
   * @param  string  $operator [description]
   * @return [type]            [description]
   */
  public function where($fetch, $value = false, $operator="=")
  {
    if ( !is_array($fetch) && $value) {
      $this->statement .= "WHERE $fetch $operator '$value'";
    } else{
      // TODO: Select com varios parametros
    }

    return $this->run();
  }


  /**
   * Insere um registro na tabela
   *
   * @param  array  $record [Array como os dados que serão inseridos]
   * @return [type]         [description]
   */
  public function insert(array $record)
  {
    $columns = "(";
    $values = "(";

    $i = 0;
    $len = count($record) - 1;

    foreach ($record  as $key => $value) {
      if ($i < $len) {
        $columns.= "$key ,";
        $values .= "'$value' ,";
      }else{
        $columns.= "$key)";
        $values .= "'$value')";
      }
      $i++;
    }

    $this->statement = "INSERT INTO $this->table $columns VALUES $values";
    $this->run();
  }

  /**
   * Deleta registro do Banco de dados a partir da Primary Key
   *
   * @param  int $id [Valor da Primary Key do registro a ser deletado]
   */
  public function delete($id)
  {
    $this->statement = "DELETE FROM $this->table WHERE $this->primaryKey = $id";
    $this->run();
  }

  /**
   * Executa uma Query SQL
   *
   * @param  string $statement [Query a ser executada]
   * @return array            [Resultado da query caso haja retorno]
   */
  public function execute($statement)
  {
    $this->statement = $statement;
    return $this->run();
  }


  /**
   * Método auxíliar reponsável pela execução da query
   *
   * @return array [Resultado da query caso haja retorno]
   */
  public function run()
  {
    // echo $this->driver;
    // exit;

    if ($this->driver == 'PDO') {
      $stmt = $this->conn->prepare($this->statement);
      $stmt->execute();
      $fetch = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();

      return $result;

    } elseif ($this->driver == 'MYSQLI') {
      $arResult = [];
      $result = @mysqli_query($this->conn, $this->statement);

      if (@mysqli_num_rows($result) > 0) {
        // output data of each row
        while( $row = mysqli_fetch_assoc($result) ) {
          array_push($arResult, $row);
        }
      }

      // @mysqli_close($this->conn);
      return $arResult;
    }

  }
}
