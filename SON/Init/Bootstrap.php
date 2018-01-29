<?php
namespace SON\Init;

use SON\Controller\Controller;
use SON\Enviroment;

abstract class Bootstrap
{

	private $routes; // recebe $ar da classe Init;

	// Roda quando init é intanciada
	public function __construct()
	{
		require_once dirname( dirname(__FILE__) ) . "/General/functions.php";
		$this->initRoutes();
		$this->run($this->getURL());
	}

	abstract protected function initRoutes();

	protected function run($url)
	{
		$url = str_replace(env('REMOVE_FROM_URL'), "", $url);

		global $isEncontrou;

		$isEncontrou = false;

		foreach ($this->routes as $route) {
			if ($url == $route['route'] && $route['method'] == $_SERVER['REQUEST_METHOD']) { // Compara o URL requisitado com as rotas disponívies
				$class = "App\\Controller\\".ucfirst($route['controller']); // Salva a classe do Controller
				$controller = new $class; // Instancia o Controller
				$action = $route['action']; // Salva a Action do Controller
				// $controller->$action(); // Executa a Action do Controller

				if (!is_null($route['middle'])) {
					foreach ($route['middle'] as $middle) {
						require_once dirname(__DIR__, 3)."/App/Middle/$middle.php";
					}
				}

				Controller::response( $controller->$action() ); // Executa a Action do Controller
				$GLOBALS['isEncontrou'] = true;
				break;
			}
		}

		if(!$isEncontrou)
			echo "Erro 404";
	}

	protected function setRoutes(array $routes)
	{
		$this->routes = $routes;
	}

	public static function getURL()
	{
		return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	}
}
