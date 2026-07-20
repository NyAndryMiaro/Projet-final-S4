PRAGMA foreign_keys = ON;

-- 1. Tables de base
CREATE TABLE IF NOT EXISTS prefixe_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS utilisateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero TEXT UNIQUE NOT NULL,
    est_operateur BOOLEAN DEFAULT 0,
    solde REAL DEFAULT 0.0
);

CREATE TABLE IF NOT EXISTS type_operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL UNIQUE
);

-- 2. Barème (lié au type d'opération)
CREATE TABLE IF NOT EXISTS bareme (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_type_operation INTEGER REFERENCES type_operation(id) ON DELETE CASCADE,
    borne_inf REAL NOT NULL,
    borne_sup REAL NOT NULL,
    valeur REAL NOT NULL
);

-- 3. Configuration V2 : Autres opérateurs & Commissions
CREATE TABLE IF NOT EXISTS prefixe_autre_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_operateur TEXT NOT NULL,
    prefixe TEXT NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS config_commission_inter_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pourcentage REAL NOT NULL DEFAULT 0.0
);

-- 4. Table Operation (optimisée pour V1 & V2)
CREATE TABLE IF NOT EXISTS operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_type_operation INTEGER REFERENCES type_operation(id),
    valeur REAL NOT NULL,
    frais REAL DEFAULT 0.0,
    frais_retrait_inclus REAL DEFAULT 0.0, -- Option V2 (Transfert avec frais de retrait)
    envoyeur INTEGER REFERENCES utilisateur(id),
    destinataire INTEGER REFERENCES utilisateur(id), -- Nullable si autre opérateur ou dépôt/retrait
    numero_destinataire_externe TEXT NULL, -- Pour les transferts vers d'autres opérateurs (V2)
    id_autre_operateur INTEGER REFERENCES prefixe_autre_operateur(id) NULL, -- Pour identifier l'opérateur tiers (V2)
    date_operation DATETIME DEFAULT (datetime('now', 'localtime'))
);

-- --------------------------------------------------------
-- SEED / DONNÉES DE TEST
-- --------------------------------------------------------

INSERT INTO type_operation (id, nom) VALUES 
    (1, 'dépôt'), 
    (2, 'retrait'), 
    (3, 'transfert');

-- Barèmes associés au Retrait (id_type_operation = 2) et Transfert (id_type_operation = 3)
INSERT INTO bareme (id_type_operation, borne_inf, borne_sup, valeur) VALUES
    (2, 100, 1000, 50),
    (2, 1001, 5000, 50),
    (2, 5001, 10000, 100),
    (2, 10001, 25000, 200),
    (2, 25001, 50000, 400),
    (2, 50001, 100000, 800),
    (2, 100001, 250000, 1500),
    (2, 250001, 500000, 1500),
    (2, 500001, 1000000, 2500),
    (2, 1000001, 2000000, 3000),
    
    (3, 100, 1000, 50),
    (3, 1001, 5000, 50),
    (3, 5001, 10000, 100),
    (3, 10001, 25000, 200),
    (3, 25001, 50000, 400),
    (3, 50001, 100000, 800),
    (3, 100001, 250000, 1500),
    (3, 250001, 500000, 1500),
    (3, 500001, 1000000, 2500),
    (3, 1000001, 2000000, 3000);

-- Préfixes valables (Opérateur principal)
INSERT INTO prefixe_operateur (prefixe) VALUES
    ('033'),
    ('037');

-- Préfixes autres opérateurs (V2)
INSERT INTO prefixe_autre_operateur (nom_operateur, prefixe) VALUES
    ('Orange', '032'),
    ('Telma', '034');

-- Configuration commission par défaut (ex: 2.5%)
INSERT INTO config_commission_inter_operateur (pourcentage) VALUES (2.5);

-- Clients de test
INSERT INTO utilisateur (numero, est_operateur, solde) VALUES
    ('0331234567', 0, 50000),
    ('0332345678', 0, 120000),
    ('0371112233', 0, 8000),
    ('0374445566', 0, 300000),
    ('0335556677', 0, 0),
    ('0330000000', 1, 0); -- Compte Admin / Opérateur

-- Opérations de test
INSERT INTO operation (id_type_operation, valeur, frais, envoyeur, destinataire, date_operation) VALUES
    (1, 50000, 0, NULL, 1, datetime('now', '-3 days')),
    (1, 100000, 0, NULL, 2, datetime('now', '-2 days')),
    (2, 5000, 50, 1, NULL, datetime('now', '-2 days')),
    (3, 10000, 100, 2, 3, datetime('now', '-1 days'));