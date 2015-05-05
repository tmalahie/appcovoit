<?php
include('init.php');
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>App Covoit</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="styles/main.css" />
		<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" /> <!-- Image dans la barre d'adresse -->
	</head>
	<body>
		<?php
		include('menu.php');
		?>
		<div id="container">
		<p>Bienvenue sur le site de covoiturage de Centrale Lyon.</p>
		<?php
		if ($infoUser) {
			?>
			<p>Vous êtes connecté en tant que <strong><?php echo $infoUser['prenom']; ?> <?php echo $infoUser['nom']; ?></strong>.</p>
			<p><a href="deconnexion.php">Déconnexion</a></p>
			<?php
		}
		else {
			?>
			<p>Vous n'êtes pas connecté. Connectez-vous ici :<br />
				<form method="post" action="connexion.php">
				Login : <input type="text" name="login" /><br />
				Mot de passe : <input type="password" name="code" /><br />
				<input type="submit" value="Connexion" />
				</form>
			</p>
			<p>Pas encore inscrit ? Cliquez <a href="inscription.php">ici</a>.</p>
			<?php
		}
		?>
		</div>
	</body>
</html>