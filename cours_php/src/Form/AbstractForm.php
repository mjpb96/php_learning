<?php

namespace App\Form;

abstract class AbstractForm
{
	// messages du formulaire
	protected array $messages = [];

	// vérifier la validité du formulaire
	public function verify():bool
	{
		// si le formulaire a été validé
		// ne pas oublier d'attribuer un name au bouton de validation
		if(isset($_POST['submit'])){
			// vérifier la validité de chaque champs de saisie
			return $this->check();
		} else {
			// si le formulaire n'a jamais été validé
			return false;
		}
	}

	// getters / setters
	public function getValues():array
	{
		return $this->values;
	}

	public function setValues(array $values):void
	{
		$this->values = $values;
	}

	public function getMessages():array
	{
		return $this->messages;
	}
}