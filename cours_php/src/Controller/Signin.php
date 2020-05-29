<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Form\SigninForm;
use App\Query\UserQuery;

class Signin extends AbstractController
{
	public function index(array $urlParams = []):void
	{
		// récupération d'une notification stockée en session
		// par exemple la notification créée dans AbstractAdminController
		$sessionNotice = isset($_SESSION['notice']) ? $_SESSION['notice'] : null;
		$sessionNoticeError = isset($_SESSION['notice_error']) ? $_SESSION['notice_error'] : null;

		// supprimer la notification stockée en session pour un affichage unique
		unset($_SESSION['notice']);
		unset($_SESSION['notice_error']);

		// instanciation du formulaire
		$form = new SigninForm();
		//echo '<pre>'; var_dump($form->verify(), $form->getValues(), $form->getMessages()) ; echo '</pre>';

		// si le formulaire est valide
		if($form->verify()){
			//echo '<pre>'; var_dump('formulaire valide') ; echo '</pre>';

			// créer un utilisateur
			$userQuery = new UserQuery();

			try{
				// $form->getValues permet de récupérer la saisie du formulaire 
				$userQuery->create($form->getValues());

				// notification de confirmation
				$_SESSION['notice'] = 'Compte créé';

				// redirection
				header('Location: /login');

			} catch (\PDOException $exception){
				//echo '<pre>'; var_dump($exception->errorInfo[2], $exception->getMessage()); echo '</pre>'; exit;
				$_SESSION['notice'] = $exception->errorInfo[2];

				// définir une notification d'erreur
				$_SESSION['notice_error'] = true;

				// redirection
				header('Location: /signin');
			}
		}

		// appel de la vue située dans le dossier "templates"
		// la saisie stockée dans LoginForm, avec la propriété values, est envoyée à la vue
		// les messages stockés dans LoginForm, avec la propriété messages, sont envoyés à la vue
		$this->render('signin/index', [
			'values' => $form->getValues(),
			'messages' => $form->getMessages(),
			'sessionNotice' => $sessionNotice,
			'sessionNoticeError' => $sessionNoticeError,
		]);
	}
}