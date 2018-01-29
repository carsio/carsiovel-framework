<?php
namespace SON\View;

/**
 * Classe que auxilia na montagem da view
 */
abstract class Layout
{

  protected $view;
  private $path;
  protected $data;
  protected $layoutData;
  private $layout;


  function __construct()
  {
    $this->data = new \stdClass();
    $this->layoutData = new \stdClass();
  }

  public function set($name, $value)
  {
    $this->layoutData->data[$name] = $value;
  }

  public function get($name)
  {
    echo $this->layoutData->data[$name];
    return $this->layoutData->data[$name];
  }

  public function section($name, $isOptinal=false)
  {
    if (isset($this->data->scope) ) {
      foreach ($this->data->scope as $key => $value) {
        $$key = $value;
      }
    }

    if (!$isOptinal) {
      eval(' ?>'.$this->layoutData->section[$name].'<?php ');
    }else{
      @eval(' ?>'.$this->layoutData->section[$name].'<?php ');
    }

  }

  public function setLayout($layout)
  {
    $layout = str_replace(".", "/", $layout);
    $this->layout=$layout;
  }

  public function getLayout()
  {
    return $this->layout;
  }

}
