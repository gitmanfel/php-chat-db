<?php
try
{
  // On se connecte à MySQL
    $bdd=new PDO('mysql:host=localhost;dbname=imbd;charset=utf8','root','root');
}
catch(Exception $e)
{

	// En cas d'erreur, on affiche un message et on arrête tout
        die($e->getMessage());
}


 $req = $bdd->query('SELECT * FROM authors LEFT JOIN movies ON authors.id = movies.id_author');
 $req= $bdd->query('SELECT * FROM authors
                     LEFT JOIN movies
                     ON authors.id=movies.id_author
                     where movies.id_author is null
                     UNION ALL
                     SELECT * FROM authors
                     RIGHT JOIN movies
                     on authors.id=movies.id_author
                     where authors.id is Null');

$tab=$req->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r ($tab);
echo "</pre>";

?>
