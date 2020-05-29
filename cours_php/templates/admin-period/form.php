<?php

	// inclusion du header.php / nav.php (templates/_inc)
	require_once '../templates/_inc/header.php';
	require_once '../templates/_inc/nav.php';

?>

<!--
	modifier le titre
		si l'id est vide, ajout
		si l'id est rempli, modifier
-->
<h1>
	<?= empty($values['id']) ? 'Ajouter' : 'Modifier'; ?>
	une période de voyage
</h1>

<form method="post">
	<p>
		<label>Départ :</label>
		<input type="date" name="start" value="<?= $values['start']; ?>">
	</p>
	<p>
		<label>Nombre de jours :</label>
		<input type="number" name="days" min="1" max="99" value="<?= $values['days']; ?>">
	</p>
	<p>
		<label>Prix :</label>
		<input type="number" name="price" min="1" max="99999" value="<?= $values['price']; ?>">
	</p>
	<p>
		<label>Voyage :</label>
		<select name="travel_id">
			<option value=""></option>
			<?php
				// $travels est la liste des voyages envoyée par le contrôleur à la vue
				$html = '';

				foreach ($travels as $travel) {
					$html .= "<option value='{$travel['id']}'";
					$html .= $travel['id'] === $values['travel_id'] ? ' selected' : null;
					$html .= ">{$travel['name']}";
					$html .= "</option>";
				}

				echo $html;
			?>
		</select>
	</p>
	<p>
		<!-- la colonne id de la table mysql est un champ caché -->
		<input type="hidden" name="id" value="<?= $values['id'];?>">

		<input type="submit" name="submit" value="Valider" class="btn btn-add">
	</p>
</form>

<?php

	// messages du formulaire
	require_once '../templates/_inc/formMessages.php';

?>

<hr>
<p>
	<a href="/adminperiod">Administration des périodes de voyage</a>
</p>
<p>
	<a href="/admin">Administration</a>
</p>

<?php

	// inclusion du footer.php (templates/_inc)
	require_once '../templates/_inc/footer.php';

?>