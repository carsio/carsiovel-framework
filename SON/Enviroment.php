<?php
namespace SON;

/**
* The Enviroment Class
*/
class Enviroment
{
  private $enviroment;

  public function __construct()
  {
    $this->setEnviroment();
  }

  public function env($atribute)
  {
    return isset($this->enviroment[$atribute]) ? $this->enviroment[$atribute] : "" ;
    // return trim();preg_replace('/\s+/', '', $string);
  }

  public function getEnv()
  {
    return $this->enviroment;
  }

  public function setEnviroment()
  {
    $string = file_get_contents("../.env");
    preg_match_all("/.*[A-Z\_]+\=\S*/", $string, $matches);
    foreach ($matches[0] as $match) {
        $aux = explode("=", $match);
        if (! preg_match("/\S*#\S*/", $aux[0])) {
        $env[trim($aux[0])] = trim($aux[1]);
      }
    }
    $this->enviroment = $env;
  }
}
