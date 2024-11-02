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
VALUES
    ('bnj_rl', 'Turpin', 'Benjamin', 'BNJ', 'tkt@gmail.com', '', '', '2005-08-09',
        '$2y$10$ClZFPF3y4hhWXpsyw1uVnufRydQrPB8tJnkTSWKC.ywVhOuhugY2u', '1'),
    ('Yota002', 'Michaux', 'Alexis', 'Yota002', 'Yota002@gmail.com', '', '', '2005-04-02',
        '$2y$10$ClZFPF3y4hhWXpsyw1uVnufRydQrPB8tJnkTSWKC.ywVhOuhugY2u', '1'),
    ('Victoria02', 'Walenstein', 'Victoria', 'Viki02', 'viki02@gmail.com', '', '', '2005-05-02',
        '$2y$10$ClZFPF3y4hhWXpsyw1uVnufRydQrPB8tJnkTSWKC.ywVhOuhugY2u', '0'),
    ('Ilya84', 'Walenstein', 'Ilya', 'Lilya', 'lilya@gmail.com', '', '', '2005-06-02',
        '$2y$10$ClZFPF3y4hhWXpsyw1uVnufRydQrPB8tJnkTSWKC.ywVhOuhugY2u', '0');

INSERT INTO p_Coachs (idCoach, biographieCoach)
VALUES
    ('bnj_rl', 'Coach passionné de Rocket League avec plus de 5 ans d expérience dans l accompagnement de joueurs de tous niveaux. Spécialiste des stratégies de boost et des frappes aériennes, il aide ses élèves à maîtriser les compétences essentielles pour dominer le terrain. Fort de son expertise en défense et en contrôle, il propose des techniques précises pour améliorer chaque aspect du jeu.'),
    ('Yota002', 'Expert de League of Legends avec un style axé sur l optimisation de la prise de décision et la gestion des phases de laning. Avec plus de 1000 heures de coaching et de jeu compétitif, il accompagne les joueurs pour améliorer leur vision stratégique et leur prise de décision lors des combats d équipe. Son approche est méthodique et adaptée aux besoins de chaque élève, ce qui permet de progresser rapidement.'),
    ('Ilya84', 'Coach League of Legends attentif et motivé, spécialisé dans l analyse de parties et l optimisation du positionnement en jeu. Ilya aide les joueurs à perfectionner leur capacité à lire la carte et à réagir aux mouvements de l équipe adverse. Il met un point d honneur à développer la confiance et l autonomie de ses élèves, avec une pédagogie basée sur l expérience et les situations de jeu réelles.'),
    ('Victoria02', 'Coach avec une passion pour le détail et la perfection, spécialisée dans l analyse vidéo pour Rocket League et League of Legends. Elle aide les joueurs à comprendre les points d amélioration spécifiques grâce à des retours détaillés et des conseils adaptés. Sa pédagogie bienveillante et ses connaissances approfondies lui permettent d aider efficacement les joueurs débutants et intermédiaires à atteindre leurs objectifs.');

INSERT INTO p_Services (nomService, descriptionService, prixService, idCoach, nomJeu)
VALUES
    ('Rocket Boost Training', 'Apprenez les techniques avancées de boost pour dominer le terrain.', '35.0', 'bnj_rl', 'Rocket League'),
    ('Aerial Control Mastery', 'Améliorez votre maîtrise des frappes aériennes pour une précision optimale.', '40.0', 'bnj_rl', 'Rocket League'),
    ('Defensive Strategies', 'Comprenez les meilleures techniques défensives pour protéger votre but.', '30.0', 'Yota002', 'Rocket League');

INSERT INTO p_Services (nomService, descriptionService, prixService, idCoach, nomJeu)
VALUES
('League Lane Domination', 'Développez vos compétences en laning pour prendre l avantage en début de partie.', '27.5', 'Yota002', 'League of Legends'),
('Map Awareness Training', 'Apprenez à mieux lire la carte pour une vision stratégique complète.', '32.0', 'Yota002', 'League of Legends'),
('Teamfight Masterclass', 'Optimisez votre rôle dans les combats d équipe pour des victoires décisives.', '37.0', 'Ilya84', 'League of Legends');

INSERT INTO p_Services (nomService, descriptionService, prixService, idCoach, nomJeu)
VALUES
    ('Rocket League Game Review', 'Obtenez une analyse approfondie de votre partie pour améliorer votre jeu.', '20.0', 'bnj_rl', 'Rocket League'),
    ('LoL Game Review', 'Recevez des conseils basés sur une analyse détaillée de votre partie.', '22.5', 'Victoria02', 'League of Legends');

INSERT INTO p_Coachings (codeService, duree)
VALUES
    (3, 60),
    (4, 90),
    (5, 120);

INSERT INTO p_AnalysesVideo (codeService, nbJourRendu)
VALUES
    (6, 1),
    (7, 2);

