<?php

/*
	App : espace de noms défini dans composer.json
	Core : nom du dossier situé dans le dossier "src"
*/

namespace App\Core;

class Router
{
	// le but est de trouver le contrôleur et la méthode reliés à la route (URL)
	public function getRoute():array
	{
		// récupération de la route (URL)
		$url = $_SERVER['REQUEST_URI'];

		// séparer l'URL à partir du / pour récupérer les informations contenues dans l'URL (contrôleur / méthode / paramètres)
		$urlInfos = explode('/', $url);

		// supprimer le premier indice qui précède le premier /
		// shift : supprimer le premier indice d'un array
		array_shift($urlInfos);

		// tableau de retour
		$result = [];

		// si le contrôleur n'est pas spécifié dans l'URL, le contrôleur "homepage" sera le contrôleur par défaut
		$result['controller'] = empty($urlInfos[0]) ? 'homepage' : $urlInfos[0];

		// si la méthode n'est pas spécifiée dans l'URL, la méthode "index" sera la méthode par défaut
		$result['method'] = !isset($urlInfos[1]) ? 'index' : $urlInfos[1];

		// splice : supprimer une portion d'un tableau
		$result['params'] = array_splice($urlInfos, 2);

		// retour du résultat
		return $result;

		//echo '<pre>'; var_dump($url, $urlInfos, $result) ; echo '</pre>';
	}
}