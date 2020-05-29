<?php

namespace App\Form;

use App\Form\AbstractForm;

class PeriodForm extends AbstractForm
{
	/*
		une classe de formulaire doit:
			- vérifier la validité du formulaire
			- récupérer la saisie précédente en cas d'erreur et réinjecter la saisie dans les champs
			- afficher les messages d'erreur
	*/

	// stocker la saisie de chaque champ
	protected array $values = [
		'id' => null,
		'start' => null,
		'days' => null,
		'price' => null,
		'travel_id' => null,
	];

	// vérifier la validité de chaque champs de saisie
	protected function check():bool
	{
		// si tous les champs sont remplis
		if(!empty($_POST['start']) && !empty($_POST['days']) && !empty($_POST['price']) && !empty($_POST['travel_id'])){
			// récupérer l'identifiant, si l'identifiant est vide, la valeur null doit être définie pour être utiliser dans la requête
			$this->values['id'] = !empty($_POST['id']) ? $_POST['id'] : null;

			// récupérer la saisie puis la stocker dans la propriété values
			$this->values['start'] = $_POST['start'];
			$this->values['days'] = $_POST['days'];
			$this->values['price'] = $_POST['price'];
			$this->values['travel_id'] = $_POST['travel_id'];

			// le formulaire est valide
			return true;
		} else {
			// récupérer l'identifiant, si l'identifiant est vide, la valeur null doit être définie pour être utiliser dans la requête
			!empty($_POST['id']) ? $this->values['id'] = $_POST['id'] : null;

			// récupérer la saisie puis la stocker dans la propriété values, sinon on crée un message d'erreur
			!empty($_POST['start']) ? $this->values['start'] = $_POST['start'] : array_push($this->messages, 'Départ obligatoire');
			!empty($_POST['days']) ? $this->values['days'] = $_POST['days'] : array_push($this->messages, 'Nombre de jours obligatoire');
			!empty($_POST['price']) ? $this->values['price'] = $_POST['price'] : array_push($this->messages, 'Prix obligatoire');
			!empty($_POST['travel_id']) ? $this->values['travel_id'] = $_POST['travel_id'] : array_push($this->messages, 'Voyage obligatoire');

			// le formulaire est invalide
			return false;
		}
	}
}