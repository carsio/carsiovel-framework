<?php

namespace SON\Controller;

use SON\View\Layout;

class Action extends Layout
{
	public function render($view)
	{

		$this->view = str_replace(".", "/", $view);

		$this->getContent();

		if ( file_exists("../App/View/layouts/". $this->getLayout() .".php") ){
			// require_once "../App/View/layouts/". $this->getLayout() .".php";
			$strFile = file_get_contents("../App/View/layouts/". $this->getLayout() .".php");

		}else
			$this->content();

			return $this;
	}

	public function with($name, $value = '')
	{
		if (!is_array($name)) {
			$this->data->scope[$name] = $value;
		}elseif (is_array($name)) {
			foreach ($name as $key => $value) {
				$this->data->scope[$key] = $value;
			}
		}

		$this->play();

		return new \stdClass();
	}

	public function play()
	{
		if ( file_exists("../App/View/layouts/". $this->getLayout() .".php") ){
			$strFile = file_get_contents("../App/View/layouts/". $this->getLayout() .".php");
			eval(' ?>'. $strFile .'<?php ');
			// require_once "../App/View/layouts/". $this->getLayout() .".php";
		}else
			$this->content();

	}

	protected function content()
	{
		if (!$this->path) { // Caso não possua caminho definido seta default
			$class = get_class($this);
			$class = str_replace('App\\Controller\\', '', $class); // Default é uma view que fica dentro de uma pasta como o mesmos nome da classe do controller
			$class = str_replace('Controller', '', $class);
			$this->incFile($class);
		}else{
			$this->incFile($this->path);
		}

	}

	public function incFile($class)
	{
		if ( file_exists('../App/View/'.$class.'/'.$this->view.'.phtml') ) {
			include_once '../App/View/'.$class.'/'.$this->view.'.phtml';
		}elseif ( file_exists('../App/View/'.$class.'/'.$this->view.'.php') ){
			include_once '../App/View/'.$class.'/'.$this->view.'.php';
		}else{ // Caso não encontre a view retorna essa mensagem
			echo "<h1>Erro: View $class/$this->view não foi encontrada</h1>";
			exit();
		}
	}

	public function getContent()
	{
		if ( file_exists("../App/View/$this->view.php") ) {
			$strFile = file_get_contents("../App/View/$this->view.php");
		}else{ // Caso não encontre a view retorna essa mensagem
			echo "<h1>Erro: View /$this->view não foi encofadsfasdntrada</h1>";
			exit();
		}

		preg_match_all( "|<\?php(.*)\?>|U" , $strFile , $retorno);

		foreach ($retorno[1] as $code) {
			if (
				strpos( $code, '$this->set(' ) !== false ||
				strpos( $code, '$this->setLayout(' ) !== false
			) { // executa no conteudo os metodos para definir parametros para o layouts
				eval($code.";");
			}else{

			}
		}

		preg_match_all( "/\<\!\-\-\s*section\(\'(.*)\'\)\s*\-\-\>(.|\s)*?\<\!\-\-\s*endsection\s*\-\-\>/" , $strFile , $section);

		for ($i=0; $i < count($section[0]); $i++) {
			$this->layoutData->section[$section[1][$i]] = $section[0][$i];
		}

	}
}
