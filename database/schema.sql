-- Schéma bdd critiverse

-- Table users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table films
CREATE TABLE IF NOT EXISTS movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    release_year YEAR,
    genre VARCHAR(100),
    director VARCHAR(100),
    poster_url VARCHAR(500),
    trailer_url VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table series
CREATE TABLE IF NOT EXISTS tv_shows (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    release_year YEAR,
    genre VARCHAR(100),
    creator VARCHAR(100),
    poster_url VARCHAR(500),
    trailer_url VARCHAR(500),
    seasons INT DEFAULT 1,
    episodes INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table animes
CREATE TABLE IF NOT EXISTS animes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    title_japanese VARCHAR(255),
    description TEXT,
    release_year YEAR,
    genre VARCHAR(100),
    studio VARCHAR(100),
    poster_url VARCHAR(500),
    trailer_url VARCHAR(500),
    episodes INT DEFAULT 1,
    status ENUM('ongoing', 'completed', 'cancelled') DEFAULT 'completed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des critiques/avis
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    movie_id INT NULL,
    tv_show_id INT NULL,
    anime_id INT NULL,
    rating DECIMAL(2,1) CHECK (rating >= 0 AND rating <= 10),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Contraintes de clés étrangères
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (tv_show_id) REFERENCES tv_shows(id) ON DELETE CASCADE,
    FOREIGN KEY (anime_id) REFERENCES animes(id) ON DELETE CASCADE,

    -- Un utilisateur ne peut avoir qu'une critique par contenu
    UNIQUE KEY unique_user_content (user_id, movie_id),
    UNIQUE KEY unique_user_tv (user_id, tv_show_id),
    UNIQUE KEY unique_user_anime (user_id, anime_id)
);

-- Table des favoris
CREATE TABLE IF NOT EXISTS favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    movie_id INT NULL,
    tv_show_id INT NULL,
    anime_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (tv_show_id) REFERENCES tv_shows(id) ON DELETE CASCADE,
    FOREIGN KEY (anime_id) REFERENCES animes(id) ON DELETE CASCADE,

    UNIQUE KEY unique_user_fav_movie (user_id, movie_id),
    UNIQUE KEY unique_user_fav_tv (user_id, tv_show_id),
    UNIQUE KEY unique_user_fav_anime (user_id, anime_id)
);

-- Table des listes personnalisées
CREATE TABLE IF NOT EXISTS user_lists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table de liaison listes-contenus
CREATE TABLE IF NOT EXISTS list_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    list_id INT NOT NULL,
    movie_id INT NULL,
    tv_show_id INT NULL,
    anime_id INT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (list_id) REFERENCES user_lists(id) ON DELETE CASCADE,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (tv_show_id) REFERENCES tv_shows(id) ON DELETE CASCADE,
    FOREIGN KEY (anime_id) REFERENCES animes(id) ON DELETE CASCADE
);

-- Table des commentaires (sur les critiques)
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    review_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (review_id) REFERENCES reviews(id) ON DELETE CASCADE
);