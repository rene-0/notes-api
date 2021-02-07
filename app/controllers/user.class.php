<?php
	namespace App\Controllers;
	class User extends Controller
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
        
        function createUser()
        {
            $post_value = file_get_contents('php://input');
			$obj = parent::json($post_value);
			$user = new \App\Models\User();
			$user->setName($obj->name);
			$user->setUser($obj->user);
			$user->setPassword($obj->password);
			$user->setPassword(password_hash($user->getPassword(),PASSWORD_DEFAULT));
			$user->setTries(0);
			$user->setActive('s');
			$userDAO = new \App\Models\UserDAO();
			$test = $userDAO->testUser($user);
			if(count($test) > 0)
			{
				throw new \Exception('Nome de usuário já existe',409);
			}
			else
			{
				$ret = $userDAO->createUser($user);
				if(!$ret)
				{
					throw new \Exception('Não foi possível criar usuário',500);
				}
				else
				{
					$ret = $userDAO->getLastUser($user);
					$data = array(
						"name" => $ret->name,
						"user" => $ret->user,
						"password" => $ret->password
					);
					$response = new \App\Core\Response(201, true, "Usuário criado", $data, false);
					$response->send();
				}
			}
        }
	}
?>