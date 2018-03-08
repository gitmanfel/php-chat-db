<?php
// on la démarre :)
session_start ();

try
{
	// On se connecte à MySQL
	$bdd=new PDO('mysql:host=localhost;dbname=minichat;charset=utf8','root','root');
}
catch(Exception $e)
{
	echo "TEST";
	// En cas d'erreur, on affiche un message et on arrête tout
	die($e->getMessage());
}

if(isset($_POST["connexion"]))
{

	// on teste si nos variables sont définies
	if (!empty($_POST['login']) && !empty($_POST['password']))
	{

		$request = $bdd->prepare('SELECT * from user where `login` = :login and `password` = :password');
		$request->execute(array(
			'login' => $_POST['login'],
			'password' => $_POST['password']
		));
		$tab = $request->fetchAll();

		// on vérifie les informations du formulaire, à savoir si le pseudo saisi est bien un pseudo autorisé, de même pour le mot de passe
		if (count($tab) == 1)
		{
			// dans ce cas, tout est ok, on peut démarrer notre session


			// on enregistre les paramètres de notre visiteur comme variables de session ($login et $pwd)
			$_SESSION['login'] = $_POST['login'];
			$_SESSION['password'] = $_POST['password'];


			// on redirige notre visiteur vers une page de  chat
			header ('location: index.php');


		}

		//Le visiteur n'a pas été reconnu comme étant membre de notre site.
		else
		{
			echo '<label class="lbl-red"> <strong>Wrong username or password </strong></label>';
		}
	}
}
$error = FALSE;
$Register = FALSE;
//verification du passage par l inscription
if(isset($_POST["Register"]))
{
	//Verification champs completements remplis ou message d'erreur.
	if($_POST["login"] == "" OR $_POST["password"] == "" OR $_POST["password2"] == ""  OR $_POST["e-mail"] == "")
	{
		// On active la variable $error; le navigateur saura qu'il y'a une erreur à afficher.
		$error = TRUE;
		// message d erruer qu s'affichera
		$errorMSG = "Tout les champs doivent être remplis !";

	}
						// corespondance des 2 mdp
	elseif($_POST["password"] == $_POST["password2"])
	{

		// verification base de donnée si le pseudo n'est pas deja pris
		// $sql = "SELECT login FROM user WHERE login = '".$_POST["login"]."' ";
		// $sql = mysql_query($sql);
		// //verfication email non pris
		// $sql = "SELECT e-mail FROM user WHERE e-mail = '".$_POST["e-mail"]."' ";
		// $sql = mysql_query($sql);

		// decompte du nombre de lettres chiffres valeurs...
		// $sql = mysql_num_rows($sql);
		// if($sql == 0){
		// 	// non exces de 60 caracteres du mdp
		// 	if(strlen($_POST["passord"] < 60))
		// 	{
		// 		// non exces de 30 caractere du pseudo
		// 		if(strlen($_POST["login"] < 60))
		// 		{
		// 			// Si le nom de compte et le mot de passe sont différent :
		// 			if($_POST["login"] != $_POST["password"])
					// {
						// tout les criteres sont remplis : inscription dans la database
						// $sql = "INSERT INTO user (login,password,e-mail) VALUES ('".$_POST["login"]."','".$_POST["password"]."','".$_POST["e-mail"]."')";
						// $sql="INSERT INTO `user`( `login`, `e-mail`, `password`) VALUES (".$_POST['login'].",".$_POST['e-mail'].",".$_POST['password'].")";
						// $sql = mysql_query($sql);

						$request = $bdd->prepare('INSERT INTO `user`(`login`, `e-mail`, `password`) VALUES (:login,:email,:password)');
						$request->execute(array(
							'login' => $_POST['login'],
							'email' => $_POST['e-mail'],
							'password' => $_POST['password']
						));
						//$tab = $request->fletchAll();





						if($sql)
						{

							// activation de la variable $Register
							$Register = TRUE;
							$registerMSG = "L'Inscription est réussie ! Vous êtes maintenant membre du site.";

							// stockage des mdp et pseudos
							$_SESSION["login"] = $_POST["login"];
							$_SESSION["password"] = $_POST["password"];
							$_SESSION["e-mail"] = $_POST["e-mail"];

				// 		}
				// 	}
				// }
			// }
		}
	}
}
			?>
			<!DOCTYPE html>
			<html>
			<head>
				<title>Formulaire de Connexion</title>
				<link rel="stylesheet" href="login-style.css">
			</head>
			<style>
			body
			{
				text-align:center;
			}

		</style>

		<body>

			<h1>Please login!</h1>

			<form action="login.php" method="post">
				Votre login : <input type="text" name="login">
				<br />
				Votre mot de passé : <input type="password" name="password"><br />
				<input type="submit" class="btn btn-primary btn-block btn-large" name="connexion" value="Connexion">

			</form>

			<h1>Please sign up</h1>

			<form action="login.php" method="post">
				Créer votre login : <input type="text" name="login">
				<br />
				Créer votre mot de passé : <input type="password" name="password"><br />
				Confirmer votre mot de passe:<input type="password" name="password2" id="password2"/>
				Créer votre mot e-mail : <input type="e-mail" name="e-mail"><br />
				<input type="submit" class="btn btn-primary btn-block btn-large" name="Register" value="Register"/>


			</form>

		</body>
		</html>
