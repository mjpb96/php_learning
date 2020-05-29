<?php

	// inclusion du header.php / nav.php (templates/_inc)
	require_once '../templates/_inc/header.php';
	require_once '../templates/_inc/nav.php';

?>

<!--
	CRUD : Create Read Update Delete
		espace d'administration d'une table
-->

<h1>Administration des périodes de voyages</h1>

<?php

	// afficher la notification stockée en session
	//echo !empty($sessionNotice) ? "<p class='alert'>$sessionNotice</p>" : null;
	require_once '../templates/_inc/sessionNotice.php';

?>

<p>
	<!-- dans le contrôleur AdminPeriod, créer la méthode form -->
	<a href="/adminperiod/form" class="btn btn-add">Ajouter</a>
</p>

<table>
	<tr>
		<th>Départ</th>
		<th>Nombre de jours</th>
		<th>Prix</th>
		<th>Voyage</th>
		<th></th>
	</tr>
	<?php
		// html
		$html = '';

		// boucler sur les résultats de la requête envoyés par le contrôleur dans la clé results
		//foreach($results as $key => $travel){
		foreach($results as $travel){
			// .= affectation et concaténation > permet de conserver la valeur précédente de la variable et de concaténer de nouvelles valeurs
			$html .= "
				<tr>
					<td>{$travel['start']}</td>
					<td>{$travel['days']}</td>
					<td>{$travel['price']} €</td>
					<td>{$travel['travel_id']}</td>
					<td>
						<a href='/adminperiod/form/{$travel['id']}' class='btn btn-update'>Modifier</a>
						<a href='/adminperiod/delete/{$travel['id']}' class='btn btn-delete'>Supprimer</a>
					</td>
				</tr>
			";
		}

		// affichage du html
		echo $html;
	?>
</table>

<hr>
<p>
	<a href="/admin">Administration</a>
</p>

<?php

	// inclusion du footer.php (templates/_inc)
	require_once '../templates/_inc/footer.php';

?>