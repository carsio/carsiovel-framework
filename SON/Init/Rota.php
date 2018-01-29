<?php
namespace SON\Init;

/**
 * Classe para auxilio de criação de rotas
 *
 */
abstract class Rota
{
  /**
   * Array com todas as rotas definidas em routes/web.php
   *
   * @var array
   */
  public static $rotas = [];


  /**
   * Faz o que precisa ser feito
   *
   * @param  string $url           [String que define a URL]
   * @param  string $stringControl [String que define Controller e a Action]
   */
  public static function get($url, $stringControl)
  {

    $middle = null;

    if (isset($GLOBALS['middle'])) {
      $middle = $GLOBALS['middle'];
    }

    $aux = explode("@", $stringControl);
    $controller = $aux[0];
    $action = $aux[1];

    // $rota = array('route' => $url, 'controller' => $controller, 'action' => $action, 'method' => 'GET');

    $rota = [
              'route'       => $url,
              'controller'  => $controller,
              'action'      => $action,
              'method'      => 'GET',
              'middle'      => $middle
            ];

    array_push(self::$rotas, $rota);
  }


  /**
   * Faz o que precisa ser feito
   *
   * @param  string $url           [String que define a URL]
   * @param  string $stringControl [String que define Controller e a Action]
   */
  public static function post($url, $stringControl)
  {
    $middle = null;

    if (isset($GLOBALS['middle'])) {
      $middle = $GLOBALS['middle'];
    }

    $aux = explode("@", $stringControl);
    $controller = $aux[0];
    $action = $aux[1];

    // $rota = array('route' => $url, 'controller' => $controller, 'action' => $action, 'method' => 'POST');

    $rota = [
              'route'       => $url,
              'controller'  => $controller,
              'action'      => $action,
              'method'      => 'POST',
              'middle'      => $middle
            ];

    array_push(self::$rotas, $rota);
  }


  public function group(array $middle, $function)
  {
    $GLOBALS['middle'] = $middle;

    if (is_callable($function)) {
      $function();
    }

    unset($GLOBALS['middle']);

  }

  /**
   * Retorna todas as rotas
   *
   * @return array Todas as rotas
   */
  public static function dumpRotas()
  {
    return self::$rotas;
  }
}
