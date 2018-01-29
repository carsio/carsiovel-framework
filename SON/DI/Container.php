<?php 

namespace SON\DI;

use App\Init;


class Container 
{
	public static function getClass($name)
	{
		$str_class = "App\\Model\\".ucfirst($name);
		$conn = Init::getDb();
		$model =  new $str_class($conn);

		return $model;
	}
}
