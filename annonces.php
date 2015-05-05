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
		$messages = Array(); // Liste des messages d'erreur en cas de pb de saisie du formulaire
		$inscrit = false;
		if (isset($_POST['login']) && isset($_POST['code']) && isset($_POST['confirm']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['surnom']) && isset($_POST['etage']) && isset($_POST['possedeVoiture'])) {
			// Si l'utilisateur a validé le formulaire
			if ($_POST['login'] == '')
				array_push($messages, 'Veuillez entrer votre login.');
			if ($_POST['code'] == '')
				array_push($messages, 'Veuillez entrer votre mot de passe.');
			if ($_POST['confirm'] == '')
				array_push($messages, 'Veuillez retaper votre mot de passe.');
			elseif ($_POST['code'] != $_POST['confirm'])
				array_push($messages, 'Vous avez fait une erreur en retapant votre mot de passe. Veuillez réessayer');
			if ($_POST['nom'] == '')
				array_push($messages, 'Veuillez entrer votre nom.');
			if ($_POST['prenom'] == '')
				array_push($messages, 'Veuillez entrer votre prénom.');
			if ($_POST['etage'] == '')
				array_push($messages, 'Veuillez entrer votre n° d\'étage.');
			$loginExistant = $bdd->prepare('SELECT * FROM `eleves` WHERE login=?');
			$loginExistant->execute(Array($_POST['login']));
			if ($loginExistant->fetch())
				array_push($messages, 'Le login "'. $_POST['login'] .'" existe déjà. Veuillez en choisir un autre.');
			if (empty($messages)) {
				// On enregistre l'utilisateur
				$requeteInscription = $bdd->prepare('INSERT INTO `eleves` SET login=?,code=?,nom=?,prenom=?,surnom=?,etage=?,possedeVoiture=?'); // Les ? sont indiqués après
				$requeteInscription->execute(Array($_POST['login'],$_POST['code'],$_POST['nom'],$_POST['prenom'],$_POST['surnom'],$_POST['etage'],($_POST['possedeVoiture']=='oui') ? 1:0));
				$inscrit = true;
				$_SESSION['id'] = $bdd->lastInsertId(); // L'ID qui vient d'être enregistré
			}
		}
		?>
		<div id="container">
			<h1>Liste des annonces</h1>
			<?php
			$reqAnnonces = $bdd->query('SELECT auteur.*, annonce.* FROM `annonces` annonce, `eleves` auteur WHERE annonce.auteur=auteur.id');
			while ($annonce = $reqAnnonces->fetch()) {
				?>
				<div class="annonce">
				Auteur : <?php
					echo $annonce['prenom'].' '.$annonce['nom'];
					if ($annonce['surnom'] != '')
						echo '('. $annonce['surnom'] .')';
				?><br />
				Départ à : <?php echo $annonce['horaire_depart']; ?><br />
				Arrivée à : <?php echo $annonce['horaire_arrivee']; ?><br />
				Destination : <?php echo $annonce['destination']; ?><br />
				Message : <?php echo $annonce['message']; ?>
				</div>
				<?php
			}
			?>
			<p><a href="publier-annonce.php">Publier une annonce</a></p>
		</div>
	</body>
</html>