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
	un voyage
</h1>

<!--
	IMPORTANT : définir obligatoirement l'attribut enctype="multipart/form-data" sur <form> lorsqu'il y a un transfert de fichier
-->
<form method="post" enctype="multipart/form-data">
	<p>
		<label>Nom :</label>
		<!-- maxlength est défini sur 200 caractères en accord avec la colonne name de la table mysql -->
		<input type="text" name="name" maxlength="200" value="<?= $values['name']; ?>">
	</p>
	<p>
		<label>Description :</label><br>
		<textarea name="description"><?= $values['description'];?></textarea>
	</p>
	<p>
		<label>Image :</label>
		<!-- un champ de type file ne possède d'attribut value; un champ file ne peut être prérempli -->
		<!-- attribut required permet de bloquer l'envoi du formulaire tant que le champ n'est pas rempli -->
		<!-- attribut required est utilisé lors d'un ajout mais pas lors d'une modification -->
		<input type="file" name="image" <?= empty($values['id']) ? 'required' : null ;?>>
	</p>
	<div class="steps">
		<label>Étapes :</label> <button class="step-add">+</button>
		<ol class="steps-list">
			<?php
				// afficher les étapes
				$html = '';

				// boucler sur les étapes
				foreach($values['steps'] as $step){
					$html .= "
						<li>
							<input type='text' name='steps[]' value='$step'><button class='step-delete'>-</button>
						</li>
					";
				}

				// afficher le html
				echo $html;
			?>
			<!--li>
				utiliser un array comme name du champ de saisie pour récupérer plusieurs saisies
				<input type="text" name="steps[]"><button class="step-delete">-</button>
			</li-->
		</ol>
	</div>
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
	<a href="/admintravel">Administration des voyages</a>
</p>
<p>
	<a href="/admin">Administration</a>
</p>

<!-- inclusion du JavaScript -->
<script src="/js/adminTravelForm.js"></script>

<?php

	// inclusion du footer.php (templates/_inc)
	require_once '../templates/_inc/footer.php';

?>