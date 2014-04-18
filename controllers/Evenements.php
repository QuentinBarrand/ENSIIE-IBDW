<?php

class Evenements {

    
    // GET /evenements
    function get() {

        //Récupérer un utilisateur connecté s'il y en a un
        $user = Flight::get('user');


        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        // On récupère tous les évènements
        $sql1 = "SELECT idEvenement, heureDate, lieu, nom, idType 
            FROM evenement
            NATURAL JOIN TypeEvt ";
            
            // Si l'internaute n'est pas connecté, on affiche que les concerts
            if (!$user['authenticated']){
                $sql1.=" WHERE typeEvt LIKE 'Concert' ";
            }

            $sql1.=" ORDER BY heureDate DESC; ";

        if($db) {
            $voix = Choristes::getVoix();

            $sql2 = 'SELECT Evenement.idEvenement, heureDate, lieu, nom';

            foreach($voix as $v)
                $sql2 .= ', nbc_' . $v['idvoix'];


            $sql2 .= ' FROM Evenement
                      NATURAL JOIN TypeEvt ';

            foreach($voix as $v)
                $sql2 .= 'LEFT OUTER JOIN (
                              SELECT idEvenement, count(participe.idChoriste) as nbc_' . $v['idvoix'] . '
                              FROM participe
                              NATURAL JOIN Choriste
                              WHERE idVoix = ' . $v['idvoix'] . '
                              AND confirmation = 1
                              GROUP BY idEvenement
                            ) as view_nbvoix_' . $v['idvoix'] . '
                          ON Evenement.idEvenement = view_nbvoix_' . $v['idvoix'] . '.idEvenement ';

            $sql2 .= "WHERE typeEvt='Concert'
                      ORDER BY heureDate DESC;";

            // On récupère la présence/participation de l'utilisateur connecté (s'il y en a un) pour chaque évènements
            if($user['authenticated']) {
                $sqlPresence = "SELECT evenement.idEvenement, confirmation
                    FROM evenement
                    NATURAL JOIN TypeEvt
                    INNER JOIN participe ON evenement.idevenement=participe.idevenement
                    INNER JOIN choriste ON choriste.idchoriste=participe.idchoriste
                    WHERE "."login='".$user['login']."' "
                    ."ORDER BY heureDate DESC;";
            }

            if($db) {
                try {
                    // Traitement de SQL1
                    $query = $db->prepare($sql1);
                    $query->execute();

                    //$content: variable contenant les données récupérées avec les requêtes sql
                    foreach($query->fetchAll() as $row) {
                        $id =$row['idevenement'];
                        $content[$id] = $row ;
                    }

                    // Traitement de SqlPresence
                    if($user['authenticated']) {
                        $query = $db->prepare($sqlPresence);
                        $query->execute();

                        //Par défaut l'utilisateur ne va pas à l'évènement
                        foreach($content as $row) {
                            $row['presence'] = "absent";
                            $content[$row['idevenement']] = $row;
                        }

                        // Traitement des résultats de SqlPresence
                        foreach($query->fetchAll() as $row) {
                            $id =$row['idevenement'];
                            if ($row['confirmation'] == 0)
                                $content[$id]['presence'] = 'indécis';
                            else if ($row['confirmation'] == 1)
                                $content[$id]['presence'] = 'présent';
                        }
                    }

                    $data['success'] = true;
                    $data['content'] = $content;

                    // SQL2
                    $query = $db->prepare($sql2);
                    $query->execute();

                    $result = $query->fetchAll();
                }
                catch(PDOException $e) {
                    $data['success'] = false;
                    $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
                }
            }

            // Header
            Flight::render('header.php',
                array(
                    'title' => 'Liste des évènements'
                    ),
                'header');

            // Navbar
            Flight::render('navbar.php',
                array(
                    'activePage' => 'evenements'
                    ),
                'navbar');

            // Footer
            Flight::render('footer.php',
                array(),
                'footer');

            // Finalement on rend le layout
            if($data['success'])
                Flight::render('EvenementsLayout.php', array('data' => $data));
            else
                Flight::render('ErrorLayout.php', array('data' => $data));
        }
    }

    // GET /evenements/nouveau
    function displayEventForm($fail = NULL) {
        // Header
        Flight::render('header.php',
            array(
                'title' => 'Ajouter un évènement'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'evenements'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');

        $user = Flight::get('user');

        if($user['authenticated'] && $user['responsabilite'] == 1) {
            $fail['error'] = $fail == NULL ? false : true;

            Flight::render('EvenementNewLayout.php', array(
                'fail' => $fail
                )
            );
        }
        else {
            $data = array(
                'error' => 'Vous n\'avez pas les droits nécessaires pour accéder à cette page.');
            Flight::render('ErrorLayout.php', $data);
        }
    }

    /* Retourne le nombre total d'évènements du type passé en paramètre
     * (par défaut 2 = répétitions) dans la base de données.
     */
    function getCount($type = 2) {
        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
        }

        $sql = 'SELECT count(idEvenement) as TotalRepetitions
                    FROM Evenement
                    WHERE idType = ' . $type . ';';

        $count = NULL;

        if($db) {
            try {
                $query = $db->prepare($sql);
                $query->execute();

                $result = $query->fetch();
                $count = $result[0];
            }
            catch(PDOException $e) { }
        }

        return $count;
    }

    // POST /evenements/nouveau
    function add() {
        // Récupération des données POST
        $nom   = Flight::request()->data->nom;
        $lieu  = Flight::request()->data->lieu;
        $date  = Flight::request()->data->date;
        $type  = Flight::request()->data->type;

        $timestamp = DateTime::createFromFormat("d/m/Y H:i", $date);
        $annee = date("Y", $timestamp->getTimestamp());

        if(! Evenements::seasonExists($annee)) {
            $fail['error'] = true;
            $fail['message'] = "La saison " . $annee . " existe déjà.";

            Evenements::displayEventForm($fail);
            return;
        }

        switch($type) {
            case 'repetition':
            case 'concert':
                Evenements::addEvent($nom, $lieu, $date, $type);

            case 'saison':
                Evenements::displaySaisonForm($nom, $annee);
                break;
        }
    }

    // Fonction d'ajout d'une répétition ou d'un concert
    function addEvent($nom, $lieu, $date, $type) {
        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        // On insère l'évènement courant
        $sql = "INSERT INTO Evenement(idType, heureDate, lieu, nom)
            VALUES(:idType, :heureDate, :lieu, :nom)
            RETURNING idEvenement;";

        switch($type) {
            case 'repetition':
                $idType = 1;
                break;

            case 'concert':
                $idType = 2;
                break;
        }

        // Traitement heureDate
        $timestamp = DateTime::createFromFormat("d/m/Y H:i", $date);
        $heureDate = date("Y-m-d H:i:s", $timestamp->getTimestamp());

        if($db) {
            try {
                $query = $db->prepare($sql);
                $query->execute(array(
                    ':idType' => $idType,
                    ':heureDate' => $heureDate,
                    ':lieu' => $lieu,
                    ':nom' => $nom
                    )
                );

                $data['success'] = true;
                $data['message'] = "L'évènement <b>" . $nom . "</b> a bien été ajouté.";
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Ajout d\'un évènement'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'evenements'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');      

        // Finalement on rend le layout
        if($data['success'])
            Flight::render('SuccessLayout.php', array('data' => $data));
        else
            Flight::render('ErrorLayout.php', array('data' => $data));
    }

    function displaySaisonForm($nom, $annee, $added = NULL) {
        $oeuvres = Programme::getOeuvres();

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Ajouter une saison'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'evenements'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');

        Flight::render('SaisonNewLayout.php', array(
            'nom' => $nom,
            'annee' => $annee,
            'oeuvres' => $oeuvres,
            'added' => $added
            )
        );
    }

    // GET /oeuvre/nouveau
    function addOeuvre() {
        $titre     = Flight::request()->data->titre;
        $auteur    = Flight::request()->data->auteur;
        $partition = Flight::request()->data->partition;
        $duree     = intval(Flight::request()->data->duree);
        $style     = Flight::request()->data->style;

        // Pour le displaySaisonForm() en bas
        $nom       = Flight::request()->data->nom;
        $annee     = Flight::request()->data->annee;

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        // On insère l'évènement courant
        $sql = "INSERT INTO Oeuvre(titre, auteur, partition, duree, style)
            VALUES(:titre, :auteur, :partition, :duree, :style)
            RETURNING idOeuvre;";

        if($db) {
            try {
                $query = $db->prepare($sql);
                $query->execute(array(
                    ':titre' => $titre,
                    ':auteur' => $auteur,
                    ':partition' => $partition,
                    ':duree' => $duree,
                    ':style' => $style
                    )
                );

                $data['success'] = true;
                $data['message'] = "L'oeuvre <b>" . $titre . "</b> a bien été ajouté.";
            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

        Evenements::displaySaisonForm($nom, $annee, $data['message']);
    }

    // POST /saison/nouveau
    function addSaison() {
        // print_r(Flight::request()->data); die;
        $nom = Flight::request()->data->nom;
        $annee = Flight::request()->data->annee;
        $oeuvres = Flight::request()->data->oeuvres;

        // Ajout de la saison en base de données
        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        $sql = "INSERT INTO Evenement(idType, heureDate, lieu, nom)
            VALUES(3, :heureDate, '', :nom)
            RETURNING idEvenement;";

        // annee en timestamp compatible postgres
        $timestamp = DateTime::createFromFormat("Y", $annee);
        $heureDate = date("Y-m-d H:i:s", $timestamp->getTimestamp());

        if($db) {
            try {
                $query = $db->prepare($sql);
                
                $query->execute(array(
                    ':heureDate' => $heureDate,
                    ':nom' => $nom
                    )
                );

                $result = $query->fetch();
                
                $saisonId = $result['idevenement']; 
            }
            catch(PDOException $e) { }
        }

        // Ajout des oeuvres dans la table est_au_programme
        if(! isset($saisonId)) {
            $data['success'] = false;
            $data['message'] = "Impossible d'ajouter la saison " . $annee .".";
        }
        else {
            if(count($oeuvres) > 0) {   
                try {
                    $sql = "INSERT INTO est_au_programme";

                    $query = $db->prepare($sql);

                    $first = true;

                    foreach($oeuvres as $oeuvreId) {
                        if($first) {
                            $sql .= " VALUES ";
                            $first = false;
                        }
                        
                        else
                            $sql .= ",";

                        $sql .= "(" . $oeuvreId . ", " . $saisonId . ")";
                    }

                    $sql .= ";";

                    $query = $db->prepare($sql);
                    $query->execute();
                }
                catch(PDOException $e) { }
            }

            $data['success'] = true;
            $data['message'] = "La saison " . $nom . " (" . $annee .") a bien été ajoutée à la base de données.";
        }

        // Header
        Flight::render('header.php',
            array(
                'title' => 'Ajout d\'une saison'
                ), 
            'header');

        // Navbar
        Flight::render('navbar.php',
            array(
                'activePage' => 'evenements'
                ), 
            'navbar');

        // Footer
        Flight::render('footer.php',
            array(), 
            'footer');      

        // Finalement on rend le layout
        if($data['success'])
            Flight::render('SuccessLayout.php', array('data' => $data));
        else
            Flight::render('ErrorLayout.php', array('data' => $data));
    }

    // Retourne true si la saison existe, false sinon
    function seasonExists($annee) {
        $returnValue = NULL;

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $data['success'] = false;
            $data['error'] = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        $sql = "SELECT count(*) 
            FROM Evenement
            NATURAL JOIN TypeEvt
            WHERE typeEvt LIKE 'Saison'
            AND EXTRACT(YEAR from heureDate) = :annee";

        if($db) {
            try {
                $query = $db->prepare($sql);
                
                $query->execute(array(
                    ':annee' => $annee
                    )
                );

                $result = $query->fetch();
                
                if($result[0] > 0) 
                    $returnValue = false;
                else
                    $returnValue = true;
            }
            catch(PDOException $e) { }
        }

        return $returnValue;
    }


    // POST /evenements
    function updateEvents() {
        $user = Flight::get('user');

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
        }
        $requestEvents = Flight::request()->data['idevenement'];
        $requestPresences = Flight::request()->data['presence'];

        //récupére la présence de l'utilisateur pour chaque évènements
        $sql = "select idevenement,confirmation
                        from choriste
                        natural join participe
                        where login = :login ;";

        if($db) {
            try {
                $query = $db->prepare($sql);

                $query->execute(array(
                        'login' => $user['login']
                    )
                );

                foreach($query->fetchAll() as $row) {
                    $id =$row['idevenement'];
                    $presences[$id] = $row ;
                }

            }
            catch(PDOException $e) {
                $data['success'] = false;
                $data['error'] = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

        for ($i = 0; $i <= count($requestEvents)-1 && $i <= count($requestPresences)-1; $i++) {

            $sql = NULL;

            // S'il va être présent
            if ($requestPresences[$i] == "present"){

                // S'il était absent, on fait un add
                if (!isset($presences[$requestEvents[$i]]['confirmation'])){
                    $sql = "INSERT INTO participe(idchoriste,idevenement,confirmation)
                            VALUES (:idchoriste , :idevenement, 1);";
                }
                // S'il était indécis, on fait un update
                else if ( ($presences[$requestEvents[$i]]['confirmation']) == 0){
                    $sql = "UPDATE participe
                            SET confirmation = 1
                            WHERE idevenement = :idevenement AND idchoriste = :idchoriste ;";
                }
            }
            // S'il va être indécis
            else if ($requestPresences[$i] == "indecis"){
                // S'il était absent, on fait un add
                if (!isset($presences[$requestEvents[$i]]['confirmation'])){
                    $sql = "INSERT INTO participe(idchoriste,idevenement,confirmation)
                            VALUES(:idchoriste , :idevenement , 0);";
                }
                // S'il était présent, on fait un update
                else if ( ($presences[$requestEvents[$i]]['confirmation']) == 1){
                    $sql = "UPDATE participe
                            SET confirmation = 0
                            WHERE idevenement = :idevenement AND idchoriste = :idchoriste ;";
                }
            }
            // S'il va être absent
            else if ($requestPresences[$i] == "absent"){
                // S'il n'était pas déjà absent on supprime
                if(isset($presences[$requestEvents[$i]]['confirmation']))
                {
                    $sql = "DELETE FROM participe
                             WHERE idevenement = :idevenement AND idchoriste = :idchoriste ;";

                }
            }

            if($db && $sql!=NULL) {
                try {
                    $query = $db->prepare($sql);
                    $query->execute( array ('idevenement' => $requestEvents[$i],
                        'idchoriste' => $user['idChoriste']));


                }
                catch(PDOException $e) { }
            }
        }

        $base = Flight::request()->base;
        Flight::redirect($base . '/evenements');
    }
}
