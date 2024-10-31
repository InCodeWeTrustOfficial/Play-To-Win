INSERT INTO p_Jeux (codeJeu,nomJeu) VALUES
('lol','League of Legends'),
('rl','Rocket League');

INSERT INTO p_ModesDeJeu (nomMode) VALUES
('1v1'),
('2V2'),
('3V3'),
('Faille de l''invocateur');

INSERT INTO p_Classements (idClassement,nomClassement,divisionClassement)
VALUES
       -- League of Legends
       ('1', 'Fer', '4'),
       ('2', 'Fer', '3'),
       ('3', 'Fer', '2'),
       ('4', 'Fer', '1'),
       ('5', 'Bronze', '4'),
       ('6', 'Bronze', '3'),
       ('7', 'Bronze', '2'),
       ('8', 'Bronze', '1'),
       ('9', 'Argent', '4'),
       ('10', 'Argent', '3'),
       ('11', 'Argent', '2'),
       ('12', 'Argent', '1'),
       ('13', 'Or', '4'),
       ('14', 'Or', '3'),
       ('15', 'Or', '2'),
       ('16', 'Or', '1'),
       ('17', 'Platine', '4'),
       ('18', 'Platine', '3'),
       ('19', 'Platine', '2'),
       ('20', 'Platine', '1'),
       ('21', 'Diamant', '4'),
       ('22', 'Diamant', '3'),
       ('23', 'Diamant', '2'),
       ('24', 'Diamant', '1'),
       ('25', 'Émeraude', '4'),
       ('26', 'Émeraude', '3'),
       ('27', 'Émeraude', '2'),
       ('28', 'Émeraude', '1'),
       ('29', 'Maitre', '1'),
       ('30', 'Grand Maitre', '1'),
       ('31', 'Challenger', '1'),
       -- Rocket League
       ('32', 'Champion', '1'),
       ('33', 'Champion', '2'),
       ('34', 'Champion', '3'),
       ('35', 'Grand Champion', '1'),
       ('36', 'Grand Champion', '2'),
       ('37', 'Grand Champion', '3'),
       ('38', 'Supersonic Legend', '1');

INSERT INTO p_avoirMode (nomMode, codeJeu)
VALUES ('1v1','rl'),
       ('2V2','rl'),
       ('3V3','rl'),
       ('Faille de l''invocateur','lol');

INSERT INTO p_seClasse (idClassement, codeJeu, place)
VALUES ('1','lol','1'),
       ('2','lol','2'),
       ('3','lol','3'),
       ('4','lol','4'),
       ('5','lol','5'),
       ('6','lol','6'),
       ('7','lol','7'),
       ('8','lol','8'),
       ('9','lol','9'),
       ('10','lol','10'),
       ('11','lol','11'),
       ('12','lol','12'),
       ('13','lol','13'),
       ('14','lol','14'),
       ('15','lol','15'),
       ('16','lol','16'),
       ('17','lol','17'),
       ('18','lol','18'),
       ('19','lol','19'),
       ('20','lol','20'),
       ('21','lol','21'),
       ('22','lol','22'),
       ('23','lol','23'),
       ('24','lol','24'),
       ('25','lol','25'),
       ('26','lol','26'),
       ('27','lol','27'),
       ('28','lol','28'),
       ('29','lol','29'),
       ('30','lol','30'),
       ('31','lol','31'),

       ('8','rl','1'),
       ('7','rl','2'),
       ('6','rl','3'),
       ('12','rl','4'),
       ('11','rl','5'),
       ('10','rl','6'),
       ('16','rl','7'),
       ('15','rl','8'),
       ('14','rl','9'),
       ('20','rl','10'),
       ('19','rl','11'),
       ('18','rl','12'),
       ('24','rl','13'),
       ('23','rl','14'),
       ('22','rl','15'),
       ('32','rl','16'),
       ('33','rl','17'),
       ('34','rl','18'),
       ('35','rl','19'),
       ('36','rl','20'),
       ('37','rl','21'),
       ('38','rl','22');


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


INSERT INTO p_Services (nomService, descriptionService, prixService, idCoach, codeJeu)
VALUES
    ('Rocket Boost Training', 'Apprenez les techniques avancées de boost pour dominer le terrain.', '35.0', 'bnj_rl', 'rl'),
    ('Aerial Control Mastery', 'Améliorez votre maîtrise des frappes aériennes pour une précision optimale.', '40.0', 'bnj_rl', 'rl'),
    ('Defensive Strategies', 'Comprenez les meilleures techniques défensives pour protéger votre but.', '30.0', 'Yota002', 'rl');


INSERT INTO p_Services (nomService, descriptionService, prixService, idCoach, codeJeu)
VALUES
('League Lane Domination', 'Développez vos compétences en laning pour prendre l avantage en début de partie.', '27.5', 'Yota002', 'lol'),
('Map Awareness Training', 'Apprenez à mieux lire la carte pour une vision stratégique complète.', '32.0', 'Yota002', 'lol'),
('Teamfight Masterclass', 'Optimisez votre rôle dans les combats d équipe pour des victoires décisives.', '37.0', 'Ilya84', 'lol');

INSERT INTO p_Services (nomService, descriptionService, prixService, idCoach, codeJeu)
VALUES
    ('Rocket League Game Review', 'Obtenez une analyse approfondie de votre partie pour améliorer votre jeu.', '20.0', 'bnj_rl', 'rl'),
    ('LoL Game Review', 'Recevez des conseils basés sur une analyse détaillée de votre partie.', '22.5', 'Victoria02', 'lol');

INSERT INTO p_Coachings (codeService, duree)
VALUES
    (3, 60),
    (4, 90),
    (5, 120);

INSERT INTO p_AnalysesVideo (codeService, nbJourRendu)
VALUES
    (6, 1),
    (7, 2);