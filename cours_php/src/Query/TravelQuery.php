<?php

namespace App\Query;

use App\Core\Database;
use App\Query\PeriodQuery;

class TravelQuery
{
	// récupération de toute la table
	public function getAll():array
	{
		// connexion à la base de données
		$connection = Database::connect();

		// requête SQL
		$sql = "
			SELECT
				travel.*
			FROM
				travelagency.travel
			;
		";
		$query = $connection->prepare($sql);
		$query->execute();

		// récupération de plusieurs résultats
		$results = $query->fetchAll();

		// retour des résultats
		return $results;
	}

	// recupération de toute la table avec les tables liées
	public function getAllWithJoins():array
	{
		// récupération de toute la table
		$results = $this->getAll();

		// classes de requêtes des tables jointes
		$periodQuery = new PeriodQuery();

		// ajout des données contenues dans les tables liées
		foreach($results as $key => $result){
			$results[$key]['periods'] = $periodQuery->getResultsWithTravelId($result['id']);
		}

		// retour des résultats
		return $results;
	}

	// récupération de toute la table avec le prix le plus bas
	public function getAllWithMinPrice():array
	{
		// connexion à la base de données
		$connection = Database::connect();

		// requête SQL
		$sql = "
			SELECT
				travel.*,
				MIN(period.price)
					AS minPrice
			FROM
				travelagency.travel
			JOIN
				travelagency.period
			ON
				period.travel_id = travel.id
			GROUP BY
				travel.id
			;
		";
		$query = $connection->prepare($sql);
		$query->execute();

		// récupération de plusieurs résultats
		$results = $query->fetchAll();

		// retour des résultats
		return $results;
	}

	// récupération d'un enregistrement de la table par son id
	public function get(int $id):array
	{
		// connexion à la base de données
		$connection = Database::connect();

		// requête SQL
		$sql = "
			SELECT
				travel.*
			FROM
				travelagency.travel
			WHERE
				travel.id = :id
			;
		";
		$query = $connection->prepare($sql);
		$query->execute([
			'id' => $id
		]);

		// récupération d'un résultat
		$result = $query->fetch();

		// retour du résultat
		return $result;
	}

	// récupération d'un enregistrement de la table par son id avec les tables liées
	public function getWithJoins(int $id):array{
		// récupération d'un enregistrement de la table
		$result = $this->get($id);

		// classes de requêtes des tables jointes
		$periodQuery = new PeriodQuery();

		// ajout des données contenues dans les tables liées
		$result['periods'] = $periodQuery->getResultsWithTravelId($id);
		
		// retour du résultat
		return $result;

	}

	// insertion/modification
	public function process(array $data = []):void
	{
		// connexion à la base de données
		$connection = Database::connect();

		// requête SQL
		// si l'id est définie : requête de modification
		// si l'id n'est pas définie : requête d'insertion
		$sql = empty($data['id']) ? "
			INSERT INTO
				travelagency.travel
			VALUE
				(:id, :name, :description, :image, :steps)
			;
		" : "
			UPDATE
				travelagency.travel
			SET
				travel.id = :id,
				travel.name = :name,
				travel.description = :description,
				travel.image = :image,
				travel.steps = :steps
			WHERE
				travel.id = :id
			;
		";
		$query = $connection->prepare($sql);
		$query->execute([
			'id' => $data['id'],
			'name' => $data['name'],
			'description' => $data['description'],
			'image' => $data['image'],
			'steps' => $data['steps'],
		]);
	}

	// suppression
	public function delete(int $id):void
	{
		// connexion à la base de données
		$connection = Database::connect();

		// requête SQL
		$sql = "
			DELETE FROM
				travelagency.travel
			WHERE
				travel.id = :id
			;
		";
		$query = $connection->prepare($sql);
		$query->execute([
			'id' => $id
		]);
	}
}