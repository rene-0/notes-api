<?php
	session_start();
	//Auto loader
		spl_autoload_register(function ($className){
			//var_dump($className);
			$root = __DIR__;
			//var_dump($root);
			$file = $root. '/' .$className. '.class.php';
			$file = str_replace("\\",'/',$file);
			//var_dump($file);
			if(!file_exists($file))
			{
				trigger_error("Classe '{$className}' não encontrada", E_USER_ERROR);//Trocar por algo melhor
			}
			else
			{
				require_once "{$file}";
			}
		});
	//Auto loader
	
	//Erro e exceção handler
		set_error_handler('App\Core\Error::errorHandler');
		set_exception_handler('App\Core\Error::exceptionHandler');
		date_default_timezone_set('America/Sao_Paulo');
	//Router
	$router = new App\Core\Router();
	$table = array(
		array('url' => 'example', 'REQUEST_METHOD' => 'GET', 'controller' => 'Example'),
		array('url' => 'example', 'REQUEST_METHOD' => 'POST', 'controller' => 'Example', 'method' => 'teste')
	);
	//var_dump($table);
	$router->dispatch($table);
?>