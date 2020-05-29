<?php

	// inclusion du header.php / nav.php (templates/_inc)
	require_once '../templates/_inc/header.php';
	require_once '../templates/_inc/nav.php';

?>

<h1 class="travel-details-name"><?= $travel['name'];?></h1>
<p class="travel-details-image">
	<img src="/img/<?= $travel['image'];?>" alt="<?= $travel['image'];?>">
</p>
<p><?= $travel['description'];?></p>

<h2>Etapes</h2>
<ol class="travel-details-steps">
<?php
	//html
	$html = '';

	// boucler sur les étapes
	// json decode permet de convertir du JSON en PHP
	foreach(json_decode($travel['steps']) as $step){
		$html .= "<li>$step</li>";
	}

	// affichage du html
	echo $html;
?>
</ol>

<h2>Périodes</h2>
<?php
	// html
	$html = '';

	// boucler sur les périodes
	foreach($travel['periods'] as $period){
		/*
			formater la date : DateTime classe PHP dédiée aux dates/heures
			méthode format : permet de formater la date avec des caractères de remplacement
				Y : année sur 4 chiffres
				m : mois
				d : jour
			DateInterval est la classe PHP dédiée aux périodes temporelles
			méthode add : permet d'ajouter une période (jours, heures, année...) à une date, avec des caractères spéciaux
				P : période
				D : Jours
			exemple : DateInterval('P50D') Ajout de 50 jours à la période
		*/
		$start = new \DateTime($period['start']);

		$end = new \DateTime($period['start']);
		$interval = new \DateInterval("P{$period['days']}D");
		$endDate = $end->add($interval);

		$html .= "
			<div class='travel-details-period'>
				 <p>Date de départ : {$start->format('d/m/Y')}</p>
				 <p>Date de fin de voyage : {$endDate->format('d/m/Y')}</p>
				 <p>Prix : {$period['price']} € </p>
			</div>
		";
	}

	// affichage du html
	echo $html;

?>

<!-- import de la bibliothèque JS -->
<script src="/js/scrollreveal.js"></script> 

<!-- initialisation de la bibliothèque JS -->
<script>
	/* 
		cibler un sélecteur CSS
		{} : représente un objet JS 
		{
			key: 'string',
			key2: 5,
			key3: true
		}
	
		
	*/
	ScrollReveal().reveal('.travel-details-period, .travel-details-name, .travel-details-steps', {
    /*rotate: {
		x: 45,
		y: 45,
		z: 40
	}*/
	opacity: 0,
	distance: '2rem',
	origin: 'top',
	});

	ScrollReveal().reveal(' travel-details-image' , {
		delay: 500,
		scale: .9
	})

	ScrollReveal().reveal('h2, p' , {
		delay: 500,
		opacity: 0
	})
</script>

<?php

	// inclusion du footer.php (templates/_inc)
	require_once '../templates/_inc/footer.php';

?>