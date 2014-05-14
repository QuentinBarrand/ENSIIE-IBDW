<?php

class Query {

    /* --- GENERIC DATABASE RELATED FUNCTIONS --- */
    function getFields($data) {
        $separator = '';
        $fields = '';
        $values = '';

        foreach($data as $field => $value) {
            if($fields != '') {
                $separator = ',';
            }
            $fields .= $separator;
            $fields .= $field;
            $values .= $separator;
            $values .= $data[$field];
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
                $query->execute();
                $success = true;
                if($fetchall) {
                    $result = $query->fetchAll();
                } else {
                    $result = $query->fetch();
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

