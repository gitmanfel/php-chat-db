<?php
// connexion a la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=mysqltod_todolist;charset=utf8', 'mysqltod_user', 'Reagan1210#');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Insertion du message à l'aide d'une requête préparée
$req = $bdd->prepare('INSERT INTO minichat (pseudo, message) VALUES(?, ?)');
$req->execute(array($_POST['pseudo'], $_POST['message']));

// Puis rediriger vers minichat.php comme ceci :
header('Location: minichat.php');
?>
