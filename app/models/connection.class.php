<?php
	namespace App\Models;
	use PDO; //Classe do PDO ou use um '\' antes de criar a classe PDO
	use App\Core\Config; //Classe de configuração
	abstract class Connection
	{
		protected static $connec = null;
		
		function __construct(){}
		
		protected static function getConnection()
		{
			try
			{
				if(self::$connec === null)
				{
					$dns = "mysql:host=" . Config::DB_HOST . ";port=3306;dbname=" . Config::DB_NAME . ";charset=utf8mb4";
					self::$connec = new PDO($dns,Config::DB_USER,Config::DB_PASSWORD);
					self::$connec->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
			}
		}
	}
?>