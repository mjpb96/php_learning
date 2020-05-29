<?php

namespace App\Service;

use App\Service\StringService;

class FileService
{
	// propriété permettant de stocker le nom du fichier
	private string $fileName;

	// récupération du type mime du fichier
	private function getMimeType(string $file):string
	{
		// la classe finfo permet d'inspecter un fichier
		$finfo = new \finfo(\FILEINFO_MIME_TYPE);
		$typeMime = $finfo->file($file);
		$extension = explode('/', $typeMime)[1];

		// retour
		return $extension;
	}

	// nom aléatoire du fichier
	private function generateFileName(string $file):string
	{
		// utilisation de StringService
		$fileName = StringService::generateRandom() . '.' . $this->getMimeType($file);

		// retour
		return $fileName;
	}

	// transfert du fichier
	public function upload(string $file, string $directory):void
	{
		// nom aléatoire du fichier
		$this->fileName = $this->generateFileName($file);
		//echo '<pre>'; var_dump($this->fileName) ; echo '</pre>'; exit;

		// destination
		$destination = "$directory/{$this->fileName}";

		// transfert du fichier
		move_uploaded_file($file, $destination);
	}

	// supprimer un fichier
	public function delete(string $file, string $directory):void
	{
		// unlink : suppression d'un fichier
		unlink("$directory/$file");
	}

	// getter de la propriété fileName pour y accéder à partir d'un contrôleur
	public function getFileName():string
	{
		return $this->fileName;
	}
}