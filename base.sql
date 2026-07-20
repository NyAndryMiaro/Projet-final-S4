PRAGMA foreign_keys = ON;

CREATE TABLE IF NOT EXISTS prefixe_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS utilisateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero TEXT UNIQUE NOT NULL,
    est_operateur BOOLEAN DEFAULT 0,
    solde REAL DEFAULT 0.0
);

CREATE TABLE IF NOT EXISTS type_operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_type_operation INTEGER REFERENCES type_operation(id),
    valeur REAL NOT NULL,
    frais REAL DEFAULT 0.0,
    envoyeur INTEGER REFERENCES utilisateur(id),
    destinataire INTEGER REFERENCES utilisateur(id),
    date_operation DATETIME DEFAULT (datetime('now', 'localtime'))
);

CREATE TABLE IF NOT EXISTS bareme (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    born_inf REAL NOT NULL,
    born_sup REAL NOT NULL,
    valeur REAL NOT NULL
);

INSERT INTO type_operation (nom) VALUES 
    ('dépôt'), 
    ('retrait'), 
    ('transfert');

INSERT INTO bareme (born_inf, born_sup, valeur) VALUES
    (100, 1000, 50),
    (1001, 5000, 50),
    (5001, 10000, 100),
    (10001, 25000, 200),
    (25001, 50000, 400),
    (50001, 100000, 800),
    (100001, 250000, 1500),
    (250001, 500000, 1500),
    (500001, 1000000, 2500),
    (1000001, 2000000, 3000);