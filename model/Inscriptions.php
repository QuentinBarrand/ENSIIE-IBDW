<?php

require_once 'Generic.php';

class I_Queries {

    /* --- INSCRIPTIONS RELATED QUERIES --- */

    function getInscriptions() {

        $fetchall = True;

        $sql = 'SELECT nom, prenom, typeVoix, typeInscription, idInscription, validation
                FROM Choriste
                NATURAL JOIN Voix
                NATURAL JOIN Inscription
                WHERE validation > 2;';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getInscriptionCountByType($type) {

        $fetchall = False;

        $sql = 'SELECT count(*)
                FROM Choriste
                NATURAL JOIN Inscription
                WHERE validation = ' . $type . ';';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function updateInscription($type, $id) {

        $fetchall = False;

        $sql = 'UPDATE Inscription
                SET validation = ' . $type . '
                WHERE idInscription > ' . $id . ';';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

}
