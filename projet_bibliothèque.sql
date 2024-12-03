-- Création de la table des articles
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    statut VARCHAR(50) CHECK (statut IN ('disponible', 'emprunté'))
);

-- Insertion d'un article
INSERT INTO articles (titre, statut) VALUES ('Le Petit Prince', 'disponible');

-- Création de la table des livres
CREATE TABLE livres (
    id INT PRIMARY KEY,
    auteur VARCHAR(255) NOT NULL,
    isbn INT NOT NULL,
    FOREIGN KEY (id) REFERENCES articles(id) ON DELETE CASCADE
);

-- Insertion d'un livre
INSERT INTO livres (id, auteur, isbn) VALUES (1, 'Antoine de Saint-Exupéry', 123456789);

-- Création de la table des CDs
CREATE TABLE cds (
    id INT PRIMARY KEY,
    duree INT NOT NULL, -- Durée en minutes
    FOREIGN KEY (id) REFERENCES articles(id) ON DELETE CASCADE
);

-- Création de la table des DVDs
CREATE TABLE dvds (
    id INT PRIMARY KEY,
    duree INT NOT NULL, -- Durée en minutes
    FOREIGN KEY (id) REFERENCES articles(id) ON DELETE CASCADE
);

-- Création de la table des membres
CREATE TABLE membres (
    idMembre INT AUTO_INCREMENT PRIMARY KEY,
    prenom VARCHAR(100),
    nom VARCHAR(100),
    adresse VARCHAR(255),
    telephone VARCHAR(20),
    email VARCHAR(100)
);

-- Insertion d'un membre
INSERT INTO membres (prenom, nom, adresse, telephone, email) 
VALUES ('Jean', 'Dupont', '123 Rue Principale', '77 674 31 23', 'jean.dupont@gmail.com');

-- Création de la table des comptes
CREATE TABLE comptes (
    idCompte INT AUTO_INCREMENT PRIMARY KEY,
    idMembre INT,
    dateCreation DATE,
    FOREIGN KEY (idMembre) REFERENCES membres(idMembre) ON DELETE CASCADE
);

-- Insertion d'un compte
INSERT INTO comptes (idMembre, dateCreation) 
VALUES (1, '2024-01-01');

-- Création de la table des emprunts
CREATE TABLE emprunts (
    idEmprunt INT AUTO_INCREMENT PRIMARY KEY,
    idMembre INT,
    idArticle INT,
    dateEmprunt DATE,
    dateRetour DATE,
    FOREIGN KEY (idMembre) REFERENCES membres(idMembre) ON DELETE CASCADE,
    FOREIGN KEY (idArticle) REFERENCES articles(id) ON DELETE CASCADE
);

-- Insertion d'un emprunt
INSERT INTO emprunts (idMembre, idArticle, dateEmprunt, dateRetour) 
VALUES (1, 1, '2024-01-15', NULL);
