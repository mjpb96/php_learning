<nav class="site-nav">
	<a href="/">Accueil</a>
	<?= isset($_SESSION['user']) ? '<a href="/logout">Déconnexion</a>' : '<a href="/login">Connexion</a> <a href="/signin">S\'enregistrer</a>' ;?>
	<a href="/admin">Administration</a>
</nav>