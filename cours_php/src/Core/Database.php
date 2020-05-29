<?php

namespace App\Core;

class Database
{
	/*
		les membres statiques ne nécessitent pas d'instanciation d'objet
		\ permet de revenir à l'espace global du PHP
	*/
	const HOST = '127.0.0.1';
	const DB_NAME = 'travelagency';
	const USER = 'root';
	const PASSWORD = '';
	const PORT = 3308;

	static public function connect():\PDO
	{
		/*/ pas de constantes
		$pdo = new \PDO("mysql:host=127.0.0.1;dbname=travelagency;charset=utf8", 'root', 'root', [
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
		]);*/

		// avec constantes
		$pdo = new \PDO("mysql:host=" . self::HOST . ";dbname=" . self::DB_NAME .";charset=utf8;port=" .self::PORT, self::USER, self::PASSWORD, [
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
		]);

		return $pdo;
	}
}