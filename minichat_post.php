<?php
// connexion a la base de données
session_start();
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=minichat;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Insertion du message à l'aide d'une requête préparée
$req = $bdd->prepare('INSERT INTO `message`(`user-id`, `login`, `text`) VALUES (?,?,?)');
$req->execute(array($_SESSION['user-id'], $_SESSION['login'], $_POST['message']));

// Puis rediriger vers minichat.php comme ceci :
header('Location: index.php');
?>
