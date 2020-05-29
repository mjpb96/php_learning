<?php

/*
	public/index.php : contrôleur frontal, toutes les URL passent par lui
	lancer le serveur PHP en ciblant le dossier public : php -S localhost:8000 -t public
*/

// démarrer la session
session_start();

// auto-chargement des classes avec composer
require_once '../vendor/autoload.php';

// importation des classes
use App\Core\Router;

// appel du routeur
//$router = new App\Core\Router(); sans use
$router = new Router();

// récupération des informations du routeur
$routerInfos = $router->getRoute();

// nom du contrôleur
//$controllerName = "App\\Controller\\{$routerInfos['controller']}";
$controllerName = 'App\Controller\\' . $routerInfos['controller'];

// instanciation du contrôleur à partir du nom du contrôleur
$controller = new $controllerName();

// appel de la méthode en envoyant les paramètres existants dans l'URL
// {} : interpolation de variable > permet de forcer l'interprétation d'une variable
$controller->{$routerInfos['method']}( $routerInfos['params'] );

//echo '<pre>'; var_dump($routerInfos, $controllerName) ; echo '</pre>';