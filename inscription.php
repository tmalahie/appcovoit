<?php
include('init.php');
if ($infoUser) // Si l'user est déjà connecté, on le redirige vers la page d'accueil
	header('location: index.php');
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>App Covoit - Inscription</title>
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
			<h1>Inscription</h1>
			<?php
			if ($inscrit) {
				?>
				<p class="succes">
					Vous êtes à présent inscrit !<br />
					Cliquez <a href="index.php">ici</a> pour retourner à l'accueil.
				</p>
				<?php
			}
			elseif (!empty($messages)) {
				?>
				<p class="echec">
				<?php
				foreach ($messages as $message)
					echo $message .'<br />';
				?>
				</p>
				<?php
			}
			if (!$inscrit) {
				include('forms.php'); // Liste de fonctions utiles pour les formulaires
				?>
				<form method="post" action="inscription.php">
				<p><label><span class="form-input">Choisissez un login :</span><span class="form-value"><input type="text" name="login" value="<?php print_value('login'); ?>" required /></span></label></p>
				<p><label><span class="form-input">Choisissez un mot de passe :</span><span class="form-value"><input type="password" name="code" value="<?php print_value('code'); ?>" required /></span></label></p>
				<p><label><span class="form-input">Retapez mot de passe :</span><span class="form-value"><input type="password" name="confirm" value="<?php print_value('confirm'); ?>" required /></span></label></p>
				<p><label><span class="form-input">Votre nom :</span><span class="form-value"><input type="text" name="nom" value="<?php print_value('nom'); ?>" required /></span></label></p>
				<p><label><span class="form-input">Votre prénom :</span><span class="form-value"><input type="text" name="prenom" value="<?php print_value('prenom'); ?>" required /></span></label></p>
				<p><label><span class="form-input">Votre surnom :</span><span class="form-value"><input type="text" name="surnom" value="<?php print_value('surnom'); ?>" /></span></label></p>
				<p><label><span class="form-input">Votre étage :</span><span class="form-value"><input type="text" name="etage" value="<?php print_value('etage'); ?>" required /></span></label></p>
				<p><span class="form-input">Possédez-vous une voiture ?</span><span class="form-value"><label class="radio-label"><input type="radio" name="possedeVoiture" value="oui"<?php if (!isset($_POST['possedeVoiture']) || ($_POST['possedeVoiture'] == 'oui')) echo ' checked="checked"'; ?> /> Oui</label><label class="radio-label"><input type="radio" name="possedeVoiture" value="non"<?php if (isset($_POST['possedeVoiture']) && ($_POST['possedeVoiture'] == 'non')) echo ' checked="checked"'; ?> /> Non</span></label></p>
				<p><input type="submit" value="Inscription" />
				</form>
				<?php
			}
			?>
		</div>
	</body>
</html>