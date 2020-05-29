<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Query\TravelQuery;

class Travel extends AbstractController
{
	// affichage des détails d'un voyage
	public function details(array $urlParams = []):void
	{
		// récupération de l'identifiant du voyage dans l'URL
		$id = $urlParams[0];

		// récupération des voyages
		$query = new TravelQuery();
		$travel = $query->getWithJoins($id);
		//echo '<pre>'; var_dump($travel) ; echo '</pre>'; //exit;

		// affichage de la vue
		$this->render('travel/details', [
			'travel' => $travel
			
		]);
	}
}