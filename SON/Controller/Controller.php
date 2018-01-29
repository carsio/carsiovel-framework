<?php

namespace SON\Controller;

/**
 *
 */
abstract class Controller
{
  public static function response($action)
  {

    if (@get_class($action) == "SON\\Controller\\Action") {
      $action->play();
      exit;
    }

    if ( is_array($action) ) {
      header('Content-type: application/json');
      echo  json_encode($action);
      exit;
    }  

    if ( is_string($action) ) {
      echo  $action;
      exit;
    }

  }
}
