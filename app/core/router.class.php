<?php
	namespace App\Core;
	class Router
	{
		private $controller = "example";
		private $method = "index";
		private $params = array();

		function dispatch($table)
		{
			$this->url = $this->parseUrl();
			//var_dump($this->url);
			//Procura a rota atual na tabela de rotas
				if(isset($this->url[0]))
				{
					foreach($table as $key => $row)
					{
						if($this->url[0] == $row['url'] && $_SERVER['REQUEST_METHOD'] === $row['REQUEST_METHOD'])
						{
							//Reescreve o controller
								$this->controller = $this->url[0];
								unset($this->url[0]);
								if(isset($row['method']))//Se o método for passado, reescreve também
								{
									$this->method = $row['method'];
								}
							//Reescreve o controller
						}
					}
				}
			//Procura a rota atual na tabela de rotas
			//Cria o controller
				if(file_exists("app/controllers/"."{$this->controller}.class.php"))
				{
					$this->controller = "App\Controllers\\".$this->controller;
					$this->controller = new $this->controller();
				}
				else
				{
					throw new \Exception("Erro 404, não encontrado", 404);
				}
			//Cria o controller
			//Chama o método
				if(method_exists($this->controller, $this->method))//Verifica o método padrão
				{
					//Re arrumando o array
						if(isset($this->url))
						{
							$this->params = array_values($this->url);
							unset($this->url);
						}
					//Re arrumando o array
					//Chama o método
						call_user_func_array(array($this->controller,$this->method),$this->params);
					//Chama o método
				}
				else
				{
					throw new \Exception("Erro 404, não encontrado", 404);
				}
			//Chama o método
		}

		function parseUrl()
		{
			if(isset($_GET['URL']))
			{
				$this->url = explode('/',filter_var(rtrim($_GET['URL'], '/'), FILTER_SANITIZE_URL));
				unset($_GET['URL']);
				return $this->url;
			}
		}
	}
?>