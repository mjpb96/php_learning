<?php

namespace App\Controller;

use App\Controller\AbstractAdminController;

/*
	pour les contrôleurs de l'espace d'administration, utiliser AbstractAdminController
	pour les contrôleurs de l'espace public, utiliser AbstractController
*/
class Admin extends AbstractAdminController
{
	public function index(array $urlParams = []):void
	{
		$this->render('admin/index');
	}
}