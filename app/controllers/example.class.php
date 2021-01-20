<?php
	namespace App\Controllers;
	class Example extends Controller
	{
		/*
			*Ao usar uma classe de name space diferente do que está sendo usado agora 'App\Controllers' coloca-se um \ antes para saber que se trata de um namespace exterior '\App\Models\Model'
		*/
		protected function before()
		{
			parent::before();
		}
		
		protected function after()
		{
			parent::after();
		}
		
		function __call($name, $args)
		{
			$this->before();//Codigo antes do method ser achamado
			call_user_func_array([$this, $name], $args);
			$this->after();//Codigo depois do method ser achamado
		}
		
		function index()
		{
			echo "Nada";
		}

		function teste()
		{
			echo "Method teste";
		}
	}
?>