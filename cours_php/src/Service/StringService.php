<?php

namespace App\Service;

class StringService
{
	// générer une chaîne de caractères aléatoire
	// static permet d'accèder à un membre (propriétés et méthodes) de la classe sans instnaciation d'un objet
	static public function generateRandom(int $length = 32):string
	{
		/*
			random_bytes : générer des octets aléatoires
			bin2hex : convertir en hexadécimale les octets
		*/
		$bytes = random_bytes($length / 2);
		$result = bin2hex($bytes);

		// retour du résultat
		return $result;
	}
}