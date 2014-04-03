/*  
3.3) Analyse de la procédure interactive  
->  Les accès aux données (requêtes SQL) et algorithmes de traitement des données. 
*/




/* Authentification */

SELECT login
FROM utilisateur
WHERE login = 'login' 
    AND motdepasse = md5('motdepasse');




/* 
2.1.2 Procédure interactive : enregistrement des présences aux répétitions

Pour chaque répétition, un choriste doit pouvoir indiquer ou modifier sa présence : présent, absent ou indécis. 
présent -> 1
indécis -> null 
absent -> rien, aucun tuble !
*/

/*
saisi par l'utilisateur : idChoriste, idEvenement, confirmation
*/
INSERT INTO participe(idChoriste, idEvenement, confirmation)
       VALUES (1, 2, 1);

UPDATE participe SET confirmation = NULL; /* on le modifie en indécis ou présent */

DELETE FROM participe WHERE idChoriste = 1 AND idEvenement = 2; /* on supprime le tuple pour dire qu'il est absent */




/* 
2.2.2 Procédure interactive : création des événements

Le chef de chœur doit pouvoir ajouter un événement (répétition ou concert) avec un programme, dont
les œuvres doivent appartenir au programme de l’année; il est alors automatiquement inscrit pour ce
concert sauf indication contraire 
*/

/*
saisi par l'utilisateur : idType, heureDate, lieu, nom, idOeuvre
note : idOeuvre est tiré d'une liste contenant uniquement les oeuvres qui appartiennent au programme de l'année
*/
SELECT idType, typeEv
FROM TypeEvt;

SELECT Oeuvre.idOeuvre, titre, auteur 
FROM Oeuvre 
NATURAL JOIN est_au_programme
NATURAL JOIN Evenement
WHERE YEAR(Evenement.heuredate) = '2014'  
    AND Evenement.idType = 3; /* 3 -> Type Saison (ce n'est pas l'idType saisi par l'utilisateur) */ 


INSERT INTO Evenement(idType, heuredate, lieu, nom)
       VALUES (1, '2014-08-21 16:00:00');

INSERT INTO est_au_programme(idOeuvre, idEvenement)
       VALUES (1, 2); /* idOeuvre -> choisi, idEvenement est l'id de l'evenement en cours de création */
        /* plusieurs values si l'évènement est une saison */




/*
2.3.2 Procédure interactive : ajout/modification d’un choriste

Un choriste doit pouvoir s’inscrire sur le site, avec l’ensemble des informations le concernant,
puis modifier ses informations si nécessaire. Cette inscription est ensuite doublement validée: par
l’administrateur du site qui vérifie qu’il s’agit bien d’un choriste, et par le trésorier de l’association,
pour indiquer que le choriste a bien réglé son inscription
*/
INSERT INTO utilisateurs(login, motdepasse)
       VALUES;

INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login)
       VALUES ('txt', 'txt', 1, 'txt', 'txt', 'txt');

/* pour la validation on a un champ 'validation' qui vaut 2 pour l'admin, 3 pour le trésorier, 1 pour les 2 un truc dans le genre */




/*
2.4.2 Procédure interactive : création du programme

Le chef de chœur souhaite pouvoir définir en début d’année le programme, c’est-à-dire l’ensemble
des œuvres qui vont être étudiées dans l’année. Pour cela, il doit pouvoir remplir les informations
suivantes sur chaque œuvre: titre, compositeur, style, et ensuite les associer à un
événement particulier, la Saison AAAA-A’A’A’A’, donc le programme contient la totalité des œuvres
de l’année.
*/
INSERT INTO Oeuvre(titre, auteur, partition, duree, style)
       VALUES ('txt', 'txt', 'text', 'txt', 'txt');

INSERT INTO est_au_programme(idOeuvre, idEvenement)
       VALUES (1, 2); 
