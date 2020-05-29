<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Query\TravelQuery;

class Homepage extends AbstractController
{
	// la méthode index est la méthode par défaut définie dans le routeur
	// les paramètres contenus dans l'URL sont envoyés par le contrôleur frontal (public/index.php)
	// void : pas de return; la méthode ne renvoie aucune données
	public function index(array $urlParams = []):void
	{
		/*
			structuration des vues
				- dossier "templates"
				- le contrôleur devient un dossier
				- la méthode devient un fichier
		*/

		// récupération des voyages
		$query = new TravelQuery();
		$travels = $query->getAllWithMinPrice();
		//echo '<pre>'; var_dump($travels) ; echo '</pre>'; exit;

		// appel de la vue située dans le dossier "templates"
		$this->render('homepage/index', [
			'travels' => $travels
		]);
	}
}