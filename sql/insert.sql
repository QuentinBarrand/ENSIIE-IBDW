DELETE FROM Responsabilite;
DELETE FROM Utilisateur;
DELETE FROM Voix;
DELETE FROM Choriste;
DELETE FROM Inscription;
DELETE FROM Evenement;
DELETE FROM TypeEvt;
DELETE FROM participe;
DELETE FROM Oeuvre;
DELETE FROM est_au_programme;

-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('ssabatier', crypt('ssabatier', gen_salt('bf')));
-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('mpaume', crypt('mpaume', gen_salt('bf')));
-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('qbarrand', crypt('qbarrand', gen_salt('bf')));
-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('gbriquet', crypt('gbriquet', gen_salt('bf')));
-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('gmonier', crypt('gmonier', gen_salt('bf')));
-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('tsarboni', crypt('tsarboni', gen_salt('bf')));
-- INSERT INTO Utilisateur(login, motdepasse)
-- VALUES ('ddiallo', crypt('ddiallo', gen_salt('bf')));

-- UTILISATEUR
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('ssabatier', md5('ssabatier'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('mpaume', md5('mpaume'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('qbarrand', md5('qbarrand'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('gbriquet', md5('gbriquet'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('gmonier', md5('gmonier'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('tsarboni', md5('tsarboni'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('ddiallo', md5('ddiallo'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('MullerChris', md5('hhhh'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('JacquesVilleret', md5('123456'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('gDupuis', md5('paques'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('bDatet', md5('m@dgs&'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('kLeger', md5('llll'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('jerome', md5('jerome'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('Pierre', md5('leloup'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('Jean', md5('paquet'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('Louis', md5('aaaaa'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('arnaud', md5('lol?'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('bryan', md5('kitchen'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('ryan', md5('lalouve'));

--VOIX
INSERT INTO Voix(typeVoix)
VALUES ('alto');
INSERT INTO Voix(typeVoix)
VALUES ('soprano');
INSERT INTO Voix(typeVoix)
VALUES ('tenor');
INSERT INTO Voix(typeVoix)
VALUES ('basse');

--INSCRIPTION
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2014', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2014', 1);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Salarié', '300', '2014', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2014', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2014', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2014', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2014', 1);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Salarié', '300', '2014', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2014', 0);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2014', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2014', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Salarié', '300', '2014', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2014', 1);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2014', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2014', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2013', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2013', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Etudiant', '200', '2013', 2);
INSERT INTO Inscription(typeInscription, montant, annee, validation)
VALUES ('Salarié', '300', '2013', 2);
-- INSERT INTO Inscription(typeInscription, montant, annee, validation)
-- VALUES ('Etudiant', '200', '2013', 1);
-- INSERT INTO Inscription(typeInscription, montant, annee, validation)
-- VALUES ('Etudiant', '200', '2013', 2);
-- INSERT INTO Inscription(typeInscription, montant, annee, validation)
-- VALUES ('Etudiant', '200', '2013', 2);

--CHORISTES
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login , idInscription)
VALUES ('sarboni', 'thomas', 1, 'angers', '0601020304', 'tsarboni', 1);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('sabatier', 'sébastien', NULL, 'bordeaux', '0602030405', 'ssabatier',2);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('barrand', 'quentin', NULL, 'taverny', '0604050607', 'qbarrand',3);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('briquet', 'gaétan', NULL, 'amiens', '0605060708', 'gbriquet',4);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('Muller', 'Chris', 2, 'sarcelles', '0603040506', 'MullerChris',5);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('Villeret', 'Jacques', 2, 'Marseille', '0655550506', 'JacquesVilleret',6);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('Dupuis', 'gaël', 1, 'grenoble', '0603040577', 'gDupuis',7);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('Datet', 'benoit', 4, 'sarcelles', '0666040506', 'bDatet',8);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('Leger', 'kevin', 4, 'bordeaux', '0666040577', 'kLeger',9);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('Colinne', 'Jerome', 4, 'bordeaux', '0666040577', 'jerome',10);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('Coliannet', 'Jean', 1, 'bordeaux', '0666555577', 'Jean',11);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('Puget', 'Louis', 2, 'pessac', '0777040577', 'Louis',12);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('Boulet', 'arnaud', 3, 'grenoble', '0666040888', 'arnaud',13);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('Hourquebie', 'bryan', 4, 'bordeaux', '0666040999', 'bryan',14);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('Hegoak', 'ryan', 1, 'Bayonne', '0666040656', 'ryan',15);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login, idInscription)
VALUES ('Diallo', 'Dounde', NULL, 'amiens', '0605060708', 'ddiallo', 16);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login , idInscription)
VALUES ('Paume', 'Mylène', NULL, 'strasbourg', '0601030415', 'mpaume', 17);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login , idInscription)
VALUES ('Monier', 'Gwenaël', NULL, 'bordeaux', '0601030225', 'gmonier', 18);
INSERT INTO Choriste(nom, prenom, idVoix, ville, telephone, login , idInscription)
VALUES ('Godin', 'Pierre', 3, 'bordeaux', '0601030225', 'Pierre', 19);

--RESPONSABILITE
INSERT INTO Responsabilite(titre)
VALUES ('Chef de coeur');
INSERT INTO Responsabilite(titre)
VALUES ('Tresorier');
INSERT INTO Responsabilite(titre)
VALUES ('Webmaster');
INSERT INTO Responsabilite(titre)
VALUES ('Secrétaire');
INSERT INTO Responsabilite(titre)
VALUES ('Organisateur');
INSERT INTO Responsabilite(titre)
VALUES ('Responsable du matériel');

INSERT INTO endosse(login, id)
VALUES ('ddiallo', 1);
INSERT INTO endosse(login, id)
VALUES ('ssabatier', 2);
INSERT INTO endosse(login, id)
VALUES ('qbarrand', 3);
INSERT INTO endosse(login, id)
VALUES ('mpaume', 4);
INSERT INTO endosse(login, id)
VALUES ('mpaume', 5);
INSERT INTO endosse(login, id)
VALUES ('gbriquet', 6);


--TYPE D'EVENEMENT
INSERT INTO TypeEvt(typeEvt)
VALUES ('Concert');
INSERT INTO TypeEvt(typeEvt)
VALUES ('Répétition');
INSERT INTO TypeEvt(typeEvt)
VALUES ('Saison');

--EVENEMENT
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2014-01-09 14:00:00', '12 rue de la pétanque 33170 Gradignan', 'Préparation au concert du 6 avril');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2014-01-29 10:30:00', '12 rue de la pétanque 33170 Gradignan', 'Sychronisation intruments/choeur');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2014-02-20 18:00:00', '12 rue de la voile 33500 Arcachon', 'Raccord choeur');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2014-05-24 10:00:00', '12 rue de la pétanque 33170 Gradignan', 'Répétition générale concert 1');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-01-25 11:00:00', '12 rue du surf 33850 Lacanau', 'Messe de requiem');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (3, '2014-01-25 11:00:00', 'Salle de la cour', 'Saison 2014-2015');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2013-12-21 14:05:00', '41, allée des rosignols 65170 Tarbes', 'Répétition générale 3');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (3, '2014-06-22 17:55:00', '41, allée des rosignols 65170 Tarbes', 'Saison 2013-2014');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2013-11-22 17:05:00', '4, boulevard de l''Europe 92000 Défense', 'Répétition générale pour fête de noël');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2013-06-25 11:01:00', '4, boulevard de l''Europe 92000 Défense', 'Répétition Partie 1');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2013-09-22 11:51:00', '4, boulevard de l''Europe 92000 Défense', 'Répétition Partie 2');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2013-12-14 11:00:00', '12 rue du surf 33850 Lacanau', 'Répetition Messe de requiem 1/2');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2013-12-14 11:00:00', '12 rue du surf 33850 Lacanau', 'Répetition Messe de requiem 2/2');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2013-05-14 11:00:00', '3 rue Victor Hugo 78000 Sartrouville', 'Concert de la paix');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-06-20 20:00:00', '15 avenue de l''Orge 91000 Evry', 'Fête de la musique 2014');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-04-10 19:00:00', '8 allée d''Ivry 75013 Paris', 'Jour de l''an chinois');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-08-28 19:00:00', '3 rue Victor Hugo 78000 Sartrouville', 'Musiques diverses');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (2, '2014-07-28 19:00:00', '3 rue Victor Hugo 78000 Sartrouville', 'Répétition générale: musiques diverses');
-- Concerts Vides
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-01-25 11:00:00', '49,  rue Berger -  75001 Paris', 'Concert Tryo [reprises]');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-02-25 11:00:00', '42,  rue des Lombards -  75001 Paris', 'Concert Rock / Metal');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-03-25 11:00:00', '11,  quai François-Mauriac -  75013 Paris ', 'Les choristes à l''Olympia');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-04-25 11:00:00', 'route du Champ-de-Manœuvre -  91000 Evry', 'Eminem au Palio');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-05-25 11:00:00', '07, rue de la Musique - 77 000 Savigny-le-Temple', 'Passenger en concert unique à Paris !');
INSERT INTO Evenement(idType, heuredate, lieu, nom)
VALUES (1, '2014-06-25 11:00:00', 'avenue de la prairie Strasbourg 67000', 'Metallica au Zénith de Strasbourg');

--PARTICIPATION
-- Confirmation: 0 indécis et 1 présent. Aucun tuple = absent
-- évènement 1
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (1, 1, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (2, 1, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (3, 1, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (4, 1, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (5, 1, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (6, 1, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (7, 1, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (10, 1, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (11, 1, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (12, 1, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (13, 1, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (14, 1, 1);
-- évènement 2
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (1, 2, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (2, 2, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (3, 2, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (4, 2, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (5, 2, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (6, 2, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (7, 2, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (8, 2, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (9, 2, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (12, 2, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (13, 2, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (15, 2, 0);
-- évènement 3
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (1, 3, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (3, 3, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (4, 3, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (5, 3, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (6, 3, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (7, 3, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (13, 3, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (15, 3, 0);
-- évènement 4
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (1, 4, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (2, 4, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (3, 4, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (4, 4, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (5, 4, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (6, 4, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (7, 4, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (10, 4, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (11, 4, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (12, 4, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (13, 4, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (14, 4, 1);
-- évènement 5
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (1, 5, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (2, 5, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (3, 5, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (4, 5, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (5, 5, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (6, 5, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (7, 5, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (10, 5, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (11, 5, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (12, 5, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (13, 5, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (14, 5, 0);
--évènement de 7 à 18
-- il n'y a personne à l'évènement 18 et 17
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (14, 7, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (6, 8, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (9, 9, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (8, 10, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (3, 12, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (10, 13, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (11, 14, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (2, 15, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (4, 16, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (3, 11, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (4, 12, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (6, 12, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (8, 11, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (9, 12, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (7, 11, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (4, 8, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (15, 10, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (2, 7, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (10, 9, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (4, 10, 1);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (4, 15, 0);
INSERT INTO participe(idChoriste, idEvenement, confirmation)
VALUES (1, 7, 0);

INSERT INTO oeuvre(titre, auteur, partition, duree, style)
VALUES ('51 je taime', 'René Pastis', 'http://www.youtube.com/~theme_song12587', '60', 'chanson à boire');
INSERT INTO oeuvre(titre, auteur, partition, duree, style)
VALUES ('Passion selon jéjé', 'Bébert Dupuis', 'http://www.youtube.com/~theme_song1265', '60', 'baroque');
INSERT INTO oeuvre(titre, auteur, partition, duree, style)
VALUES ('Cantate de la mare', 'BACH Jérome', 'http://www.youtube.com/~theme_song7755', '60', 'chanson à boire');
INSERT INTO oeuvre(titre, auteur, partition, duree, style)
VALUES ('Requiem pour un con', 'Gainsbourg Serge', 'http://www.youtube.com/~theme_song1555', '75', 'chanson à boire');
INSERT INTO oeuvre(titre, auteur, partition, duree, style)
VALUES ('Requiem de ouf', 'Wolfgang Amadeus', 'http://www.youtube.com/~theme_song9999', '60', 'chanson à boire');
INSERT INTO oeuvre(titre, auteur, partition, duree, style)
VALUES ('Column of sadness', 'Steeve Edward', 'http://www.youtube.com/~theme_song1232', '30', 'classique');

--PROGRAMME 
-- l'oeuvre 6 n'est jamais au programme
-- évènement 1
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 1);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 1);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 1);
-- évènement 2
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 2);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 2);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (4, 2);
-- évènement 3
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (4, 3);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (5, 3);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 3);
-- évènement 4
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (5, 4);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 4);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 4);
-- évènement 5
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 5);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 5);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 5);
--Saison
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 6);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 6);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 6);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (4, 6);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (5, 6);
-- évènement 7
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 7);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 7);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 7);
-- évènement 8,9,10,11,12,13
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 9);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 10);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 8);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (1, 11);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (2, 12);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 13);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 14);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 15);
INSERT INTO est_au_programme(idOeuvre, idEvenement)
VALUES (3, 16);
