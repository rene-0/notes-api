<?php
    namespace App\Models;
    class Notes
    {
        private $id_note;
        private $titulo;
        private $descricao;
        private $prazo;
        private $cor;
        private $data_cricao;
        private $data_modificacao;
        private $completo;
        private $id_usuario;

        function __construct($id_note = null, $titulo, $descricao, $prazo, $cor, $data_cricao, $data_modificacao, $completo, $id_usuario = null)
        {
            $this->id_note = $id_note;
            $this->titulo = $titulo;
            $this->descricao = $descricao;
            $this->prazo = $prazo;
            $this->cor = $cor;
            $this->data_cricao = $data_cricao;
            $this->data_modificacao = $data_modificacao;
            $this->completo = $completo;
            $this->id_usuario = $id_usuario;
        }

        //getters
        function getId_note()
        {
            return $this->id_note;
        }

        function getTitulo()
        {
            return $this->titulo;
        }

        function getDescricao()
        {
            return $this->descricao;
        }

        function getPrazo()
        {
            return $this->prazo;
        }

        function getCor()
        {
            return $this->cor;
        }

        function getData_cricao()
        {
            return $this->data_cricao;
        }

        function getData_modificacao()
        {
            return $this->data_modificacao;
        }

        function getCompleto()
        {
            return $this->completo;
        }

        function getId_usuario()
        {
            return $this->id_usuario;
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

        function setTitulo($titulo)
        {
            if(is_string($titulo))
            {
                $titulo = trim($titulo);
                if(strlen($titulo) > 255)
                {
                    throw new \Exception('Titulo não pode ser maior que 255 caracteres',400);
                }
                elseif(strlen($titulo) < 3)
                {
                    throw new \Exception('Titulo não pode ser menor que 3 caracteres',400);
                }
                else
                {
                    $this->titulo = $titulo;
                }
            }
            else
            {
                throw new \Exception('Titulo deve ser uma string',400);
            }
        }

        function setDescricao($descricao)
        {
            if(is_string($descricao))
            {
                $descricao = trim($descricao);
                if(strlen($descricao) > 255)
                {
                    throw new \Exception('Descrição não pode ser maior que 255 caracteres',400);
                }
                elseif(strlen($descricao) < 3)
                {
                    throw new \Exception('Descrição não pode ser menor que 3 caracteres',400);
                }
                else
                {
                    $this->descricao = $descricao;
                }
            }
            else
            {
                throw new \Exception('Descrição deve ser uma string',400);
            }
        }

        function setPrazo($prazo)
        {
            if(is_string($prazo))
			{
				$prazo = trim($prazo);
                if(!preg_match("/(?<Y>\d{4})-(?<m>\d{2})-(?<d>\d{2}) (?<H>\d{2}):(?<i>\d{2}):(?<s>\d{2})/i", $prazo, $match))
                {
                    throw new \Exception('Data inválida',400);
                }
                elseif(!checkdate($match['m'],$match['d'],$match['Y']) || !strtotime("{$match['Y']}-{$match['m']}-{$match['d']} {$match['H']}:{$match['i']}:{$match['s']}"))
				{
					throw new \Exception('Data inválida',400);
                }
				else
				{
					$this->prazo = $prazo;
				}
			}
			else
			{
				throw new \Exception('Prazo inválida',400);
			}
        }

        function setCor($cor)
        {
            if(is_string($cor))
            {
                $cor = trim($cor);
                if(strlen($cor) !== 7)
                {
                    throw new \Exception('Cor deve conter 7 caracteres',400);
                }
                elseif($cor === '')
                {
                    throw new \Exception('Cor não pode ser vazio',400);
                }
                elseif(!preg_match('/^#(\d{6})$/',$cor))
                {
                    throw new \Exception('Formato inválido',400);
                }
                else
                {
                    $this->cor = $cor;
                }
            }
            else
            {
                throw new \Exception('Cor deve ser uma string',400);
            }
        }

        function setData_cricao($data_cricao)
        {
            if(is_string($data_cricao))
			{
				$data_cricao = trim($data_cricao);
                if(!preg_match("/(?<Y>\d{4})-(?<m>\d{2})-(?<d>\d{2}) (?<H>\d{2}):(?<i>\d{2}):(?<s>\d{2})/i", $data_cricao, $match))
                {
                    throw new \Exception('Data inválida',400);
                }
				elseif(!checkdate($match['m'],$match['d'],$match['Y']) || !strtotime("{$match['Y']}-{$match['m']}-{$match['d']} {$match['H']}:{$match['i']}:{$match['s']}"))
				{
					throw new \Exception('Data inválida',400);
				}
				else
				{
					$this->data_cricao = $data_cricao;
				}
			}
			else
			{
				throw new \Exception('Data criação inválida',400);
			}
        }

        function setData_modificacao($data_modificacao)
        {
            if(is_string($data_modificacao))
			{
				$data_modificacao = trim($data_modificacao);
                if(!preg_match("/(?<Y>\d{4})-(?<m>\d{2})-(?<d>\d{2}) (?<H>\d{2}):(?<i>\d{2}):(?<s>\d{2})/i", $data_modificacao, $match))
                {
                    throw new \Exception('Data inválida',400);
                }
				elseif(!checkdate($match['m'],$match['d'],$match['Y']) || !strtotime("{$match['Y']}-{$match['m']}-{$match['d']} {$match['H']}:{$match['i']}:{$match['s']}"))
				{
					throw new \Exception('Data inválida',400);
				}
				else
				{
					$this->data_modificacao = $data_modificacao;
				}
			}
			else
			{
				throw new \Exception('Data modificação inválida',400);
			}
        }

        function setCompleto($completo)
        {
            if($completo !== false && $completo !== true)
            {
                throw new \Exception('Completo só pode true ou false',400);
            }
            else
            {
                $this->completo = $completo;
            }
        }

        function setId_usuario($id_usuario)
        {
            if(!is_int($id_usuario))
			{
                throw new \Exception('Id inválido',400);
            }
            elseif($id_usuario === 0)
            {
                throw new \Exception('Id inválido',400);
            }
            else
            {
                $this->id_usuario = $id_usuario;
            }
        }
    }
?>