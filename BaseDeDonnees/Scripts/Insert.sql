INSERT INTO p_Jeux (nomJeu) VALUES
('League of Legends'),
('Rocket League');

INSERT INTO p_Classements (idClassement,nomClassement,divisionClassement)
VALUES
       -- League of Legends
       ('L-1', 'Fer', '4'),
       ('L-2', 'Fer', '3'),
       ('L-3', 'Fer', '2'),
       ('L-4', 'Fer', '1'),
       ('L-5', 'Bronze', '4'),
       ('L-6', 'Bronze', '3'),
       ('L-7', 'Bronze', '2'),
       ('L-8', 'Bronze', '1'),
       ('L-9', 'Argent', '4'),
       ('L-10', 'Argent', '3'),
       ('L-11', 'Argent', '2'),
       ('L-12', 'Argent', '1'),
       ('L-13', 'Or', '4'),
       ('L-14', 'Or', '3'),
       ('L-15', 'Or', '2'),
       ('L-16', 'Or', '1'),
       ('L-17', 'Platine', '4'),
       ('L-18', 'Platine', '3'),
       ('L-19', 'Platine', '2'),
       ('L-20', 'Platine', '1'),
       ('L-21', 'Diamant', '4'),
       ('L-22', 'Diamant', '3'),
       ('L-23', 'Diamant', '2'),
       ('L-24', 'Diamant', '1'),
       ('L-25', 'Émeraude', '4'),
       ('L-26', 'Émeraude', '3'),
       ('L-27', 'Émeraude', '2'),
       ('L-28', 'Émeraude', '1'),
       ('L-29', 'Maitre', '1'),
       ('L-30', 'Grand Maitre', '1'),
       ('L-31', 'Challenger', '1'),
       -- Rocket League
       ('R-1', 'Bronze', '1'),
       ('R-2', 'Bronze', '2'),
       ('R-3', 'Bronze', '3'),
       ('R-4', 'Argent', '1'),
       ('R-5', 'Argent', '2'),
       ('R-6', 'Argent', '3'),
       ('R-7', 'Or', '1'),
       ('R-8', 'Or', '2'),
       ('R-9', 'Or','3'),
       ('R-10', 'Platine', '1'),
       ('R-11', 'Platine', '2'),
       ('R-12', 'Platine', '3'),
       ('R-13', 'Diamant', '1'),
       ('R-14', 'Diamant', '2'),
       ('R-15', 'Diamant', '3'),
       ('R-16', 'Champion', '1'),
       ('R-17', 'Champion', '2'),
       ('R-18', 'Champion', '3'),
       ('R-19', 'Grand Champion', '1'),
       ('R-20', 'Grand Champion', '2'),
       ('R-21', 'Grand Champion', '3'),
       ('R-22', 'Supersonic Legend', '1');


INSERT INTO p_Langues (code_alpha, nom) VALUES
('EN', 'Anglais'),
('CN', 'Chinois'),
('ES', 'Espagnol'),
('FR', 'Français'),
('AR', 'Arabe'),
('PT', 'Portuguais'),
('DE', 'Allemand'),
('JP', 'Japonais'),
('KR', 'Coreen'),
('IT', 'Italien');

INSERT INTO p_Utilisateurs (idUtilisateur, nom, prenom, pseudo, email, emailAValider, nonce, dateDeNaissance, mdpHache,estAdmin)
VALUES ('bnj_rl', 'Turpin', 'Benjamin', 'BNJ', 'tkt@gmail.com', '', '', '2005-08-09',
        '$2y$10$ClZFPF3y4hhWXpsyw1uVnufRydQrPB8tJnkTSWKC.ywVhOuhugY2u', '1');

INSERT INTO p_Utilisateurs (idUtilisateur, nom, prenom, pseudo, email, emailAValider, nonce, dateDeNaissance, mdpHache,estAdmin)
VALUES ('Yota002', 'Michaux', 'Alexis', 'Yota002', 'Yota002@gmail.com', '', '', '2005-04-02',
        '$2y$10$ClZFPF3y4hhWXpsyw1uVnufRydQrPB8tJnkTSWKC.ywVhOuhugY2u', '1');

INSERT INTO p_Coachs (idCoach, biographieCoach)
VALUES ('bnj_rl', '1234');

INSERT INTO p_Coachs (idCoach, biographieCoach)
VALUES ('Yota002', '4321');

INSERT INTO p_Services (nomService, descriptionService, prixService, idCoach, nomJeu)
VALUES ('Test', 'Test description', '30.0', 'bnj_rl', 'Rocket League');

INSERT INTO p_Services (nomService, descriptionService, prixService, idCoach, nomJeu)
VALUES ('Testlol', 'Test description', '25.0', 'Yota002', 'League of Legends');

INSERT INTO p_Coachings (codeService, duree)
VALUES (1, 120);

INSERT INTO p_AnalysesVideo (codeService, nbJourRendu)
VALUES (2, 2);
