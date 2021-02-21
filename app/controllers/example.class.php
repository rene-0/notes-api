<?php
	namespace App\Controllers;
	class Example extends Controller
	{
		/*
			*Ao usar uma classe de name space diferente do que está sendo usado agora 'App\Controllers' coloca-se um \ antes para saber que se trata de um namespace exterior '\App\Models\Model'
		*/
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
		
		function index()
		{
			//echo "Nada";
			/*$notes = new \App\Models\Notes(null, 'Título', 'Descrição','2021-01-24 06:35:14','#161616','2021-01-24 06:35:14','2021-01-24 06:35:14',false,null);
			$notes->settitle('Praesent mattis, justo sit amet pulvinar pharetra, libero risus tempor lacus, at lobortis mi erat ut sem. Ut ultrices libero purus. Morbi a sapien eu augue ultrices semper sed non augue. Pellentesque ac leo in lorem pellentesque vulputate vel eu leo odio.');
			$notes->setDescription('aaa');
			$notes->setDeadline('2021-01-26 06:59:14');
			$notes->setColor('#121212');
			$notes->setCreation('2021-01-26 06:59:14');
			$notes->setModification('2021-01-26 06:59:14');
			$notes->setComplete(true);
			$notes->setId_user(1);
			echo "<pre>";
			var_dump($notes);*/
			/*$user = new \App\Models\User();
			$user->setId_usuario(1);
			$user->setNome('Meu nome');
			$user->setUsuario('Usuário');
			$user->setSenha('123');
			$user->setTentativas(0);
			$user->setAtivo('s');
			echo "<pre>";
			var_dump($user);*/
			//echo "Example index";
			$time = time() + 1200;
			echo gmdate("Y-m-d H:i:s", $time);
			echo '<br>';
			echo gmdate("Y-m-d H:i:s", time());
			echo '<br>';
			echo date('Y-m-d H:i:s', strtotime('+20 minutes'));
			echo '<br>';
			echo date('Y-m-d H:i:s', strtotime('+14 days'));
		}
		
		function teste()
		{
			/*
			//echo "Method teste";
			$data = array(
				'texto' => 'Hello world'
			);
			$response = new \App\Core\Response(200,true,['Deu certo','Na verdade não'],$data);
			//var_dump($response);
			$response->send();*/
			$data = '2021-01-24 06:35:14';
			$data = date('Y-m-d H:i:s');
			//$ex =  explode(' ','2021-01-2406:35:14');
			$ex = preg_match("/(?<Y>\d{4})-(?<m>\d{2})-(?<d>\d{2}) (?<H>\d{2}):(?<i>\d{2}):(?<s>\d{2})/i", $data, $match);
			/*var_dump($ex == true);
			var_dump($match);
			echo "--";
			echo $match['Y'];
			echo "<br>";
			echo $match['m'];
			echo "<br>";
			echo $match['d'];
			echo "<br>";
			echo $match['H'];
			echo "<br>";
			echo $match['i'];
			echo "<br>";
			echo $match['s'];
			echo "<br>";*/
			//var_dump(strtotime("{$match['Y']}-{$match['m']}-{$match['d']} {$match['H']}:{$match['i']}:{$match['s']}"));
			echo "Example teste";
		}
	}
?>