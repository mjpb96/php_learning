<?php

	/*
		les variables values et messages sont les clés du tableau associatif envoyé par le contrôleur à la vue
		les clés ont été transformées en variable par la fonction extract de la méthode render de AbstractController
	*/
	//echo '<pre>'; var_dump($values, $messages) ; echo '</pre>';

	// inclusion du header.php / nav.php (templates/_inc)
	require_once '../templates/_inc/header.php';
	require_once '../templates/_inc/nav.php';

?>

<h1>S'enregistrer</h1>

<?php

	// afficher la notification stockée en session
	//echo !empty($sessionNotice) ? "<p class='alert'>$sessionNotice</p>" : null;
	require_once '../templates/_inc/sessionNotice.php';

?>

<!--
	obligations:
		attribuer un attribut name unique dans tous les champs de saisie du formulaire
		définir la méthode d'envoi POST
		si le formulaire contient un champ fichier, ajouter l'attribut enctype="multipart/form-data"
		attribuer un name au bouton de validation
-->
<form method="post">
	<p>
		<label>Identifiant : </label>
		<input type="text" name="login" value="<?= $values['login']; ?>">
	</p>
	<p>
		<label>Mot de passe : </label>
		<input type="password" name="password" value="<?= $values['password']; ?>">
	</p>
	<p>
		<input type="submit" name="submit" value="Valider" class="btn btn-add">
	</p>
</form>

<ul>
	<?php
		// affichage des messages du formulaire
		$html = '';

		foreach ($messages as $message) {
			$html .= "<li class='form-error'>$message</li>";
		}

		echo $html;
	?>
</ul>

<?php

	// inclusion du footer.php (templates/_inc)
	require_once '../templates/_inc/footer.php';

?>