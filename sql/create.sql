DROP TABLE IF EXISTS Responsabilite CASCADE;
DROP TABLE IF EXISTS Choriste CASCADE;
DROP TABLE IF EXISTS Inscription CASCADE;
DROP TABLE IF EXISTS Utilisateur CASCADE;
DROP TABLE IF EXISTS endosse CASCADE;
DROP TABLE IF EXISTS Voix CASCADE;
DROP TABLE IF EXISTS Evenement CASCADE;
DROP TABLE IF EXISTS TypeEvt CASCADE;
DROP TABLE IF EXISTS participe CASCADE;
DROP TABLE IF EXISTS Oeuvre CASCADE;
DROP TABLE IF EXISTS est_au_programme CASCADE;

--CREATE EXTENSION pgcrypto;

create table Utilisateur (
    login varchar(200),
    motdepasse text NOT NULL,
    constraint pk_utilisateur PRIMARY KEY(login)
);

create table Responsabilite (
    id serial,
    titre varchar(30),
    constraint pk_id PRIMARY KEY(id)
);

create table endosse (
    login varchar(200),
    id smallint unique,
    constraint pk_endosse PRIMARY KEY (id),
    constraint fk_utilisateur foreign key (login) references Utilisateur (login) ON DELETE CASCADE,
    constraint fk_responsabilite foreign key (id) references Responsabilite (id) ON DELETE CASCADE
);

create table Inscription (
    idInscription serial,
    typeInscription varchar(30) NOT NULL,
    montant decimal NOT NULL,
    annee varchar(10) NOT NULL,
    validation smallint DEFAULT 0,
    constraint pk_idInscription PRIMARY KEY(idInscription)
);

create table Voix (
    idVoix serial,
    typeVoix varchar(200) NOT NULL,
    constraint pk_idVoix PRIMARY KEY(idVoix)
);

create table Choriste (
    idChoriste serial,
    nom varchar(200) NOT NULL,
    prenom varchar(200) NOT NULL,
    idVoix smallint DEFAULT NULL,
    ville varchar(200) NOT NULL,
    telephone varchar(30) NOT NULL,
    login varchar(200) NOT NULL,
    idInscription smallint,
    constraint pk_idChoriste PRIMARY KEY(idChoriste),
    constraint fk_utilisateur foreign key (login) references Utilisateur (login) ON DELETE CASCADE,
    constraint fk_voix foreign key (idVoix) references Voix (idVoix) ON DELETE CASCADE,
    constraint fk_inscription foreign key (idInscription) references Inscription (idInscription)
);

create table TypeEvt (
    idType serial,
    typeEvt varchar(200) NOT NULL,
    constraint pk_idType PRIMARY KEY(idType)
);

create table Evenement (
    idEvenement serial,
    idType smallint NOT NULL,
    heureDate timestamp NOT NULL,
    lieu varchar(200) NOT NULL,
    nom varchar(200) NOT NULL,
    constraint pk_idEvenement PRIMARY KEY(idEvenement),
    constraint fk_typeEvt foreign key (idType) references TypeEvt (idType) ON DELETE CASCADE
);

-- confirmation: 0 indécis et 1 présent. Aucun tuple = absent
create table participe (
    idChoriste serial,
    idEvenement smallint NOT NULL,
    confirmation smallint DEFAULT 0 NOT NULL,
    constraint pk_participe PRIMARY KEY (idChoriste, idEvenement),
    constraint fk_participe_choriste foreign key (idChoriste) references Choriste (idChoriste) ON DELETE CASCADE,
    constraint fk_participe_evenement foreign key (idEvenement) references Evenement (idEvenement) ON DELETE CASCADE
);

create table Oeuvre (
    idOeuvre serial,
    titre varchar(200),
    auteur varchar(200),
    partition varchar(200),
    duree smallint,
    style varchar(200),
    constraint pk_oeuvre PRIMARY KEY (idOeuvre)
);

create table est_au_programme (
    idOeuvre smallint,
    idEvenement smallint,
    constraint pk_est_au_programme PRIMARY KEY (idOeuvre, idEvenement),
    constraint fk_programme_oeuvre foreign key (idOeuvre) references Oeuvre (idOeuvre) ON DELETE CASCADE,
    constraint fk_programme_evenement foreign key (idEvenement) references Evenement (idEvenement) ON DELETE CASCADE
);
