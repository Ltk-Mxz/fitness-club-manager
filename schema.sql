CREATE TABLE abonnes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150),
    telephone VARCHAR(30),
    date_naissance DATE,
    adresse VARCHAR(255),
    code_postal VARCHAR(20),
    ville VARCHAR(100),
    pays VARCHAR(100),
    date_inscription DATE DEFAULT CURRENT_DATE,
    date_expiration DATE,
    photo VARCHAR(255),
    type_abonnement ENUM('mensuel', 'annuel') DEFAULT 'mensuel'
);

CREATE TABLE coachs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150),
    telephone VARCHAR(30),
    specialite VARCHAR(100),
    date_embauche DATE,
    photo VARCHAR(255)
);

CREATE TABLE disciplines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE equipements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    photo VARCHAR(255),
    etat VARCHAR(50)
);

CREATE TABLE paiements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    abonne_id INT NOT NULL,
    date_paiement DATE,
    montant DECIMAL(10,2),
    type_abonnement ENUM('mensuel', 'annuel'),
    mois INT,
    annee INT,
    statut ENUM('paye', 'impaye') DEFAULT 'impaye',
    FOREIGN KEY (abonne_id) REFERENCES abonnes(id) ON DELETE CASCADE
);

CREATE TABLE coach_affectations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    coach_id INT NOT NULL,
    discipline_id INT NOT NULL,
    mois INT,
    annee INT,
    FOREIGN KEY (coach_id) REFERENCES coachs(id) ON DELETE CASCADE,
    FOREIGN KEY (discipline_id) REFERENCES disciplines(id) ON DELETE CASCADE
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','manager') DEFAULT 'admin'
);
