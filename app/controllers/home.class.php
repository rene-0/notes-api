<?php
	namespace App\Controllers;
	class Home extends Controller
	{
		protected function before()
		{
			//echo "Antes";
		}
		
		protected function after()
		{
			//echo "Depois";
		}

        function __call($name, $args)
		{
			$this->before();//Codigo antes do method ser achamado
			call_user_func_array([$this, $name], $args);
			$this->after();//Codigo depois do method ser achamado
		}

		protected function index()
		{
            $response = new \App\Core\Response(200,false,'Bem-vindo a notes-api! Dê uma olhada nesse projeto no github: https://github.com/rene-0/notes-api',false,true);
            $response->send();
        }
	}
?>