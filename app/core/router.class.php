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
			//Percorre a tabela de rotas
				foreach($table as $key => $row)
				{
					if(isset($this->url[0]) && $this->url[0] == $row['url'])
					{
						$this->controller = $this->url[0];
						unset($this->url[0]);
						if(file_exists("app/controllers/"."{$this->controller}.class.php"))
						{
							//Cria o controller
								$this->controller = "App\Controllers\\".$this->controller;
								$this->controller = new $this->controller();
							//Cria o controller
						}
						else
						{
							throw new \Exception("Erro 404, não encontrado", 404);
						}
					}
				}
			//Percorre a tabela de rotas
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