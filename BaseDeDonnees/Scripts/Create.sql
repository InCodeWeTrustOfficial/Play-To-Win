CREATE OR REPLACE TABLE p_Utilisateurs (
    idUtilisateur VARCHAR(50),
    nom VARCHAR(50),
    prenom VARCHAR(50),
    pseudo VARCHAR(50),
    email VARCHAR(50),
    dateDeNaissance VARCHAR(50),
    mdp VARCHAR(50),
    avatar LONGBLOB,
    PRIMARY KEY(idUtilisateur)
);

CREATE OR REPLACE TABLE p_Langues (
    code_alpha VARCHAR(2),
    nom VARCHAR(50),
    drapeau LONGBLOB,
    PRIMARY KEY(code_alpha)
);

CREATE OR REPLACE TABLE p_Coach (
    idCoach VARCHAR(50),
    Biographie VARCHAR(50),
    Baniere LONGBLOB,
    PRIMARY KEY(idCoach)
);

CREATE OR REPLACE TABLE p_Services (
    code_service VARCHAR(50),
    nom VARCHAR(50),
    desciption TEXT,
    prix DECIMAL(15,2),
    nomJeux VARCHAR(50) NOT NULL,
    PRIMARY KEY(code_service)
);

CREATE OR REPLACE TABLE p_Coaching (
    code_service VARCHAR(50),
    duree DECIMAL(15,2),
    PRIMARY KEY(code_service)
);

CREATE OR REPLACE TABLE p_Analyse_video (
    code_service VARCHAR(50),
    Date_de_rendu SMALLINT,
    PRIMARY KEY(code_service)
);

CREATE OR REPLACE TABLE p_Classement_Info (
    idClassement INT AUTO_INCREMENT,
    nomClassement VARCHAR(50),
    division TINYINT,
    classement_avatar LONGBLOB,
    nomJeux VARCHAR(50) NOT NULL,
    PRIMARY KEY(idClassement, nomClassement, division, nomJeux)
);

CREATE OR REPLACE TABLE p_Jeux (
    nomJeux VARCHAR(50),
    logo LONGBLOB,
    PRIMARY KEY(nomJeux)
);

CREATE OR REPLACE TABLE p_Panier (
    idPanier INT AUTO_INCREMENT,
    Date_Achat DATE,
    idUtilisateur VARCHAR(50) NOT NULL,
    PRIMARY KEY(idPanier)
);

CREATE OR REPLACE TABLE p_Disponibilite (
    idDisponibilite INT AUTO_INCREMENT,
    DatesDebut DATETIME NOT NULL,
    DateFin DATETIME,
    PRIMARY KEY(idDisponibilite)
);

CREATE OR REPLACE TABLE p_Mode (
    nomMode VARCHAR(50),
    nomClassement VARCHAR(50),
    division TINYINT,
    idClassement INT,
    nomClassement_1 VARCHAR(50) NOT NULL,
    division_1 TINYINT NOT NULL,
    nomJeux VARCHAR(50) NOT NULL,
    idUtilisateur VARCHAR(50) NOT NULL,
    PRIMARY KEY(nomMode)
);

CREATE OR REPLACE TABLE p_Exemplaire_Service (
    idExemplaire INT AUTO_INCREMENT,
    Etat VARCHAR(50),
    idPanier INT NOT NULL,
    code_service VARCHAR(50) NOT NULL,
    PRIMARY KEY(idExemplaire)
);

CREATE OR REPLACE TABLE p_Parler (
    idUtilisateur VARCHAR(50),
    code_alpha VARCHAR(2),
    PRIMARY KEY(idUtilisateur, code_alpha)
);

CREATE OR REPLACE TABLE p_ProposerService (
    idCoach VARCHAR(50),
    code_service VARCHAR(50),
    PRIMARY KEY(idCoach, code_service)
);

CREATE OR REPLACE TABLE p_avoir_disponibilite (
    idCoach VARCHAR(50),
    idDisponibilite INT,
    PRIMARY KEY(idCoach, idDisponibilite)
);

CREATE OR REPLACE TABLE p_Avoir_dispo (
    idExemplaire INT,
    idDisponibilite INT,
    PRIMARY KEY(idExemplaire, idDisponibilite)
);