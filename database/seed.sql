-- Données de test pour la bdd critiverse

-- Users de test
INSERT INTO users (pseudo, email, password) VALUES
('admin', 'admin@example.com', '$2y$10$Gp7qvTXPq7cS4G7oc19ebeZ5YwVR7lSmLVaKbJkJ.1TVtP6EJEHw2'),
('user1', 'user1@example.com', 'ia'),
('user2', 'user2@example.com', 'ai');

-- Films de test
INSERT INTO movies (title, description, release_year, genre, director, poster_url, trailer_url) VALUES
('Inception', 'Un voleur capable de pénétrer dans les rêves vole des secrets.', 2010, 'Science-Fiction', 'Christopher Nolan', 'https://example.com/posters/inception.jpg', 'https://www.youtube.com/watch?v=8hP9D6kZseM'),
('Le Voyage de Chihiro', 'Une jeune fille se retrouve piégée dans un monde magique peuplé d’esprits.', 2001, 'Animation', 'Hayao Miyazaki', 'https://example.com/posters/chihiro.jpg', 'https://www.youtube.com/watch?v=ByXuk9QqQkk');

-- Séries de test
INSERT INTO tv_shows (title, description, release_year, genre, creator, poster_url, trailer_url, seasons, episodes) VALUES
('Stranger Things', 'Des enfants affrontent des forces surnaturelles dans une petite ville.', 2016, 'Science-Fiction', 'The Duffer Brothers', 'https://example.com/posters/stranger_things.jpg', 'https://www.youtube.com/watch?v=b9EkMc79ZSU', 4, 34),
('Dark', 'Des disparitions et une mystérieuse boucle temporelle secouent une petite ville allemande.', 2017, 'Thriller', 'Baran bo Odar', 'https://example.com/posters/dark.jpg', 'https://www.youtube.com/watch?v=Df3nZkOlL4s', 3, 26);

-- Animes de test
INSERT INTO animes (title, title_japanese, description, release_year, genre, studio, poster_url, trailer_url, episodes, status) VALUES
('Attack on Titan', '進撃の巨人', 'L’humanité lutte contre des titans qui menacent leur existence.', 2013, 'Action', 'Wit Studio', 'https://example.com/posters/aot.jpg', 'https://www.youtube.com/watch?v=MGRm4IzK1SQ', 75, 'completed'),
('Demon Slayer', '鬼滅の刃', 'Un garçon devient chasseur de démons pour sauver sa sœur.', 2019, 'Fantasy', 'ufotable', 'https://example.com/posters/demonslayer.jpg', 'https://www.youtube.com/watch?v=VQGCKyvzIM4', 26, 'completed');

-- Critiques de test
INSERT INTO reviews (user_id, movie_id, rating, comment) VALUES
(1, 1, 9.5, 'Un film fascinant, visuellement incroyable et intelligent.'),
(2, 2, 10.0, 'Un chef-d’œuvre de l’animation japonaise.');

-- Favoris de test
INSERT INTO favorites (user_id, movie_id) VALUES
(1, 1),
(2, 2);

-- Listes personnalisées de test
INSERT INTO user_lists (user_id, name, description, is_public) VALUES
(1, 'Mes films préférés', 'Films que j’adore et que je recommande.', TRUE),
(2, 'Animés à voir', 'Animes à regarder bientôt.', FALSE);

-- Items de liste de test
INSERT INTO list_items (list_id, movie_id, anime_id) VALUES
(1, 1, NULL),
(2, NULL, 1);

-- Commentaires de test
INSERT INTO comments (user_id, review_id, content) VALUES
(2, 1, 'Je suis totalement d’accord, ce film est excellent !'),
(1, 2, 'Cette critique est très juste.');