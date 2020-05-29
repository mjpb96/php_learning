/*
	sélection des éléments HTML
		document.querySelector(sélecteur CSS) : sélection d'un seul élément
		document.querySelectorAll(sélecteur CSS) : sélection de plusieurs éléments
	
		let : création d'une variable
		console.log : débogage dans la console
*/
let stepAdd = document.querySelector('.step-add');
let stepsList = document.querySelector('.steps-list');
let stepDelete = document.querySelectorAll('.step-delete');

// gestionnaires d'événement : fonction liée à un événement
// tous les gestionnaires d'événement recoivent automatiquement en paramètre un objet de type Event
let stepAddClick = function(event){
	// preventDefault : fonction liée à l'événement, permet de désactiver le comportement par défaut d'un élément
	event.preventDefault();
	
	/*
		createElement : créer un élément HTML (balise)
		setAttribute : ajouter/modifier un attribut HTML
		appendChild : ajouter un élément HTML enfant à un élément HTML parent, et l'afficher
		innerHTML / innerText = ajout du html ou du texte à l'intérieur d'une balise
	*/
	let li = document.createElement('li');
	let input = document.createElement('input');
	let button = document.createElement('button');

	// ajout des attributs HTML sur les éléments
	input.setAttribute('type', 'text');
	input.setAttribute('name', 'steps[]');

	button.setAttribute('class', 'step-delete');
	button.innerText = '-';

	// événement sur le bouton de suppression
	button.addEventListener('click', stepDeleteClick);

	// affichage des éléments dans leur parent
	// la balise li possède comme enfants input et button 
	li.appendChild(input);
	li.appendChild(button);

	// la balise li est ajoutée à la liste
	stepsList.appendChild(li);

	// focaliser automatiquement le curseur dans le champ de saisi créé
	input.focus();
}

let stepDeleteClick = function(event){
	// preventDefault : fonction liée à l'événement, permet de désactiver le comportement par défaut d'un élément
	event.preventDefault();

	/*
		supprimer la balise li qui est parente du bouton -
		propriété target de l'événement : permet de cibler l'élément sur lequel l'événement a été déclenché
		parentNode permet de cibler la balise parente d'un élément
			event.target > button
			event.target.parentNode > li
		remove : suppression d'un élément HML
	*/
	event.target.parentNode.remove();
};

/*
	addEventListener(événement, gestionnaire d'événement) : ajout d'un événement sur un élément HTML
	liste des événements JS : https://developer.mozilla.org/fr/docs/Web/Events
*/

stepAdd.addEventListener('click', stepAddClick);

// si des boutons de suppression existent, ajout de l'événement
if(stepDelete){
	// boucler sur les boutons de suppression
	// forEach prend une fonction en paramètre
	// element est un paramètre qui récupère chaque élément HTML sélectionné par querySelector
	// fonction raccourcie : function(param) { … } devient param => …
	stepDelete.forEach( element => element.addEventListener('click', stepDeleteClick) );
}