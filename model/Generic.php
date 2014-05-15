<?php

class Query {

    /* --- GENERIC DATABASE RELATED FUNCTIONS --- */
    function getFields($data) {
        $quote = "'";
        $separator = '';
        $fields = '';
        $values = '';

        $numerics = array('montant',
                          'date',
                          'idVoix',
                          'idInscription');

        foreach($data as $field => $value) {
            if($fields != '') {
                $separator = ',';
            }
            $fields .= $separator;
            $fields .= $field;
            $values .= $separator;
            if(! in_array($field, $numerics))
                $values .= $quote;
            $values .= $data[$field];
            if(! in_array($field, $numerics))
                $values .= $quote;
        }

        return(array($fields, $values));
    }

    function execute($sql, $fetchall = False) {

        try {
            $db = Flight::db();
        }
        catch(PDOException $e) {
            $db = null;
            $success = false;
            $result = 'Connexion à la base de données impossible (' . $e->getMessage() . ').';
        }

        if($db) {
            try {
                $query = $db->prepare($sql);
                if(! $query->execute()) {
                    $success = false;
                    $result = $query->errorInfo()[2];
                }
                else {
                    $success = true;
                    if($fetchall) {
                        $result = $query->fetchAll();
                    } else {
                        $result = $query->fetch();
                    }
                }
            }
            catch(PDOException $e) {
                $success = false;
                $result = 'Erreur lors de l\'exécution de la requête (' . $e->getMessage() . ').';
            }
        }

        return array($success, $result);

    }
}

