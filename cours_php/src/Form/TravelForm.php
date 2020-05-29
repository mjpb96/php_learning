<?php

namespace App\Form;

use App\Form\AbstractForm;

class TravelForm extends AbstractForm
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
		'name' => null,
		'description' => null,
		'image' => null,
		'steps' => [],
	];

	// vérifier la validité de chaque champs de saisie
	protected function check():bool
	{
		//echo '<pre>'; var_dump($_FILES['image']); echo '</pre>'; exit;
		// si tous les champs sont remplis
		/*
			IMPORTANT pour les champs de type file, utiliser $_FILES['name html du champ']
				name: nom d'origine du fichier sélectionné
				type: type MIME du fichier > information non fiable, se base uniquement sur l'extension du fichier
				tmp_name: fichier renommé par le serveur durant le transfert
				error : code erreur : https://www.php.net/manual/fr/features.file-upload.errors.php
					0 : un fichier a été sélectionné
					4 : un fichier n'a pas été sélectionné
				size: poids du fichier en octets (1024o > 1ko)
			
			UPLOAD_ERR_NO_FILE équivaut à l'erreur 4
		*/
		if(!empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['steps'])){
			// récupérer l'identifiant, si l'identifiant est vide, la valeur null doit être définie pour être utiliser dans la requête
			$this->values['id'] = !empty($_POST['id']) ? $_POST['id'] : null;

			// récupérer la saisie puis la stocker dans la propriété values
			$this->values['name'] = $_POST['name'];
			$this->values['description'] = $_POST['description'];
			$this->values['steps'] = $_POST['steps'];

			// récupérer le champ image
			$this->values['image'] = $_FILES['image'];

			// le formulaire est valide
			return true;
		} else {
			// récupérer l'identifiant, si l'identifiant est vide, la valeur null doit être définie pour être utiliser dans la requête
			!empty($_POST['id']) ? $this->values['id'] = $_POST['id'] : null;

			// récupérer la saisie puis la stocker dans la propriété values, sinon on crée un message d'erreur
			!empty($_POST['name']) ? $this->values['name'] = $_POST['name'] : array_push($this->messages, 'Nom obligatoire');
			!empty($_POST['description']) ? $this->values['description'] = $_POST['description'] : array_push($this->messages, 'Description obligatoire');
			!empty($_POST['steps']) ? $this->values['steps'] = $_POST['steps'] : array_push($this->messages, 'Étapes obligatoires');

			// récupérer le champ image
			$_FILES['image']['error'] !== \UPLOAD_ERR_NO_FILE ? $this->values['image'] = $_FILES['image'] : array_push($this->messages, 'Image obligatoire');

			// le formulaire est invalide
			return false;
		}
	}
}