<?php

namespace SON\Database;

/**
 * Trait que contém o Construtor reponsável pela passagem
 * de Metadados para classe SON\Database\Model
 *
 */
trait Metadata
{
  /**
   * Construtor responsável por settar os metadados
   * para a Super Classe
   *
   */
  public function __construct()
  {
    parent::__construct();

    isset($this->primaryKey) ? : $this->setPrimaryKey('ID') ;
    isset($this->table) ? : $this->setTable($this->defaultTable()) ;

  }

  /**
   * Método auxíliar que retona o nome da classe que será usado
   * como nome da Tabela caso não esteja setado o atributo $table
   *
   * @return string [Nome default da tabela]
   */
  public function defaultTable()
  {
    $table = str_replace("App\\Model\\", "", get_class($this));
    $table = strtoupper($table);

    return $table;
  }

}
