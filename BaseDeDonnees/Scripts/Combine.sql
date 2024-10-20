-- Suppression des tables en cascade
DROP TABLE IF EXISTS p_Avoir_dispo CASCADE;
DROP TABLE IF EXISTS p_avoir_disponibilite CASCADE;
DROP TABLE IF EXISTS p_ProposerService CASCADE;
DROP TABLE IF EXISTS p_Parler CASCADE;
DROP TABLE IF EXISTS p_Exemplaire_Service CASCADE;
DROP TABLE IF EXISTS p_Mode CASCADE;
DROP TABLE IF EXISTS Disponibilite CASCADE;
DROP TABLE IF EXISTS p_Panier CASCADE;
DROP TABLE IF EXISTS p_Classement_Info CASCADE;
DROP TABLE IF EXISTS p_Analyse_video CASCADE;
DROP TABLE IF EXISTS p_Coaching CASCADE;
DROP TABLE IF EXISTS p_Services CASCADE;
DROP TABLE IF EXISTS p_Coach CASCADE;
DROP TABLE IF EXISTS p_Langues CASCADE;
DROP TABLE IF EXISTS p_Jeux CASCADE;
DROP TABLE IF EXISTS p_Utilisateurs CASCADE;

CREATE TABLE IF NOT EXISTS p_Utilisateurs (
    idUtilisateur VARCHAR(32),
    nom VARCHAR(32),
    prenom VARCHAR(32),
    pseudo VARCHAR(32),
    email VARCHAR(256),
    emailAValider VARCHAR(256),
    nonce VARCHAR(32),
    dateDeNaissance DATE,
    mdpHache VARCHAR(256),
    avatar LONGBLOB,
    PRIMARY KEY(idUtilisateur)
    );

CREATE TABLE IF NOT EXISTS p_Langues (
    code_alpha VARCHAR(2),
    nom VARCHAR(50),
    drapeau LONGBLOB,
    PRIMARY KEY(code_alpha)
    );

CREATE TABLE IF NOT EXISTS p_Coachs (
    idCoach VARCHAR(32),
    BiographieCoach VARCHAR(50),
    BaniereCoach VARCHAR(50),
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

-- p_Coach
ALTER TABLE p_Coach ADD CONSTRAINT fk_coach_utilisateur
    FOREIGN KEY (idCoach) REFERENCES p_Utilisateurs(idUtilisateur);

-- p_Services
ALTER TABLE p_Services ADD CONSTRAINT fk_services_jeux
    FOREIGN KEY (nomJeux) REFERENCES p_Jeux(nomJeux);

-- p_Coaching
ALTER TABLE p_Coaching ADD CONSTRAINT fk_coaching_service
    FOREIGN KEY (code_service) REFERENCES p_Services(code_service);

-- p_Analyse_video
ALTER TABLE p_Analyse_video ADD CONSTRAINT fk_analyse_service
    FOREIGN KEY (code_service) REFERENCES p_Services(code_service);

-- p_Classement_Info
ALTER TABLE p_Classement_Info ADD CONSTRAINT fk_classement_jeux
    FOREIGN KEY (nomJeux) REFERENCES p_Jeux(nomJeux);

-- p_Panier
ALTER TABLE p_Panier ADD CONSTRAINT fk_panier_utilisateur
    FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur);

-- p_Mode
ALTER TABLE p_Mode ADD CONSTRAINT fk_mode_classement1
    FOREIGN KEY (idClassement) REFERENCES p_Classement_Info(idClassement);

ALTER TABLE p_Mode ADD CONSTRAINT fk_mode_classement2
    FOREIGN KEY (idClassement) REFERENCES p_Classement_Info(idClassement);

ALTER TABLE p_Mode ADD CONSTRAINT fk_mode_jeux
    FOREIGN KEY (nomJeux) REFERENCES p_Jeux(nomJeux);

ALTER TABLE p_Mode ADD CONSTRAINT fk_mode_utilisateur
    FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur);

-- p_Exemplaire_Service
ALTER TABLE p_Exemplaire_Service ADD CONSTRAINT fk_exemplaire_service
    FOREIGN KEY (code_service) REFERENCES p_Services(code_service);

ALTER TABLE p_Exemplaire_Service ADD CONSTRAINT fk_exemplaire_panier
    FOREIGN KEY (idPanier) REFERENCES p_Panier(idPanier);

-- p_Parler
ALTER TABLE p_Parler ADD CONSTRAINT fk_parler_utilisateur
    FOREIGN KEY (idUtilisateur) REFERENCES p_Utilisateurs(idUtilisateur);

ALTER TABLE p_Parler ADD CONSTRAINT fk_parler_langue
    FOREIGN KEY (code_alpha) REFERENCES p_Langues(code_alpha);

-- p_ProposerService
ALTER TABLE p_ProposerService ADD CONSTRAINT fk_utilisateur_service
    FOREIGN KEY (idCoach) REFERENCES p_Coach(idCoach);

ALTER TABLE p_ProposerService ADD CONSTRAINT fk_service_utilisateur
    FOREIGN KEY (code_service) REFERENCES p_Services(code_service);

-- p_avoir_disponibilite
ALTER TABLE p_avoir_disponibilite ADD CONSTRAINT fk_utilisateur_disponibilite
    FOREIGN KEY (idCoach) REFERENCES p_Coach(idCoach);

ALTER TABLE p_avoir_disponibilite ADD CONSTRAINT fk_disponibilite_utilisateur
    FOREIGN KEY (idDisponibilite) REFERENCES p_Disponibilite(idDisponibilite);

-- p_Avoir_dispo
ALTER TABLE p_Avoir_dispo ADD CONSTRAINT fk_exemplaire_disponibilite
    FOREIGN KEY (idExemplaire) REFERENCES p_Exemplaire_Service(idExemplaire);

ALTER TABLE p_Avoir_dispo ADD CONSTRAINT fk_disponibilite_exemplaire
    FOREIGN KEY (idDisponibilite) REFERENCES p_Disponibilite(idDisponibilite);