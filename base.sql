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

-- Préfixes valables
INSERT INTO prefixe_operateur (prefixe) VALUES
    ('033'),
    ('037');

-- Clients de test
INSERT INTO utilisateur (numero, est_operateur, solde) VALUES
    ('0331234567', 0, 50000),
    ('0332345678', 0, 120000),
    ('0371112233', 0, 8000),
    ('0374445566', 0, 300000),
    ('0335556677', 0, 0);

-- Un compte opérateur (pour distinguer plus tard si besoin d'auth opérateur)
INSERT INTO utilisateur (numero, est_operateur, solde) VALUES
    ('0340000000', 1, 0);

-- Opérations de test (dépôt = id 1, retrait = id 2, transfert = id 3, cf seed existant)
-- Dépôts (gratuits)
INSERT INTO operation (id_type_operation, valeur, frais, envoyeur, destinataire, date_operation) VALUES
    (1, 50000, 0, NULL, 1, datetime('now', '-3 days')),
    (1, 100000, 0, NULL, 2, datetime('now', '-2 days')),
    (1, 300000, 0, NULL, 4, datetime('now', '-1 days'));

-- Retraits (avec frais selon barème)
INSERT INTO operation (id_type_operation, valeur, frais, envoyeur, destinataire, date_operation) VALUES
    (2, 5000, 50, 1, NULL, datetime('now', '-2 days')),
    (2, 20000, 200, 2, NULL, datetime('now', '-1 days')),
    (2, 3000, 50, 3, NULL, datetime('now')),
    (2, 100000, 800, 4, NULL, datetime('now'));

-- Transferts (avec frais selon barème)
INSERT INTO operation (id_type_operation, valeur, frais, envoyeur, destinataire, date_operation) VALUES
    (3, 10000, 100, 2, 3, datetime('now', '-1 days')),
    (3, 50000, 400, 4, 1, datetime('now')),
    (3, 2000, 50, 1, 3, datetime('now'));