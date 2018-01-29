<?php
namespace SON\Database;

/**
 * Classe responsável pela abstração da tabela
 * no banco de dados.
 *
 */
class Model extends Connection
{
  use Convenience;

  /**
   * Nome da chave primária da tabela
   *
   * @var string
   */
  protected $primaryKey;


  /**
   * Nome da tabela
   *
   * @var string
   */
  protected $table;


  /**
   * Query a ser executada
   * 
   * @var string
   */
  protected $statement;


  /**
   * Setter do atributo $primaryKey
   *
   * @param string $primaryKey [Chave Primária]
   */
  public function setPrimaryKey($primaryKey)
  {
    $this->primaryKey = $primaryKey;
  }


  /**
   * Setter do atributo $table
   *
   * @param string $table [Nome da Tabela]
   */
  public function setTable($table)
  {
    $this->table = $table;
  }
}
