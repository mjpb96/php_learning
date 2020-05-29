<?php

namespace App\Query;

use App\Core\Database;

class PeriodQuery
{
	// récupération de toute la table
	public function getAll():array
	{
		// connexion à la base de données
		$connection = Database::connect();

		// requête SQL
		$sql = "
			SELECT
				period.*,
				travel.name
					AS travel_id
			FROM
				travelagency.period
			JOIN
				travelagency.travel
			ON
				travel.id = period.travel_id
			;
		";
		$query = $connection->prepare($sql);
		$query->execute();

		// récupération de plusieurs résultats
		$results = $query->fetchAll();

		// retour des résultats
		return $results;
	}

	// récupération selon un identifiant parent
	public function getResultsWithTravelId(int $id):array
	{
		// connexion à la base de données
		$connection = Database::connect();

		// requête SQL
		$sql = "
			SELECT
				period.*
			FROM
				travelagency.period
			JOIN
				travelagency.travel
			ON
				period.travel_id = travel.id
			WHERE
				travel.id = :id
			;
		";
		$query = $connection->prepare($sql);
		$query->execute([
			'id' => $id
		]);

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
				period.*
			FROM
				travelagency.period
			WHERE
				period.id = :id
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
				travelagency.period
			VALUE
				(:id, :start, :days, :price, :travel_id)
			;
		" : "
			UPDATE
				travelagency.period
			SET
				period.id = :id,
				period.start = :start,
				period.days = :days,
				period.price = :price,
				period.travel_id = :travel_id
			WHERE
				period.id = :id
			;
		";
		$query = $connection->prepare($sql);
		$query->execute([
			'id' => $data['id'],
			'start' => $data['start'],
			'days' => $data['days'],
			'price' => $data['price'],
			'travel_id' => $data['travel_id']
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
				travelagency.period
			WHERE
				period.id = :id
			;
		";
		$query = $connection->prepare($sql);
		$query->execute([
			'id' => $id
		]);
	}
}