<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Form\LoginForm;
use App\Query\UserQuery;

class Login extends AbstractController
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
		$form = new LoginForm();
		//echo '<pre>'; var_dump($form->verify(), $form->getValues(), $form->getMessages()) ; echo '</pre>';

		// si le formulaire est valide
		if($form->verify()){
			//echo '<pre>'; var_dump('formulaire valide') ; echo '</pre>';

			// vérifier l'utilisateur
			$userQuery = new UserQuery();
			// echo '<pre>'; var_dump($userQuery->exists($form->getValues())); echo '</pre>';

			// si l'authentification a réussie
			if($userQuery->exists($form->getValues())){
				// vérifier le rôle de l'utilisateur
				$user = $userQuery->getRoleByLogin($form->getValues()['login']);
				//echo '<pre>'; var_dump($user); echo '</pre>'; exit;

				// stocker l'identifiant et le rôle de l'utilisateur connecté en session
				$_SESSION['user'] = $user['login'];
				$_SESSION['role'] = $user['role'];

				// url selon le rôle
				if($user['role'] === 'user'){
					$url = '/';
				} elseif($user['role'] === 'admin') {
					$url = '/admin';
				}

				// redirection
				header("Location: $url");
			}

			// si l'authentification a échoué
			else {
				// notification
				$_SESSION['notice'] = 'Identifiants incorrects';

				// définir une notification d'erreur
				$_SESSION['notice_error'] = true;

				// redirection
				header('Location: /login');
			}

			
		}

		// appel de la vue située dans le dossier "templates"
		// la saisie stockée dans LoginForm, avec la propriété values, est envoyée à la vue
		// les messages stockés dans LoginForm, avec la propriété messages, sont envoyés à la vue
		// la notification stockée en session
		$this->render('login/index', [
			'values' => $form->getValues(),
			'messages' => $form->getMessages(),
			'sessionNotice' => $sessionNotice,
			'sessionNoticeError' => $sessionNoticeError,
		]);
	}
}