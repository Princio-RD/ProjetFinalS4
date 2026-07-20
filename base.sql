-- Table Operateur
CREATE TABLE Operateur (
    id_operateur INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(50) NOT NULL,
    prefixe VARCHAR(3) NOT NULL UNIQUE
);

-- Table Operation
CREATE TABLE Operation (
    id_type_operation INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle VARCHAR(30) NOT NULL UNIQUE
);

-- Table Tarif
CREATE TABLE Tarif (
    id_bareme INTEGER PRIMARY KEY AUTOINCREMENT,
    id_type_operation INTEGER NOT NULL,
    montant_min DECIMAL(15,2) NOT NULL,
    montant_max DECIMAL(15,2) NOT NULL,
    frais DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (id_type_operation) REFERENCES Operation(id_type_operation)
);

-- Table Client
CREATE TABLE Client (
    id_client INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(15) NOT NULL,
    numero_telephone VARCHAR(15) NOT NULL UNIQUE,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table Compte
CREATE TABLE Compte (
    id_compte INTEGER PRIMARY KEY AUTOINCREMENT,
    id_client INTEGER NOT NULL,
    id_operateur INTEGER NOT NULL,
    solde DECIMAL(15,2) NOT NULL DEFAULT 0,
    FOREIGN KEY (id_client) REFERENCES Client(id_client),
    FOREIGN KEY (id_operateur) REFERENCES Operateur(id_operateur)
);

-- Table Acte
CREATE TABLE Acte (
    id_acte INTEGER PRIMARY KEY AUTOINCREMENT,
    id_compte_source INTEGER NOT NULL,
    id_compte_destination INTEGER NULL,
    id_type_operation INTEGER NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    frais_applique DECIMAL(15,2) NOT NULL DEFAULT 0,
    date_operation DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(20) NOT NULL DEFAULT 'Réussi',
    FOREIGN KEY (id_compte_source) REFERENCES Compte(id_compte),
    FOREIGN KEY (id_compte_destination) REFERENCES Compte(id_compte),
    FOREIGN KEY (id_type_operation) REFERENCES Operation(id_type_operation)
);

-- =========================================================
-- Données de base
-- =========================================================

INSERT INTO Operation (libelle) VALUES ('Dépôt'), ('Retrait'), ('Transfert');

INSERT INTO Operateur (nom, prefixe) VALUES
('Orange', '032'),
('Telma', '034'),
('Airtel', '033');

INSERT INTO Client (numero_telephone,nom) VALUES
('0331562072','Jean'),
('0348101301','Rakoto'),
('0321256078','Rabe'),
('0335026660','Karl'),
('0325877760','Jean');

INSERT INTO Compte (id_client, id_operateur, solde) VALUES
(1, 1, 50000.00),
(1, 2, 25000.00),
(2, 1, 100000.00),
(2, 3, 15000.00),
(3, 2, 75000.00),
(4, 1, 30000.00),
(4, 3, 12000.00),
(5, 2, 90000.00);

INSERT INTO Tarif (id_type_operation, montant_min, montant_max, frais) VALUES
-- retrait (id_type_operation = 2)
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

-- transfert (id_type_operation = 3)
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

-- =========================================================
-- Exemple d'actes (transactions)
-- =========================================================
INSERT INTO Acte (id_compte_source, id_compte_destination, id_type_operation, montant, frais_applique, statut) VALUES
(1, NULL, 1, 50000.00, 0, 'Réussi'),
(3, NULL, 2, 10000.00, 100, 'Réussi'),
(1, 2, 3, 25000.00, 200, 'Réussi'),
(5, NULL, 2, 5000.00, 50, 'Réussi'),
(4, 3, 3, 15000.00, 150, 'Réussi');