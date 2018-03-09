<?php

// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mini-chat</title>
        <link rel="stylesheet" href="chat-style.css">
    </head>
    <style>
    form
    {
        text-align:center;
    }

    </style>
    <body>

      <h2>Bienvenue! taper un message pour commencer votre Minichat session</h2>
      <div class="container">

        <form action="minichat_post.php" method="post">
          <p>
            <label for="message">Message</label> :  <input type="text" name="message" placeholder="tapez votre message ici" id="message" /><br />
            <input type="submit" value="Envoyer" />

	       </p>
        </form>

      </div>

<?php
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=minichat;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{

        die('Erreur : '.$e->getMessage());
}

// Récupération des 10 derniers messages
$reponse = $bdd->query('SELECT * FROM message');
// Affichage de chaque message (toutes les données sont protégées par htmlspecialchars)
while ($donnees = $reponse->fetch())
{
	echo '<p><strong>' . $donnees['login'] . '</strong> : ' . $donnees['text'] . '</p>';
}

$reponse->closeCursor();

?>
    </body>
</html>
