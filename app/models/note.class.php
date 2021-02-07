<?php
    namespace App\Models;
    class Note
    {
        private $id_note;
        private $title;
        private $description;
        private $deadline;
        private $color;
        private $creation;
        private $modification;
        private $complete;
        private $id_user;

        function __construct($id_note = null, $title = null, $description = null, $deadline = null, $color = null, $creation = null, $modification = null, $complete = null, $id_user = null)
        {
            $this->id_note = $id_note;
            $this->title = $title;
            $this->description = $description;
            $this->deadline = $deadline;
            $this->color = $color;
            $this->creation = $creation;
            $this->modification = $modification;
            $this->complete = $complete;
            $this->id_user = $id_user;
        }

        //getters
        function getId_note()
        {
            return $this->id_note;
        }

        function getTitle()
        {
            return $this->title;
        }

        function getDescription()
        {
            return $this->description;
        }

        function getDeadline()
        {
            return $this->deadline;
        }

        function getColor()
        {
            return $this->color;
        }

        function getCreation()
        {
            return $this->creation;
        }

        function getModification()
        {
            return $this->modification;
        }

        function getComplete()
        {
            return $this->complete;
        }

        function getId_user()
        {
            return $this->id_user;
        }

        //setters
        function setId_note($id_note)
        {
            if(!is_int($id_note))
			{
                throw new \Exception('Id inválido',400);
            }
            elseif($id_note === 0)
            {
                throw new \Exception('Id inválido',400);
            }
            else
            {
                $this->id_note = $id_note;
            }
        }

        function setTitle($title)
        {
            if(is_string($title))
            {
                $title = trim($title);
                if(strlen($title) > 255)
                {
                    throw new \Exception('Titulo não pode ser maior que 255 caracteres',400);
                }
                elseif(strlen($title) < 3)
                {
                    throw new \Exception('Titulo não pode ser menor que 3 caracteres',400);
                }
                else
                {
                    $this->title = $title;
                }
            }
            else
            {
                throw new \Exception('Titulo deve ser uma string',400);
            }
        }

        function setDescription($description)
        {
            if(is_string($description))
            {
                $description = trim($description);
                if(strlen($description) > 255)
                {
                    throw new \Exception('Descrição não pode ser maior que 255 caracteres',400);
                }
                elseif(strlen($description) < 3)
                {
                    throw new \Exception('Descrição não pode ser menor que 3 caracteres',400);
                }
                else
                {
                    $this->description = $description;
                }
            }
            else
            {
                throw new \Exception('Descrição deve ser uma string',400);
            }
        }

        function setDeadline($deadline)
        {
            if(is_string($deadline))
			{
				$deadline = trim($deadline);
                if(!preg_match("/(?<Y>\d{4})-(?<m>\d{2})-(?<d>\d{2}) (?<H>\d{2}):(?<i>\d{2}):(?<s>\d{2})/i", $deadline, $match))
                {
                    throw new \Exception('Data inválida',400);
                }
                elseif(!checkdate($match['m'],$match['d'],$match['Y']) || !strtotime("{$match['Y']}-{$match['m']}-{$match['d']} {$match['H']}:{$match['i']}:{$match['s']}"))
				{
					throw new \Exception('Data inválida',400);
                }
				else
				{
					$this->deadline = $deadline;
				}
			}
			else
			{
				throw new \Exception('Prazo inválida',400);
			}
        }

        function setColor($color)
        {
            if(is_string($color))
            {
                $color = trim($color);
                if(strlen($color) !== 7)
                {
                    throw new \Exception('Cor deve conter 7 caracteres',400);
                }
                elseif($color === '')
                {
                    throw new \Exception('Cor não pode ser vazio',400);
                }
                elseif(!preg_match('/^#(\d{6})$/',$color))
                {
                    throw new \Exception('Formato inválido',400);
                }
                else
                {
                    $this->color = $color;
                }
            }
            else
            {
                throw new \Exception('Cor deve ser uma string',400);
            }
        }

        function setCreation($creation)
        {
            if(is_string($creation))
			{
				$creation = trim($creation);
                if(!preg_match("/(?<Y>\d{4})-(?<m>\d{2})-(?<d>\d{2}) (?<H>\d{2}):(?<i>\d{2}):(?<s>\d{2})/i", $creation, $match))
                {
                    throw new \Exception('Data inválida',400);
                }
				elseif(!checkdate($match['m'],$match['d'],$match['Y']) || !strtotime("{$match['Y']}-{$match['m']}-{$match['d']} {$match['H']}:{$match['i']}:{$match['s']}"))
				{
					throw new \Exception('Data inválida',400);
				}
				else
				{
					$this->creation = $creation;
				}
			}
			else
			{
				throw new \Exception('Data criação inválida',400);
			}
        }

        function setModification($modification)
        {
            if(is_string($modification))
			{
				$modification = trim($modification);
                if(!preg_match("/(?<Y>\d{4})-(?<m>\d{2})-(?<d>\d{2}) (?<H>\d{2}):(?<i>\d{2}):(?<s>\d{2})/i", $modification, $match))
                {
                    throw new \Exception('Data inválida',400);
                }
				elseif(!checkdate($match['m'],$match['d'],$match['Y']) || !strtotime("{$match['Y']}-{$match['m']}-{$match['d']} {$match['H']}:{$match['i']}:{$match['s']}"))
				{
					throw new \Exception('Data inválida',400);
				}
				else
				{
					$this->modification = $modification;
				}
			}
			else
			{
				throw new \Exception('Data modificação inválida',400);
			}
        }

        function setComplete($complete)
        {
            if($complete !== false && $complete !== true)
            {
                throw new \Exception('Completo só pode true ou false',400);
            }
            else
            {
                if($complete === true)
                {
                    $this->complete = 's';
                }
                else
                {
                    $this->complete = 'n';
                }
            }
        }

        function setId_user($id_user)
        {
            if(!is_int($id_user))
			{
                throw new \Exception('Id inválido',400);
            }
            elseif($id_user === 0)
            {
                throw new \Exception('Id inválido',400);
            }
            else
            {
                $this->id_user = $id_user;
            }
        }
    }
?>