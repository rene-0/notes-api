<?php
    namespace App\Core;
    class Response
    {
        private $statusCode;
        private $success;
        private $message = array();
        private $data;
        private $toCache = false;
        private $responseData = array();

        function __construct($statusCode,$success,$message,$data = false,$toCache = false)
        {
            $this->setStatusCode($statusCode);
            $this->setSuccess($success);
            $this->setMessage($message);
            if($this->success)
            {
                $this->setData($data);
            }
            $this->setToCache($toCache);
        }

        //Getters
        function getStatusCode()
        {
            return $this->statusCode;
        }

        function getSuccess()
        {
            return $this->success;
        }

        function getMessage()
        {
            return $this->message;
        }

        function getData()
        {
            return $this->data;
        }

        function getToCache()
        {
            return $this->toCache;
        }

        function getResponseData()
        {
            return $this->responseData;
        }
        //Setters
        function setStatusCode($statusCode)
        {
            if(!is_int($this->statusCode = $statusCode))
            {
                throw new \Exception("statusCode deve ser um inteiro", 500);
            }
            else
            {
                $this->statusCode = $statusCode;
            }
        }

        function setSuccess($success)
        {
            if($success !== false && $success !== true)
            {
                throw new \Exception("success deve ser true ou false", 500);
            }
            else
            {
                $this->success = $success;
            }
        }

        function setMessage($message)
        {
            if(!is_string($message))
            {
                throw new \Exception("message deve ser uma string", 500);
            }
            elseif($message === '')
            {
                throw new \Exception("message não pode ser vazio", 500);
            }
            else
            {
               $this->message[] = $message; 
            }
        }

        function setData($data)
        {
            if(!is_array($data))
            {
                throw new \Exception("data deve ser um array", 500);
            }
            elseif(empty($data))
            {
                throw new \Exception("data não pode ser vazio", 500);
            }
            else
            {
                $this->data = $data;
            }
        }

        function setToCache($toCache)
        {
            if($toCache != false && $toCache != true)
            {
                throw new \Exception("toCache deve ser true ou false", 500);
            }
            else
            {
                $this->toCache = $toCache;
            }
        }

        function setResponseData()
        {
            if($this->success)
            {
                $this->responseData = array(
                    'statusCode' => $this->statusCode,
                    'success' => $this->success,
                    'message' => $this->message,
                    'data' => $this->data
                );
            }
            else
            {
                $this->responseData = array(
                    'statusCode' => $this->statusCode,
                    'success' => $this->success,
                    'message' => $this->message
                );
            }
        }

        function send()
        {
            header('Content-type: aplication/json;charset=utf-8');
            if($this->toCache == null)
            {
                header('Cache-control: max-age=60');
            }
            else
            {
                header('Cache-control: no-cache, no-store');
            }
            http_response_code($this->getStatusCode());
            $this->setResponseData();
            echo json_encode($this->getResponseData());
        }
    }
?>