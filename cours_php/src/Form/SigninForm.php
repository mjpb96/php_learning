<?php

namespace App\Form;

use App\Form\AbstractForm;

class SigninForm extends AbstractForm
{
	/*
		une classe de formulaire doit:
			- vérifier la validité du formulaire
			- récupérer la saisie précédente en cas d'erreur et réinjecter la saisie dans les champs
			- afficher les messages d'erreur
	*/

	// stocker la saisie de chaque champ
	protected array $values = [
		'login' => null,
		'password' => null,
	];

	// vérifier la validité de chaque champs de saisie
	protected function check():bool
	{
		// si tous les champs sont remplis
		// login et password sont le name des champs de saisie
		if(!empty($_POST['login']) && !empty($_POST['password'])){
			// récupérer la saisie puis la stocker dans la propriété values
			$this->values['login'] = $_POST['login'];
			$this->values['password'] = $_POST['password'];

			// le formulaire est valide
			return true;
		} else {
			// récupérer la saisie puis la stocker dans la propriété values, sinon on crée un message d'erreur
			!empty($_POST['login']) ? $this->values['login'] = $_POST['login'] : array_push($this->messages, 'Identifiant obligatoire');
			!empty($_POST['password']) ? $this->values['password'] = $_POST['password'] : array_push($this->messages, 'Mot de passe obligatoire');

			// le formulaire est invalide
			return false;
		}
	}
}