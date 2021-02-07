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
			$post_value = file_get_contents('php://input');
			$post_value = json_decode($post_value);
			if($post_value === true || $post_value === false || $post_value === null)
			{
				throw new \Exception('JSON inválido', 400);
			}
			foreach($data as $row)
			{
				$note = new \App\Models\Note();
				$note->setTitle($row['titulo']);
				$note->setDescription($row['descricao']);
				$note->setDeadline($row['deadline']);
				$note->setColor($row['color']);
				$note->setCreation($row['data_cricao']);
				$note->setModification($row['data_modificacao']);
				$note->setComplete($row['completo']);
				$note->setId_user($row['id_usuario']);
			}
			$noteDAO = new \App\Models\NoteDAO();
			$ret = $noteDAO->createNote($note);
			if($ret === false)
			{
				throw new \Exception('Não foi possível criar nota',500);
			}
			else
			{
				//Não buscar as notas criadas no banco de dados
				$data = $post_value;
				$response = new \App\Core\Response(201, true, 'Nota criada', $data, false);
			}
		}
		
		protected function getNotes()
		{
			$notesDAO = new \App\Models\NoteDAO();
			$ret = $notesDAO->getNotes();
			var_dump($ret);
		}
	}
?>