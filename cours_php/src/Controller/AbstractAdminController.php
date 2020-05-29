<?php

namespace App\Controller;

use App\Controller\AbstractController;

abstract class AbstractAdminController extends AbstractController{

	public function __construct()
	{
		// vérifier l'identifiant et le rôle de l'utilisateur stocké en session
		// informations créées lors de la connexion (Login) 
		if(!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin'){
			// notification à l'utilisateur
			$_SESSION['notice'] = "Accès refusé";

			// définir une notification d'erreur
			$_SESSION['notice_error'] = true;

			// redirection vers le formulaire de connexion
			header('Location: /login');
		}
	}

}