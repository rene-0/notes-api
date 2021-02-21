<?php
    namespace App\Models;
    class Session
    {
        private $id_session;
        private $access_token;
        private $access_token_expiry;
        private $refresh_token;
        private $refresh_token_expiry;
        private $id_user;

        function __construct($id_session = null,$access_token = null,$access_token_expiry = null,$refresh_token = null,$refresh_token_expiry = null,$id_user = null)
        {
            $this->id_session = $id_session;
            $this->access_token = $access_token;
            $this->access_token_expiry = $access_token_expiry;
            $this->refresh_token = $refresh_token;
            $this->refresh_token_expiry = $refresh_token_expiry;
            $this->id_user = $id_user;
        }

        //getters
        function getId_session()
        {
            return $this->id_session;
        }
        
        function getAccess_token()
        {
            return $this->access_token;
        }

        function getAccess_token_expiry()
        {
            return $this->access_token_expiry;
        }

        function getRefresh_token()
        {
            return $this->refresh_token;
        }

        function getRefresh_token_expiry()
        {
            return $this->refresh_token_expiry;
        }

        function getId_user()
        {
            return $this->id_user;
        }

        //setters
        function setId_session($id_session)
        {
            if(!is_int($id_session))
			{
                throw new \Exception('Id_session inválido',500);
            }
            elseif($id_session === 0)
            {
                throw new \Exception('Id_session inválido',500);
            }
            else
            {
                $this->id_session = $id_session;
            }
        }

        function setAccess_token($access_token)
        {
            if(is_string($access_token))
            {
                $access_token = trim($access_token);
                if(strlen($access_token) > 255)
                {
                    throw new \Exception('Token de acesso não pode ser maior que 255 caracteres',400);
                }
                elseif(strlen($access_token) < 3)
                {
                    throw new \Exception('Token de acesso não pode ser menor que 3 caracteres',400);
                }
                else
                {
                    $this->access_token = $access_token;
                }
            }
            else
            {
                throw new \Exception('Token de acesso deve ser uma string',400);
            }
        }

        function setAccess_token_expiry($access_token_expiry)
        {
            if(is_string($access_token_expiry))
			{
				$access_token_expiry = trim($access_token_expiry);
                if(!preg_match("/(?<Y>\d{4})-(?<m>\d{2})-(?<d>\d{2}) (?<H>\d{2}):(?<i>\d{2}):(?<s>\d{2})/i", $access_token_expiry, $match))
                {
                    throw new \Exception('Data inválida',500);
                }
                elseif(!checkdate($match['m'],$match['d'],$match['Y']) || !strtotime("{$match['Y']}-{$match['m']}-{$match['d']} {$match['H']}:{$match['i']}:{$match['s']}"))
				{
					throw new \Exception('Data inválida',500);
                }
				else
				{
					$this->access_token_expiry = $access_token_expiry;
				}
			}
			else
			{
				throw new \Exception('Tempo do token de acesso deve ser uma string',500);
			}
        }

        function setRefresh_token($refresh_token)
        {
            if(is_string($refresh_token))
            {
                $refresh_token = trim($refresh_token);
                if(strlen($refresh_token) > 255)
                {
                    throw new \Exception('Token de recarga não pode ser maior que 255 caracteres',400);
                }
                elseif(strlen($refresh_token) < 3)
                {
                    throw new \Exception('Token de recarga não pode ser menor que 3 caracteres',400);
                }
                else
                {
                    $this->refresh_token = $refresh_token;
                }
            }
            else
            {
                throw new \Exception('Token de refresh deve ser uma string',400);
            }
        }

        function setRefresh_token_expiry($refresh_token_expiry)
        {
            if(is_string($refresh_token_expiry))
			{
				$refresh_token_expiry = trim($refresh_token_expiry);
                if(!preg_match("/(?<Y>\d{4})-(?<m>\d{2})-(?<d>\d{2}) (?<H>\d{2}):(?<i>\d{2}):(?<s>\d{2})/i", $refresh_token_expiry, $match))
                {
                    throw new \Exception('Data inválida',500);
                }
                elseif(!checkdate($match['m'],$match['d'],$match['Y']) || !strtotime("{$match['Y']}-{$match['m']}-{$match['d']} {$match['H']}:{$match['i']}:{$match['s']}"))
				{
					throw new \Exception('Data inválida',500);
                }
				else
				{
					$this->refresh_token_expiry = $refresh_token_expiry;
				}
			}
			else
			{
				throw new \Exception('Tempo do token de refresh deve ser uma string',500);
			}
        }

        function setId_user($id_user)
        {
            if(!is_int($id_user))
			{
                throw new \Exception('Id_user inválido',500);
            }
            elseif($id_user === 0)
            {
                throw new \Exception('Id_user inválido',500);
            }
            else
            {
                $this->id_user = $id_user;
            }
        }
    }
?>