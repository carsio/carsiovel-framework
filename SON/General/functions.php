<?php

use SON\Enviroment;

if (! function_exists('render') ) {
  /**
   * [render description]
   * @param  [type]  $view [description]
   * @param  boolean $path [description]
   * @return [type]        [description]
   */
  function render($view, $path=false)
  {
    $action = new \SON\Controller\Action();
    return $action->render($view, $path=false);
  }
}


if (! function_exists('env') ) {
  /**
   * [render description]
   * @param  [type]  $view [description]
   * @param  boolean $path [description]
   * @return [type]        [description]
   */
  function env($name, $defaul="")
  {
    $info = new Enviroment();
    $attr = $info->env($name);
    unset($info);

    return( $attr == "" ) ? $defaul : $attr ;
  }
}
