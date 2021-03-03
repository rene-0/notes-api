<?php
	namespace App\Controllers;
	class Notes extends Controller
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
        
        protected function createNote()
        {
			//Testa o json
				$post_value = file_get_contents('php://input');
				$obj = parent::json($post_value);
			//Testa o json
			//Testa o usuário e o token
				$check = parent::checkUser();
			//Testa o usuário e o token
			//Testa se todos os valores foram enviados
			//var_dump($obj);
			if(!isset($obj->notes))
			{
				throw new \Exception("Erro, json inválido",400);
			}
			else
			{
				foreach($obj->notes as $key => $dados)
				{
					if(!isset($dados->title))
					{
						throw new \Exception("Erro, title deve ser enviado - [{$key}]",400);
					}
					elseif(!isset($dados->description))
					{
						throw new \Exception("Erro, description deve ser enviado - [{$key}]",400);
					}
					elseif(!isset($dados->deadline))
					{
						throw new \Exception("Erro, deadline deve ser enviado - [{$key}]",400);
					}
					elseif(!isset($dados->color))
					{
						throw new \Exception("Erro, color deve ser enviado - [{$key}]",400);
					}
					elseif(!isset($dados->complete))
					{
						throw new \Exception("Erro, complete deve ser enviado - [{$key}]",400);
					}
				}
			}
			//Testa se todos os valores foram enviados
			$notes = array();
			foreach($obj->notes as $key => $row)
			{
				try
				{
					$note = new \App\Models\Note();
					$note->setTitle($row->title);
					$note->setDescription($row->description);
					$note->setDeadline($row->deadline);
					$note->setColor($row->color);
					$note->setCreation(date("Y-m-d H:i:s"));
					$note->setModification(date("Y-m-d H:i:s"));
					$note->setComplete($row->complete);
					$note->setId_user((int) $check->id_user);
					$notes[] = $note;
				}
				catch(\Exception $e)
				{
					throw new \Exception($e->getMessage() . " - [{$key}]",$e->getCode());//Pega a exceção e aciona ela novamente para somente invformar o chave do arry onde aconteceu
				}
			}
			//var_dump($notes);
			
			$noteDAO = new \App\Models\NoteDAO();
			foreach($notes as $note)
			{
				$ret = $noteDAO->createNote($note);
				if($ret === false)
				{
					throw new \Exception('Não foi possível criar nota',500);
				}
				else
				{
					$ret = $noteDAO->getLastNote();
					$note->setId_note((int) $ret->id_note);
				}
			}
			
			//Não buscar as notas criadas no banco de dados
			$data = array();
			foreach($notes as $note)
			{
				$data[] = array(
					"id_note" => $note->getId_note(),
					"title" => $note->getTitle(),
					"description" => $note->getDescription(),
					"deadline" => $note->getDeadline(),
					"color" => $note->getColor(),
					"complete" => $note->getComplete(),
					"creation" => $note->getCreation(),
					"modification" => $note->getModification()
				);
			}
			$response = new \App\Core\Response(201, true, 'Nota(s) criada(s)', $data, false);
			$response->send();
		}
		
		function alterNote()
		{
			//Testa o json
				$post_value = file_get_contents('php://input');
				$obj = parent::json($post_value);
			//Testa o json
			//Testa o usuário e o token
				$check = parent::checkUser();
			//Testa o usuário e o token
			//Testa o envio
				if(!isset($obj->id_note))
				{
					throw new \Exception("Erro, ID da nota deve ser enviado",400);
				}
				elseif(!isset($obj->title) && !isset($obj->description) && !isset($obj->color) && !isset($obj->complete) && !isset($obj->deadline))
				{
					throw new \Exception("Erro, um ou mais dos seguintes parametros devem ser enviados: title, description, color, complete e deadline",400);
				}
			//Testa o envio
			//Cria a nota
				$note = new \App\Models\Note();
				$note->setId_note($obj->id_note);
				if(isset($obj->title))
				{
					$note->setTitle($obj->title);
				}

				if(isset($obj->description))
				{
					$note->setDescription($obj->description);
				}
				
				if(isset($obj->color))
				{
					$note->setColor($obj->color);
				}

				if(isset($obj->complete))
				{
					$note->setComplete($obj->complete);
				}

				if(isset($obj->deadline))
				{
					$note->setDeadline($obj->deadline);
				}
				$note->setId_user((int) $check->id_user);
				$note->setModification(date("Y-m-d H:i:s"));
			//Cria a nota
			//var_dump($note);
			//Procura se a nota pertence ao usuário
				$noteDAO = new \App\Models\NoteDAO();
				$ret = $noteDAO->getNoteByUser($note);
				if($ret === false)
				{
					throw new \Exception("Erro, nota não encontrada",400);
				}
			//Procura se a nota pertence ao usuário
			$ret = $noteDAO->alterNote($note);
			if($ret === false)
			{
				throw new \Exception('Não foi possível alterar a nota',500);
			}
			else
			{
				$ret = $noteDAO->getNote($note);
				$data = array(
					"id_note" => $ret->id_note,
					"title" => $ret->title,
					"description" => $ret->description,
					"deadline" => $ret->deadline,
					"color" => $ret->color,
					"complete" => $ret->complete,
					"creation" => $ret->creation,
					"modification" => $ret->modification
					
				);
				$response = new \App\Core\Response(200, true,"Nota alterada", $data, false);
				$response->send();
			}
		}

		protected function getNotes()
		{
			//Testa o usuário e o token
				$check = parent::checkUser();
			//Testa o usuário e o token
			$user = new \App\Models\User($check->id_user);
			$notesDAO = new \App\Models\NoteDAO();
			$ret = $notesDAO->getNotesByUser($user);
			$data = array();
			foreach($ret as $dados)
			{
				$data[] = array(
					"id_note" => $dados->id_note,
					"title" => $dados->title,
					"description" => $dados->description,
					"deadline" => $dados->deadline,
					"color" => $dados->color,
					"complete" => $dados->complete,
					"creation" => $dados->creation,
					"modification" => $dados->modification
				);
			}
			$response = new \App\Core\Response(200, true, 'Notas buscadas', $data, true);
			$response->send();
		}

		protected function deleteNote()
		{
			//Testa o json
				$post_value = file_get_contents('php://input');
				$obj = parent::json($post_value);
			//Testa o json
			//Testa o usuário e o token
				$check = parent::checkUser();
			//Testa o usuário e o token
			if(!isset($obj->id_note))
			{
				throw new \Exception("Erro, ID da nota deve ser enviado",400);
			}
			$note = new \App\Models\Note();
			$note->setId_note($obj->id_note);
			$note->setId_user((int) $check->id_user);

			$noteDAO = new \App\Models\NoteDAO();
			$ret = $noteDAO->getNoteByUser($note);
			if($ret === false)
			{
				throw new \Exception('Erro, nota não encontrada',400);
			}

			$data = array(
				"id_note" => $ret->id_note,
				"title" => $ret->title,
				"description" => $ret->description,
				"deadline" => $ret->deadline,
				"color" => $ret->color,
				"complete" => $ret->complete,
				"creation" => $ret->creation,
				"modification" => $ret->modification
			);

			$ret = $noteDAO->deleteNote($note);
			if($ret === false)
			{
				throw new \Exception('Não foi possível remover a nota',500);
			}
			else
			{
				$response = new \App\Core\Response(200, true, 'Nota removida', $data, true);
				$response->send();
			}
		}
	}
?>