-- Création des nouvelles tables avec CREATE OR REPLACE
CREATE TABLE IF NOT EXISTS p_Jeux (
    nomJeu VARCHAR(50),
    logoJeu LONGBLOB,
    PRIMARY KEY(nomJeu)
);

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

CREATE TABLE IF NOT EXISTS p_ModesDeJeu (
    nomMode VARCHAR(50),
    PRIMARY KEY(nomMode)
);

CREATE TABLE IF NOT EXISTS p_Classements (
    idClassement VARCHAR(50),
    nomClassement VARCHAR(50),
    divisionClassement VARCHAR(50),
    avatarClassement LONGBLOB,
    PRIMARY KEY(idClassement, nomClassement, divisionClassement)
);

CREATE TABLE IF NOT EXISTS p_Disponibilites (
    idDisponibilite VARCHAR(50),
    dateDebut DATE,
    dateFin DATE,
    PRIMARY KEY(idDisponibilite)
);

CREATE TABLE IF NOT EXISTS p_Panier (
    idPanier VARCHAR(50),
    dateAchatPanier VARCHAR(50),
    idUtilisateur INT NOT NULL,
    PRIMARY KEY(idPanier)
);

CREATE TABLE IF NOT EXISTS p_ExemplaireService (
    idExemplaire VARCHAR(50),
    etatService VARCHAR(50),
    idPanier VARCHAR(50) NOT NULL,
    codeService VARCHAR(50) NOT NULL,
    PRIMARY KEY(idExemplaire)
);

CREATE TABLE IF NOT EXISTS p_Coachings (
    codeService VARCHAR(50),
    nomService VARCHAR(50),
    descriptionService TEXT,
    prixService VARCHAR(50),
    idUtilisateur INT NOT NULL,
    nomJeu VARCHAR(50) NOT NULL,
    duree VARCHAR(50),
    PRIMARY KEY(codeService)
);

CREATE TABLE IF NOT EXISTS p_AnalysesVideo (
    codeService VARCHAR(50),
    nomService VARCHAR(50),
    descriptionService TEXT,
    prixService VARCHAR(50),
    idUtilisateur INT NOT NULL,
    nomJeu VARCHAR(50) NOT NULL,
    tempsMaxRendu DATE,
    PRIMARY KEY(codeService)
);

CREATE TABLE IF NOT EXISTS p_Parler (
    idUtilisateur INT,
    code_alpha VARCHAR(2),
    PRIMARY KEY(idUtilisateur, code_alpha)
);

CREATE TABLE IF NOT EXISTS p_jouer (
    nomJeu VARCHAR(50),
    idUtilisateur INT,
    nomMode VARCHAR(50),
    idClassement VARCHAR(50) NOT NULL,
    nomClassement VARCHAR(50) NOT NULL,
    divisionClassement VARCHAR(50) NOT NULL,
    PRIMARY KEY(nomJeu, idUtilisateur, nomMode)
);

CREATE TABLE IF NOT EXISTS p_avoirDisponibiliteCoach (
    idUtilisateur INT,
    idDisponibilite VARCHAR(50),
    PRIMARY KEY(idUtilisateur, idDisponibilite)
);

CREATE TABLE IF NOT EXISTS p_avoirDisponibiliteService (
    idDisponibilite VARCHAR(50),
    idExemplaire VARCHAR(50),
    PRIMARY KEY(idDisponibilite, idExemplaire)
);
