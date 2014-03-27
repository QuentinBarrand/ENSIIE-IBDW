DELETE FROM Responsabilite;
DELETE FROM Utilisateur;
DELETE FROM Voix;
DELETE FROM Choriste;
DELETE FROM Inscription;

INSERT INTO Voix(idVoix, typeVoix)
VALUES (1, 'a');
INSERT INTO Voix(idVoix, typeVoix)
VALUES (2, 's');
INSERT INTO Voix(idVoix, typeVoix)
VALUES (3, 't');
INSERT INTO Voix(idVoix, typeVoix)
VALUES (4, 'b');



INSERT INTO Utilisateur(login, motdepasse)
VALUES ('bbressan', md5('bbressan'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('pmelt', md5('pmelt'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('cdefaud', md5('cdefaud'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('dgoncalves', md5('dgoncalves'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('trodrigues', md5('trodrigues'));
INSERT INTO Utilisateur(login, motdepasse)
VALUES ('pkerizin', md5('pkerizin'));

INSERT INTO Responsabilite(titre, login)
VALUES ('Chef de coeur', 'bbressan');
INSERT INTO Responsabilite(titre, login)
VALUES ('Tresorier', 'cdefaud');
INSERT INTO Responsabilite(titre, login)
VALUES ('Webmaster', 'trodrigues');

INSERT INTO inscription(idInscription, type_inscr, montant, annee)
VALUES (1, 'etudiant', '200', '2014');

INSERT INTO Choriste(idChoriste ,nom ,prenom ,voix ,ville ,telephone ,login ,idInscription)
VALUES (1, 'melt', 'patrice', 'a', 'angers', '0601020304', 'pmelt', 1);
INSERT INTO Choriste(idChoriste ,nom ,prenom ,voix ,ville ,telephone ,login ,idInscription)
VALUES (2, 'defaud', 'christophe', 'b', 'bordeaux', '0602030405', 'cdefaud', 1);
INSERT INTO Choriste(idChoriste ,nom ,prenom ,voix ,ville ,telephone ,login ,idInscription)
VALUES (3, 'goncalves', 'david', 's', 'sarcelles', '0603040506', 'dgoncalves', 1);
INSERT INTO Choriste(idChoriste ,nom ,prenom ,voix ,ville ,telephone ,login ,idInscription)
VALUES (4, 'rodrigues', 'thomas', 't', 'taverny', '0604050607', 'trodrigues', 1);
INSERT INTO Choriste(idChoriste ,nom ,prenom ,voix ,ville ,telephone ,login ,idInscription)
VALUES (5, 'kerizin', 'pierrick', 'a', 'amiens', '0605060708', 'pkerizin', 1);



INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (1, 'Répétition', '2014-01-06 19:00:00', 'Evry - Au temple rue Chauchat', 'Préparation concert 1 de 19h à 21h30');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (2, 'Répétition', '2014-01-13 10:30:00', 'Evry - Au temple rue Chauchat', 'Racccord instruments (Cuivres, orgue, percu)');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (3, 'Répétition', '2014-01-20 18:00:00', 'Evry - Au temple vestier salle 45', 'Raccord choeur');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (4, 'Répétition', '2014-05-24 10:00:00', 'Evry - Au temple rue Chauchat', 'Répétition générale concert 1 de 19h à 21h30');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (5, 'Concert', '2014-01-25 11:00:00', 'Eglise de Creteil', 'Messe de requiem');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (6, 'Répétition', '2014-05-02 19:00:00', 'Evry - Au temple rue Chauchat', 'Préparation concert 2 de 19h à 21h30');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (7, 'Répétition', '2014-05-16 10:30:00', 'Evry - Au temple rue Chauchat', 'Racccord instruments (Cuivres, orgue, percu)');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (8, 'Répétition', '2014-05-23 18:00:00', 'Evry - Au temple vestier salle 45', 'Raccord choeur');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (9, 'Répétition', '2014-05-26 18:00:00', 'Evry - Au temple vestier salle 45', 'Répétition générale concert 2 de 19h à 21h30');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (10, 'Concert', '2014-05-27 20:00:00', 'Paris - Au Palais des Congrès', 'Concert 2 Requiem allemand');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (11, 'Concert', '2014-01-28 20:30:00', 'Paris 12ème aux "Voix sur berges"', 'Concert 3 a capella');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (12, 'Concert', '2014-01-29 20:00:00', 'Paris 10ème Eglise St Vincent de Paul"', 'Concert 4 Requiem Mozart');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (13, 'Répétition', '2014-08-29 19:00:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Répétition générale');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (14, 'Répétition', '2014-08-30 19:30:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Répétition générale');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (15, 'Répétition', '2014-08-31 18:00:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Travail des partitions');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (16, 'Répétition', '2014-09-01 19:00:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Répétition générale');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (17, 'Répétition', '2014-09-08 19:30:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Répétition générale');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (18, 'Répétition', '2014-09-15 18:00:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Travail des partitions');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (19, 'Répétition', '2014-09-22 19:00:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Travail des partitions');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (20, 'Concert', '2014-10-03 20:00:00', 'Paris 10ème Eglise St Vincent de Paul', 'Messe solennelle');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (21, 'Concert', '2014-10-04 20:30:00', 'Paris 12ème Eglise La trinité"', 'Concert 4');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (22, 'Concert', '2014-10-05 20:00:00', 'Paris 4ème Eglise St Louis"', 'Concert 5 profit assos ELA');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (23, 'Répétition', '2014-10-13 18:00:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Répétition générale');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (24, 'Répétition', '2014-10-20 18:30:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Répétition générale');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (25, 'Répétition', '2014-10-27 18:00:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Perfectionnement Tenors et Basses');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (26, 'Répétition', '2014-11-03 18:00:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Répétition générale');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (27, 'Répétition', '2014-11-04 18:30:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Répétition générale');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (28, 'Répétition', '2014-11-10 18:00:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Perfectionnement Tenors et Basses');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (29, 'Répétition', '2014-11-17 18:30:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Répétition générale');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (30, 'Répétition', '2014-11-27 18:00:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Répétition générale');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (31, 'Concert', '2014-11-28 20:00:00', 'Paris 19ème Le Zénith', 'Bach La passion selon St Jean');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (32, 'Concert', '2014-11-29 20:30:00', 'Evry - Au conservatoire, 2 rue Bullet', 'Requiem de Mozart');
INSERT INTO evenement(idevenement, type_evt, heuredate, lieu, nom)
VALUES (33, 'Concert', '2014-11-30 20:00:00', 'Evry - Salle Croix blanche', 'Concert anniversaire');

INSERT INTO TypeEvt(idType, typeEvt)
VALUES (1, 'concert');
INSERT INTO TypeEvt(idType, typeEvt)
VALUES (2, 'répétition');
INSERT INTO TypeEvt(idType, typeEvt)
VALUES (3, 'saison');

INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (1, 'Passion selon Saint Jean', 'BACH Johann Sebastian', 'BWV 245', '60', 'Religieux');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (2, 'Passion selon Saint Matthieu', 'BACH Johann Sebastian', 'BWV 244', '60', 'Religieux');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (3, 'Cantate', 'BACH Johann Sebastian', 'BWV 150', '60', 'Religieux');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (4, 'Requiem allemand', 'BRAHMS Johannes', '', '75', 'Religieux');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (5, 'Requiem', 'Mozart', '', '60', 'Religieux');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (6, 'Messe solenelle', 'Rossini', '', '60', 'Religieux');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (7, 'O magnum mysterium', 'Fabrice Gregorutti', '', '50', 'Religieux');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (8, 'Stabat Mater', 'Dvorak', '', '90', 'Renaissance');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (9, 'Le roi David', 'Honegger', '', '90', 'Renaissance');
INSERT INTO oeuvre(idoeuvre, titre, auteur, partition, duree, style)
VALUES (10, 'Chansson à boire', 'Poulenc', '', '45', 'Chansson à boire');


