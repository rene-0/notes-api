<?php
    namespace App\Models;
    class User
    {
        private $id_user;
        private $name;
        private $user;
        private $password;
        private $tries;
        private $active;

        function __construct($id_user = null,$name = null,$user = null,$password = null,$tries = null,$active = null)
        {
            $this->id_user = $id_user;
            $this->name = $name;
            $this->user = $user;
            $this->password = $password;
            $this->tries = $tries;
            $this->active = $active;
        }

        //getters
        function getId_user()
        {
            return $this->id_user;
        }

        function getName()
        {
            return $this->name;
        }

        function getUser()
        {
            return $this->user;
        }

        function getPassword()
        {
            return $this->password;
        }

        function getTries()
        {
            return $this->tries;
        }

        function getActive()
        {
            return $this->active;
        }

        //setters
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

        function setName($name)
        {
            if(is_string($name))
            {
                $name = trim($name);
                if(strlen($name) > 255)
                {
                    throw new \Exception('Nome não pode ser maior que 255 caracteres',400);
                }
                elseif(strlen($name) < 3)
                {
                    throw new \Exception('Nome não pode ser menor que 3 caracteres',400);
                }
                else
                {
                    $this->name = $name;
                }
            }
            else
            {
                throw new \Exception('Nome deve ser uma string',400);
            }
        }

        function setUser($user)
        {
            if(is_string($user))
            {
                $user = trim($user);
                if(strlen($user) > 255)
                {
                    throw new \Exception('Usuário não pode ser maior que 255 caracteres',400);
                }
                elseif(strlen($user) < 3)
                {
                    throw new \Exception('Usuário não pode ser menor que 3 caracteres',400);
                }
                else
                {
                    $this->user = $user;
                }
            }
            else
            {
                throw new \Exception('Usuário deve ser uma string',400);
            }
        }

        function setPassword($password)
        {
            if(is_string($password))
            {
                $password = trim($password);
                if(strlen($password) > 255)
                {
                    throw new \Exception('Senha não pode ser maior que 255 caracteres',400);
                }
                elseif(strlen($password) < 8)
                {
                    throw new \Exception('Senha não pode ser menor que 8 caracteres',400);
                }
                else
                {
                    $this->password = $password;
                }
            }
            else
            {
                throw new \Exception('Senha deve ser uma string',400);
            }
        }

        function setTries($tries)
        {
            if(!is_int($tries))
            {
                throw new \Exception('Tentativas deve ser um inteiro',500);
            }
            elseif($tries > 3 || $tries < 0)
            {
                throw new \Exception('Número de tries inválido',500);
            }
            else
            {
                $this->tries = $tries;
            }
        }

        function setActive($active)
        {
            if($active !== 's' && $active !== 'n')
            {
                throw new \Exception('Ativo deve ser uma string com s ou n',500);
            }
            else
            {
                $this->active = $active;
            }
        }
    }
?>