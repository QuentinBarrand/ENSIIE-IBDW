<?php

require_once 'Generic.php';

class E_Queries {

    /* --- EVENEMENTS RELATED QUERIES --- */

    function getEvenements($user = null) {

        $fetchall = True;

        $sql = 'SELECT idevenement, heureDate, lieu, nom, idType
                FROM Evenement
                NATURAL JOIN TypeEvt ';
        if (! $user) {
            $sql .= "WHERE typeEvt LIKE 'Concert' ";
        }
        $sql .= 'ORDER BY heureDate DESC;';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getRatesByVoices($voix) {

        $fetchall = True;

        $sql = 'SELECT Evenement.idevenement, heureDate, lieu, nom';

        foreach($voix as $v)
            $sql .= ', nbc_' . $v['idvoix'];

        $sql .= ' FROM Evenement
                 NATURAL JOIN TypeEvt';

        foreach($voix as $v) {
            $sql .= " LEFT OUTER JOIN (
                     SELECT idevenement, count(participe.idChoriste) as nbc_";
            $sql .= $v['idvoix'];
            $sql .= " FROM participe
                     NATURAL JOIN Choriste
                     WHERE idVoix = " . $v['idvoix'] . "
                     AND confirmation = 1
                     GROUP BY idevenement
                     ) as view_nbvoix_" . $v['idvoix'] . "
                     ON Evenement.idevenement = view_nbvoix_";
            $sql .= $v['idvoix'] . ".idevenement";
        }
        $sql .= " WHERE typeEvt='Concert'
                 ORDER BY heureDate DESC;";
                     
        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getRatesByUser($login) {

        $fetchall = True;

        $sql = "SELECT evenement.idevenement, confirmation
                FROM Evenement
                NATURAL JOIN TypeEvt
                INNER JOIN participe
                ON evenement.idevenement=participe.idevenement
                INNER JOIN choriste
                ON choriste.idchoriste=participe.idchoriste
                WHERE login = '" . $login . "'
                ORDER BY heureDate DESC;";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getEventCountByType($type) {

        $fetchall = False;

        $sql = 'SELECT count(idEvenement) as TotalRepetitions
                FROM Evenement
                WHERE idType = ' . $type . ';';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function countSeasonsByYear($annee) {

        $fetchall = False;

        $sql = "SELECT count(*)
                FROM Evenement
                WHERE typeEvt LIKE 'Saison'
                AND EXTRACT(YEAR from heureDate) = " . $annee . ";";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function getPresencesByLogin($login) {

        $fetchall = True;

        $sql = "SELECT idevenement, confirmation
                FROM Choriste
                NATURAL JOIN participe
                WHERE login = '" . $login . "';";

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function insertEvent($evenement) {

        $fetchall = False;

        list($fields, $values) = Query::getFields($evenement);

        $sql = 'INSERT INTO Evenement(' . $fields . ')
                VALUES(' . $values . ');';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function insertOeuvre($oeuvre) {

        $fetchall = False;

        list($fields, $values) = Query::getFields($oeuvre);

        $sql = 'INSERT INTO Oeuvre(' . $fields . ')
                VALUES(' . $values . ');';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function insertSaison($saison) {

        $fetchall = False;

        list($fields, $values) = Query::getFields($saison);

        $sql = 'INSERT INTO Evenement(' . $fields . ')
                VALUES(' . $values . ');';

        $id_sql = "SELECT currval('evenement_idevenement_seq');";

        list($success, $result) = Query::execute($sql, $fetchall);
        list($success, $id_result) = Query::execute($id_sql, $fetchall);
        return array($success, $result, $id_result[0]);

    }

    function insertPresence($presence) {

        $fetchall = False;

        list($fields, $values) = Query::getFields($presence);

        $sql = 'INSERT INTO participe(' . $fields . ')
                VALUES(' . $values . ');';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function updatePresence($presence) {

        $fetchall = False;

        $sql = 'UPDATE participe
                SET confirmation = ' . $presence['confirmation'] . '
                WHERE idevenement = ' . $presence['idevenement'] . '
                AND idchoriste = ' . $presence['idchoriste'] . ';';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

    function deletePresence($idevenement, $idchoriste) {

        $fetchall = False;

        $sql = 'DELETE FROM participe
                WHERE idevenement = ' . $idevenement . '
                AND idchoriste = ' . $idchoriste . ';';

        list($success, $result) = Query::execute($sql, $fetchall);
        return array($success, $result);

    }

}

