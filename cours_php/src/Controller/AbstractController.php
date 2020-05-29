<?php

namespace App\Controller;

abstract class AbstractController
{
	// méthode pour afficher les vues et envoyer des données à la vue
	protected function render(string $view, array $data = []):void
	{
		// extract permet de créer une variable à partir des clés d'un tableau associatif
		// par exemple : le array [ 'key' => 'value' ] devient $key = 'value';
		extract($data);

		// afficher la vue
		require_once "../templates/$view.php";
	}
}