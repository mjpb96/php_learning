<?php
	// tester si la notification est une erreur, ajout d'une classe CSS
	$error = isset($sessionNoticeError) ? 'alert-error' : null;

	// afficher la notification stockée en session
	echo !empty($sessionNotice) ? "<p class='alert $error'>$sessionNotice</p>" : null;