<?php

namespace App\Controller;

use App\Controller\AbstractAdminController;
use App\Query\TravelQuery;
use App\Query\PeriodQuery;
use App\Form\PeriodForm;

/*
	pour les contrôleurs de l'espace d'administration, utiliser AbstractAdminController
	pour les contrôleurs de l'espace public, utiliser AbstractController
*/
class AdminPeriod extends AbstractAdminController
{
	// lister le contenu de la table
	public function index(array $urlParams = []):void
	{
		// récupération du contenu de la table
		$query = new PeriodQuery();
		$results = $query->getAll();
		//echo '<pre>'; var_dump($results) ; echo '</pre>';

		// récupération d'une notification stockée en session
		// par exemple la notification créée dans AbstractAdminController
		$sessionNotice = isset($_SESSION['notice']) ? $_SESSION['notice'] : null;
		$sessionNoticeError = isset($_SESSION['notice_error']) ? $_SESSION['notice_error'] : null;

		// supprimer la notification stockée en session pour un affichage unique
		unset($_SESSION['notice']);
		unset($_SESSION['notice_error']);

		// affichage de la vue
		$this->render('admin-period/index', [
			'results' => $results,
			'sessionNotice' => $sessionNotice,
			'sessionNoticeError' => $sessionNoticeError,
		]);
	}

	// affichage du formulaire
	public function form(array $urlParams = []):void
	{
		// formulaire
		$form = new PeriodForm();

		// classe de requête
		$query = new PeriodQuery();

		// si l'identifiant est dans l'URL (modification)
		// si le formulaire n'a jamais été envoyé // submit est le name du bouton
		//echo '<pre>'; var_dump($urlParams); echo '</pre>'; exit;
		if(count($urlParams) > 0 && !isset($_POST['submit'])){
			// récupération de l'identifiant dans l'URL
			$id = $urlParams[0];

			// sélection du voyage selon son id dans la base de données
			$result = $query->get($id);
			//echo '<pre>'; var_dump($result); echo '</pre>'; exit;

			// mettre à jour les valeurs (saisie) du formulaire avec la propriété $values de PeriodForm
			$form->setValues($result);
		}

		// si le formulaire est valide
		if($form->verify()){
			//echo '<pre>'; var_dump($form->getValues()) ; echo '</pre>'; exit;
			// récupération de l'erreur mysql si l'insertion/modification n'a pas fonctionné
			try{
				// insertion/modification dans la table
				$query->process($form->getValues());

				// notification de confirmation
				$_SESSION['notice'] = count($urlParams) > 0 ? 'Période de voyage modifiée' : 'Période de voyage ajoutée';

			} catch (\PDOException $exception){
				//echo '<pre>'; var_dump($exception->errorInfo[2], $exception->getMessage()); echo '</pre>'; exit;
				$_SESSION['notice'] = $exception->errorInfo[2];

				// définir une notification d'erreur
				$_SESSION['notice_error'] = true;
			}

			// redirection
			header('Location: /adminperiod');
		}

		// récupération des voyages pour créer une liste déroulante dans le formulaire
		$travelQuery = new TravelQuery();
		$travels = $travelQuery->getAll();

		// affichage de la vue
		// la saisie stockée dans PeriodForm, avec la propriété values, est envoyée à la vue
		// les messages stockés dans PeriodForm, avec la propriété messages, sont envoyés à la vue
		$this->render('admin-period/form', [
			'values' => $form->getValues(),
			'messages' => $form->getMessages(),
			'travels' => $travels,
		]);
	}

	// suppression d'un enregistrement
	public function delete(array $urlParams = []):void
	{
		// requête de suppression
		try{
			// classe de requête
			$query = new PeriodQuery();

			// suppression en récupérant l'id dans l'URL, stocké dans $urlParams
			$query->delete($urlParams[0]);

			// notification de confirmation
			$_SESSION['notice'] = 'Période de voyage supprimée';

		} catch (\PDOException $exception){
			// notification d'erreur
			$_SESSION['notice'] = $exception->errorInfo[2];

			// définir une notification d'erreur
			$_SESSION['notice_error'] = true;
		}

		// redirection
		header('Location: /adminperiod');
	}
}