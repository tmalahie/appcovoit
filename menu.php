<div id="menu">
	<a href="index.php">Accueil</a>
	<a href="annonces.php">Annonces</a>
	<?php
	if (!$infoUser) {
		?>
		<a href="inscription.php">Inscription</a>
		<?php
	}
	else {
	?>
		<a href="compte.php">Mon compte</a>
	<?php
	}
	?>
</div>