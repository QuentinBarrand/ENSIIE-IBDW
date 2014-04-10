<meta http-equiv="content-type" content="text/html; charset=utf-8" />


<?php
// Connexion, sélection de la base de données
    $dbconn = pg_connect("host=localhost dbname=nombasedonnees user=nomutilisateur password=xxx")
    or die('Connexion impossible : ' . pg_last_error());


//récupération des valeurs des champs:
    $login = $_POST['login'];
    $pass = $_POST['pass'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $ville = $_POST['ville'];
    $telephone = $_POST['telephone'];
    $voix = $_POST['voix'];
    	
 
//Insertion des données:

    $sql=pg_query("BEGIN;");
    $sql=pg_query($conn,"INSERT INTO utilisateur (login ,motdepasse)
                  VALUES ('".$login."','".$pass."') RETURNING id")
                  or die ('Erreur connexion'. pg_last_error($conn));
    if ($sql) {
        $sql=pg_query($conn,"INSERT INTO Choriste (idChoriste ,nom ,prenom ,idVoix ,ville ,telephone ,login ,idInscription)
                      VALUES (8,'".$nom."','".$prenom."', '".$voix."', '".$ville."', '".$telephone."', '".$login."', 8 ) RETURNING id")
                      or die ('Erreur connexion'. pg_last_error($conn));
    }
    if ($sql) {
         $sql=pg_query("COMMIT;");
         echo("L’inscription a réussie");
    } else {
         $sql=pg_query("ROLLBACK;");
         echo("L'inscription a échouée");
    }

// Libère le résultat
	pg_free_result($sql);

// Ferme la connexion
	pg_close($dbconn);
?>



