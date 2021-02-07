<?php
	namespace App\Controllers;
	class Session extends Controller
	{
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
        
        function login()
        {
			$post_value = file_get_contents('php://input');
			$obj = parent::json($post_value);
			$user = new \App\Models\User();
			if(isset($obj->user))
			{
				$user->setUser($obj->user);
			}
			else
			{
				throw new \Exception("Erro, nome de usuário deve ser enviado",400);
			}
			if(isset($obj->password))
			{
				$user->setPassword($obj->password);
			}
			else
			{
				throw new \Exception("Erro, senha deve ser enviado",400);
			}
			$userDAO = new \App\Models\UserDAO();
			$ret = $userDAO->login($user);
			if($ret === false)
			{
				throw new \Exception("Usuário ou senha inválidos",401);
			}
			if(password_verify($obj->password, $ret->password))
			{
				if($ret->tries >= 3)
				{
					$userDAO->addAttenpt($user);
					throw new \Exception("Limite de tentativas excedido",401);
				}
				else
				{
					if($ret->active === 'n')
					{
						$userDAO->addAttenpt($user);
						throw new \Exception("Usuário desativado",401);
					}
					else
					{
						$userDAO->resetAttenpts($user);
						$access_token = base64_encode(bin2hex(openssl_random_pseudo_bytes(24)).time());
						$access_token_expiry = 1200;// 20 minutos
						$refresh_token = base64_encode(bin2hex(openssl_random_pseudo_bytes(24)).time());
						$refresh_token_expiry = 12009600;// 14 dias
						$session = new \App\Models\Session(null,$access_token,$access_token_expiry,$refresh_token,$refresh_token_expiry,$ret->id_user);
						$sessionDAO = new \App\Models\SessionDAO();
						$ret = $sessionDAO->createSession($session);
						if($ret)
						{
							$ret = $sessionDAO->getLastSession();
							$data = array(
								'id_session' => $ret->id_session,
								'access_token' => $ret->access_token,
								'access_token_expiry' => $ret->access_token_expiry,
								'refresh_token' => $ret->refresh_token,
								'refresh_token_expiry' => $ret->refresh_token_expiry,
								'id_user' => $ret->id_user
							);
							$response = new \App\Core\Response(201,true,'Sessão criada',$data);
							$response->send();
						}
						else
						{
							throw new \Exception("Falha ao criar sessão",500);
						}
					}
				}
			}
			else
			{
				$userDAO->addAttenpt($user);
				throw new \Exception("Usuário ou senha inválidos",401);
			}
        }

        function refresh()
        {
            
        }
	}
?>