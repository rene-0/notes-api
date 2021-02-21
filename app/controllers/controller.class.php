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

		protected function checkUser()
		{
			$headers = apache_request_headers();
			$session = new \App\Models\Session();
			//Access_token
				if(!isset($headers['Authorization']))
				{
					throw new \Exception("Erro, token de acesso deve ser enviado",400);
				}
				else
				{
					$session->setAccess_token($headers['Authorization']);
				}
			//Access_token
			$userDAO = new \App\Models\UserDAO();
			$ret = $userDAO->checkUserSession($session);
			//Checa o usuário
				if(!$ret)
				{
					throw new \Exception("Erro, token de acesso inválido",401);
				}
				else
				{
					$user = new \App\Models\User($ret->id_user);
					if($ret->tries >= 3)
					{
						$userDAO->addAttenpt($user);
						throw new \Exception("Limite de tentativas excedido",401);
					}
					elseif($ret->active === 'n')
					{
						$userDAO->addAttenpt($user);
						throw new \Exception("Usuário desativado",401);
					}
					else
					{
						$userDAO->resetAttenpts($user);
						return $ret;
					}
				}
			//Checa o usuário
		}
	}
?>