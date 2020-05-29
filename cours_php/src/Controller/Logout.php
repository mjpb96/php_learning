<?php

namespace App\Controller;

use App\Controller\AbstractController;

class Logout extends AbstractController
{
	public function index(array $urlParams = []):void
	{
		// supprimer l'identifiant et le rôle de utilisateur connecté stockés en session
		unset($_SESSION['user']);
		unset($_SESSION['role']);

		// redirection vers la page d'accueil
		header('Location: /');
	}
}