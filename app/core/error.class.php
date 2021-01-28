<?php
	namespace App\Core;
	
	class Error
	{
		//Função de loggar o erro
		private function logError($exception)
		{
			ini_set('error_log',dirname(__DIR__) . '/storage/logs/' . date('d-m-Y') . '.txt');
			$message = "Uncaught exception: '". get_class($exception) ."'";
			$message .= "Message: '". $exception->getMessage() ."'";
			$message .= PHP_EOL."Stack trace:". $exception->getTraceAsString() ."";
			$message .= PHP_EOL."Throw in '". $exception->getFile() ."' on line ". $exception->getLine() .PHP_EOL;
			error_log($message);
		}
		
		//função que transforma erro em execeção
		public static function errorHandler($level, $message, $file, $line)
		{
			if(error_reporting() !== 0)
			{
				throw new \ErrorException($message, 0, $level, $file, $line);
			}
		}
		
		public static function exceptionHandler($exception)
		{
			if(\App\Core\Config::SHOW_ERRORS)
			{
				if($exception->getCode() == 0 || $exception->getCode() == 500)//Se for um erro convertido para exceção, o código é 0
				{
					echo "<h1>Fatal error</h1>";
					echo "<p>Uncaught exception: '". get_class($exception) ."'</p>";
					echo "<p>Message: '". $exception->getMessage() ."'</p>";
					echo "<p>Stack trace:<pre>". $exception->getTraceAsString() ."</pre></p>";
					echo "<p>Throw in '". $exception->getFile() ."' on line ". $exception->getLine() ."</p>";
				}
				else
				{
					header('Content-type: aplication/json;charset=utf-8');
					//Caso seja uma exceção criada pelo próprio script, as que vem com o código (400,401, etc)
					$response = new \App\Core\Response($exception->getCode(),false,$exception->getMessage());
					$response->send();
				}
			}
			else
			{
				header('Content-type: aplication/json;charset=utf-8');
				if($exception->getCode() == 0 || $exception->getCode() == 500)//Caso seja uma exceção que foi convertida para erro
				{
					//Envia uma mensagem genérica
					(new self)->logError($exception);
					$response = new \App\Core\Response(500,false,"Erro 500, o servidor não conseguiu processar sua requisição");
					$response->send();
				}
				else
				{
					//Caso seja uma exceção criada pelo próprio script, as que vem com o código (400,401, etc)
					$response = new \App\Core\Response($exception->getCode(),false,$exception->getMessage());
					$response->send();
				}
			}
		}
	}
?>