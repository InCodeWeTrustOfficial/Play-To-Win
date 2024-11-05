INSERT INTO p_Jeux (codeJeu,nomJeu) VALUES
('lol','League of Legends'),
('rl','Rocket League');

INSERT INTO p_ModesDeJeu (nomMode) VALUES
('1v1'),
('2V2'),
('3V3'),
('Faille de l''invocateur');

INSERT INTO p_Classements (idClassement,nomClassement,divisionClassement,acronyme)
VALUES
       -- League of Legends
       ('1', 'Fer', '4','fe'),
       ('2', 'Fer', '3','fe'),
       ('3', 'Fer', '2','fe'),
       ('4', 'Fer', '1','fe'),
       ('5', 'Bronze', '4','brz'),
       ('6', 'Bronze', '3','brz'),
       ('7', 'Bronze', '2','brz'),
       ('8', 'Bronze', '1','brz'),
       ('9', 'Argent', '4','arg'),
       ('10', 'Argent', '3','arg'),
       ('11', 'Argent', '2','arg'),
       ('12', 'Argent', '1','arg'),
       ('13', 'Or', '4','or'),
       ('14', 'Or', '3','or'),
       ('15', 'Or', '2','or'),
       ('16', 'Or', '1','or'),
       ('17', 'Platine', '4','plat'),
       ('18', 'Platine', '3','plat'),
       ('19', 'Platine', '2','plat'),
       ('20', 'Platine', '1','plat'),
       ('21', 'Diamant', '4','diam'),
       ('22', 'Diamant', '3','diam'),
       ('23', 'Diamant', '2','diam'),
       ('24', 'Diamant', '1','diam'),
       ('25', 'Émeraude', '4','eme'),
       ('26', 'Émeraude', '3','eme'),
       ('27', 'Émeraude', '2','eme'),
       ('28', 'Émeraude', '1','eme'),
       ('29', 'Maitre', '0','mai'),
       ('30', 'Grand Maitre', '0','gm'),
       ('31', 'Challenger', '0','chal'),
       -- Rocket League
       ('32', 'Champion', '1','chmp'),
       ('33', 'Champion', '2','chmp'),
       ('34', 'Champion', '3','chmp'),
       ('35', 'Grand Champion', '1','gc'),
       ('36', 'Grand Champion', '2','gc'),
       ('37', 'Grand Champion', '3','gc'),
       ('38', 'Supersonic Legend', '0','ssl');

INSERT INTO p_avoirMode (nomMode, codeJeu)
VALUES ('1v1','rl'),
       ('2V2','rl'),
       ('3V3','rl'),
       ('Faille de l''invocateur','lol');

INSERT INTO p_seClasser (idClassement, codeJeu, eloMin, eloMax)
VALUES ('1','lol','0','100'),
       ('2','lol','0','100'),
       ('3','lol','0','100'),
       ('4','lol','0','100'),
       ('5','lol','0','100'),
       ('6','lol','0','100'),
       ('7','lol','0','100'),
       ('8','lol','0','100'),
       ('9','lol','0','100'),
       ('10','lol','0','100'),
       ('11','lol','0','100'),
       ('12','lol','0','100'),
       ('13','lol','0','100'),
       ('14','lol','0','100'),
       ('15','lol','0','100'),
       ('16','lol','0','100'),
       ('17','lol','0','100'),
       ('18','lol','0','100'),
       ('19','lol','0','100'),
       ('20','lol','0','100'),
       ('21','lol','0','100'),
       ('22','lol','0','100'),
       ('23','lol','0','100'),
       ('24','lol','0','100'),
       ('25','lol','0','100'),
       ('26','lol','0','100'),
       ('27','lol','0','100'),
       ('28','lol','0','100'),
       ('29','lol','0','100'),
       ('30','lol','0','100'),
       ('31','lol','0','100'),

       ('8','rl','0','173'),
       ('7','rl','174','229'),
       ('6','rl','230','289'),
       ('12','rl','290','352'),
       ('11','rl','353','408'),
       ('10','rl','409','463'),
       ('16','rl','464','526'),
       ('15','rl','527','594'),
       ('14','rl','595','652'),
       ('20','rl','653','706'),
       ('19','rl','707','774'),
       ('18','rl','775','829'),
       ('24','rl','830','900'),
       ('23','rl','901','992'),
       ('22','rl','993','1065'),
       ('32','rl','1066','1180'),
       ('33','rl','1181','1305'),
       ('34','rl','1306','1414'),
       ('35','rl','1415','1574'),
       ('36','rl','1575','1714'),
       ('37','rl','1715','1874'),
       ('38','rl','1875','2700');


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

INSERT INTO p_Parler (idUtilisateur, code_alpha)
VALUES
    ('bnj_rl','FR'),
    ('Yota002','FR'),
    ('Victoria02','DE'),
    ('Victoria02','IT'),
    ('Ilya84','KR');

INSERT INTO p_jouer (codeJeu, idUtilisateur, nomMode, idClassement)
VALUES
    ('rl','bnj_rl','2v2','38'),
    ('lol','Yota002', 'Faille de l''invocateur','31'),
    ('lol','Victoria02','Faille de l''invocateur','19'),
    ('lol','Ilya84','Faille de l''invocateur','15');

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