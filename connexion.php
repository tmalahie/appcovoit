<?php
include('init.php');
$idsIncorrects = false;
if (isset($_POST['login']) && isset($_POST['code'])) {
	$idsCorrects = $bdd->prepare('SELECT id FROM `eleves` WHERE login=? AND code=?');
	$idsCorrects->execute(Array($_POST['login'],$_POST['code']));
	if ($idUtilisateur = $idsCorrects->fetch()) {
		$_SESSION['id'] = $idUtilisateur['id'];
		header('location: index.php');
	}
	else
		$idsIncorrects = true;
}
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
		<h1>Connexion</h1>
		<?php
		if ($idsIncorrects)
			echo '<p class="echec">Login ou mot de passe incorrect.</p>';
		?>
		<form method="post" action="connexion.php">
		Login : <input type="text" name="login" /><br />
		Mot de passe : <input type="password" name="code" /><br />
		<input type="submit" value="Connexion" />
		</form>
		</div>
	</body>
</html>