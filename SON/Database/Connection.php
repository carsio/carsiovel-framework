<?php
namespace SON\Database;

use SON\Enviroment;
use PDO;

/**
 * Classe responsável por iniciar conexão com o
 * banco de dados
 */
class Connection extends Enviroment
{

  /**
   * [Instância de PDO que recebe uma conexão]
   * @var [PDO]
   */
  protected $conn;


  /**
   * Driver para conexão com mysql
   *
   * @var string
   */
  protected $driver;

  /**
   * Contrutor chama contrutor da Super classe
   * para ter acesso as variávies de ambiente
   * definidas no arquivo .env
   */
  public function __construct()
  {
    parent::__construct();
    $this->driver = strtoupper($this->env('DB_DRIVER_MYSQL'));
    $this->tryConnect();
  }

  /**
   * Método para conectar com o Banco de Dados
   */
  public function tryConnect()
  {
    if ($this->driver == 'PDO') {
      $this->pdo();
    }elseif ($this->driver == 'MYSQLI') {
      $this->mysqli();
    }
  }


  /**
   * Conecta-se ao banco usando PDO
   *
   */
  public function pdo()
  {
    $dsn = sprintf("mysql:dbname=%s;host=%s;charset=utf8", $this->env('DB_DATABASE'), $this->env('DB_HOST'));
    $user = $this->env('DB_USERNAME');
    $password = $this->env('DB_PASSWORD');

    try {
      $this->conn = new PDO($dsn, $user, $password);
      // $this->exec("set names utf8");
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
  }


  /**
   * Conecta-se ao banco usando Mysqli
   *
   */
  public function mysqli()
  {
    $this->conn = mysqli_connect($this->env('DB_HOST'), $this->env('DB_USERNAME'), $this->env('DB_PASSWORD'));
    $tabela =  mysqli_select_db($this->conn,  $this->env('DB_DATABASE'));
    mysqli_set_charset($this->conn,'utf8');

    if (!$this->conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // echo "Connected successfully";

  }

}
