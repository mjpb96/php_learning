<?php

	// inclusion du header.php / nav.php (templates/_inc)
	require_once '../templates/_inc/header.php';
	require_once '../templates/_inc/nav.php';

?>

<h1>Accueil</h1>

<div class="travels">
	<?php
		// html
		$html = '';

		// boucle sur les résultats
		foreach($travels as $travel){
			$html .= "
				<div class='travel'>
					<a href='/travel/details/{$travel['id']}'>
						<div class='travel-image'>
							<img src='/img/{$travel['image']}' alt='{$travel['name']}'>
						</div>
						<h2 class='travel-name'>{$travel['name']}</h2>
						<p class='travel-price'>A partir de {$travel['minPrice']}€</p>
					</a>
				</div>
			";
		}

		// affichage de html
		echo $html;
	?>
</div>

<?php

	// inclusion du footer.php (templates/_inc)
	require_once '../templates/_inc/footer.php';

?>