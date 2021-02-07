<?php
	namespace App\Core;
	class Router
	{
		private $table = array();
		private $controller = "example";
		private $method = "index";
		private $params = array();

		function __construct($table)
		{
			$this->table = $table;
		}
		
		function dispatch()
		{
			$this->parseUrl();
			//var_dump($this->url);
			//Procura a rota atual na tabela de rotas
				if(isset($this->url[0]))
				{
					$match = $this->matchContent($this->matchMethod($this->matchUrl($this->url[0])));
					unset($this->url[0]);
					//var_dump($match);
					$this->controller = $match['controller'];
					if(isset($match['method']))
					{
						$this->method = $match['method'];
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
					throw new \Exception("Erro 500, arquivo 'app/controllers/{$this->controller}.class.php' não encontrado", 500);
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
					throw new \Exception("Erro 500, método {$this->method} não encontrado no controller {$match['controller']}", 500);
				}
			//Chama o método
		}

		function matchUrl($url)
		{
			//Procura se a url existe
				$url_matches = array();
				foreach($this->table as $key => $row)
				{
					if($this->url[0] == $row['url'])
					{
						$url_matches[] = $row;
					}
				}
			//Procura se a url existe
			if(empty($url_matches))//Se não existe
			{
				throw new \Exception("Erro 404, não encontrado", 404);
			}
			else
			{
				return $url_matches;
			}
		}

		function matchMethod($url_matches)
		{
			//Procura se existe um REQUEST_METHOD com a url
				$request_matches = array();
				foreach($url_matches as $kay => $row)
				{
					if($_SERVER['REQUEST_METHOD'] === $row['REQUEST_METHOD'])
					{
						$request_matches[] = $row;
					}
				}
				if(empty($request_matches))
				{
					throw new \Exception("Erro 405, método de requisição não autorizado", 405);
				}
				else
				{
					if(count($request_matches) > 1)
					{
						throw new \Exception("Erro, há uma URL com o mesmo método {$request_matches['REQUEST_METHOD']}", 500);
					}
					else
					{
						return $request_matches[0];
					}
				}
			//Procura se existe um REQUEST_METHOD com a url
		}

		function matchContent($request_matches)
		{
			if(isset($request_matches['CONTENT_TYPE']))
			{
				if(isset($_SERVER['CONTENT_TYPE']) === false || $_SERVER['CONTENT_TYPE'] !== $request_matches['CONTENT_TYPE'])
				{
					throw new \Exception("Cabeçalho Content-type dessa requisição deve ser '{$request_matches['CONTENT_TYPE']}'", 400);
				}
				else
				{
					return $request_matches;
				}
			}
			else
			{
				return $request_matches;
			}
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