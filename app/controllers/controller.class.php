<?php
	namespace App\Controllers;
	class Controller
	{
		protected function before()
		{
			//echo "Antes";
		}
		
		protected function after()
		{
			//echo "Depois";
		}

		//Adicionar função para testar e encodar o json

		protected function json($json)
		{
			$json = json_decode($json);
			if($json === true || $json === false || $json === null)
			{
				throw new \Exception('JSON inválido', 400);
			}
			return $json;
		}
	}
?>