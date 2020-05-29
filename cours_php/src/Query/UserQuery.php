<?php

namespace App\Query;

use App\Core\Database;

class UserQuery
{
	// créer un utilisateur
	public function create(array $data = []):void
	{
		// connexion à la base de données
		$connection = Database::connect();
		//echo '<pre>'; var_dump($connection) ; echo '</pre>';

		// requête SQL
		// les variables de requête sont précédées d'un :
		$sql = "
			INSERT INTO
				travelagency.user
			VALUE
				(NULL, :login, :password, 2)
			;
		";

		// préparation de la requête : évaluation de la sécurité de la requête
		$query = $connection->prepare($sql);

		// exécution de la requête en définissant les valeurs des variables de requête
		// variables sont définies sous forme de tableau associatif; les variables deviennent les clés
		$query->execute([
			'login' => $data['login'],
			'password' => password_hash($data['password'], \PASSWORD_ARGON2I)
		]);
	}

	// vérifier un utilisateur
	public function exists(array $data = []):bool
	{
		// connexion
		$connection = Database::connect();
		
		// requête SQL
		$sql = "
			SELECT
				user.*
			FROM
				travelagency.user
			WHERE
				user.login = :login
			;
		";
		$query = $connection->prepare($sql);
		$query->execute([
			'login' => $data['login']
		]);

		/*
			récupération du résultat
				fetch: récupération d'un seul résultat
				fetchAll: récupération de plusieurs résultats
		*/
		$result = $query->fetch();
		//echo '<pre>'; var_dump($result) ; echo '</pre>';

		// si l'identifiant de l'utilisateur n'existe pas
		if(!$result){
			return false;
		}

		// vérification du mot de passe
		// $data stocke la saisie du formulaire / result stocke le contenu de la table user
		if(password_verify($data['password'], $result['password'])){
			return true;
		}

		// retour par défaut
		return false;
	}

	// récupérer le rôle de l'utilisateur par son identifiant
	public function getRoleByLogin(string $login):array
	{
		// connexion
		$connection = Database::connect();

		// requête SQL
		$sql = "
			SELECT
				user.login,
				role.name
					AS role
			FROM
				travelagency.user
			JOIN
				travelagency.role
			ON
				user.role_id = role.id
			WHERE
				user.login = :login
			;
		";
		$query = $connection->prepare($sql);
		$query->execute([
			'login' => $login
		]);
		$result = $query->fetch();

		// retour du résultat
		return $result;
	}
}