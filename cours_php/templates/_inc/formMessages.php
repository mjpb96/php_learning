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