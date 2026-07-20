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

-- Table Commission
CREATE TABLE Commission (
    id_commission INTEGER PRIMARY KEY AUTOINCREMENT,
    id_operateur_source INTEGER NOT NULL,
    id_operateur_destination INTEGER NOT NULL,
    pourcentage DECIMAL(5,2) NOT NULL DEFAULT 0,
    FOREIGN KEY (id_operateur_source) REFERENCES Operateur(id_operateur),
    FOREIGN KEY (id_operateur_destination) REFERENCES Operateur(id_operateur),
    UNIQUE(id_operateur_source, id_operateur_destination)
);

-- Table Client
CREATE TABLE Client (
    id_client INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(15) NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table Compte
CREATE TABLE Compte (
    id_compte INTEGER PRIMARY KEY AUTOINCREMENT,
    id_client INTEGER NOT NULL,
    id_operateur INTEGER NOT NULL,
    numero_telephone VARCHAR(15) NOT NULL,
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
    commission_appliquee DECIMAL(15,2) NOT NULL DEFAULT 0,
    date_operation DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(20) NOT NULL DEFAULT 'Réussi',
    FOREIGN KEY (id_compte_source) REFERENCES Compte(id_compte),
    FOREIGN KEY (id_compte_destination) REFERENCES Compte(id_compte),
    FOREIGN KEY (id_type_operation) REFERENCES Operation(id_type_operation)
);

-- =========================================================
-- Données de base
-- =========================================================
-- =========================================================
-- Données de base
-- =========================================================

INSERT INTO Operateur (nom, prefixe) VALUES
('Orange', '032'),
('Telma', '034'),
('Airtel', '033');

INSERT INTO Operation (libelle) VALUES 
('Dépôt'), 
('Retrait'), 
('Transfert');

INSERT INTO Client (nom) VALUES
('Jean'),
('Rakoto'),
('Rabe'),
('Karl'),
('Marie'),
('Andry'),
('Lala'),
('Mamy'),
('Tiana'),
('Soa');

INSERT INTO Compte (id_client, id_operateur, numero_telephone, solde) VALUES
(1, 1, '0321562072', 75000.00),
(2, 2, '0348101301', 120000.00),
(2, 3, '0334567890', 25000.00),
(3, 1, '0321256078', 45000.00),
(4, 3, '0335026660', 80000.00),
(4, 1, '0329876543', 15000.00),
(5, 1, '0325877760', 95000.00),
(6, 2, '0341234567', 30000.00),
(7, 3, '0331112222', 55000.00),
(8, 1, '0323334444', 68000.00),
(9, 2, '0345556666', 42000.00),
(10, 3, '0337778888', 88000.00);

INSERT INTO Tarif (id_type_operation, montant_min, montant_max, frais) VALUES
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

INSERT INTO Commission (id_operateur_source, id_operateur_destination, pourcentage) VALUES
-- orange
(1, 2, 2.50), -- orange--> telma
(1, 3, 3.00), -- orange -->airtel

-- telma
(2, 1, 2.00), -- telma --> orange
(2, 3, 2.50), -- telma --> airtel

-- airtel
(3, 1, 3.50), -- airtel --> orange
(3, 2, 3.00); -- airtel --> telma

INSERT INTO Acte (id_compte_source, id_compte_destination, id_type_operation, montant, frais_applique, commission_appliquee, statut) VALUES
(1, NULL, 1, 50000.00, 0, 0, 'Réussi'),
(3, NULL, 1, 25000.00, 0, 0, 'Réussi'),
(5, NULL, 1, 10000.00, 0, 0, 'Réussi'),
(7, NULL, 1, 30000.00, 0, 0, 'Réussi'),
(9, NULL, 1, 15000.00, 0, 0, 'Réussi'),
(11, NULL, 1, 20000.00, 0, 0, 'Réussi'),
(2, NULL, 2, 10000.00, 100, 0, 'Réussi'),
(4, NULL, 2, 5000.00, 50, 0, 'Réussi'),
(6, NULL, 2, 8000.00, 100, 0, 'Réussi'),
(8, NULL, 2, 12000.00, 200, 0, 'Réussi'),
(10, NULL, 2, 7000.00, 100, 0, 'Réussi'),
(12, NULL, 2, 15000.00, 200, 0, 'Réussi'),
(1, 2, 3, 15000.00, 200, 0, 'Réussi'),
(3, 4, 3, 10000.00, 100, 0, 'Réussi'),
(5, 6, 3, 20000.00, 200, 0, 'Réussi'),
(7, 8, 3, 5000.00, 50, 0, 'Réussi'),
(9, 10, 3, 25000.00, 200, 0, 'Réussi'),
(1, 3, 3, 25000.00, 200, 625.00, 'Réussi'),
(1, 5, 3, 30000.00, 400, 900.00, 'Réussi'),
(3, 5, 3, 20000.00, 200, 400.00, 'Réussi'),
(5, 7, 3, 15000.00, 150, 525.00, 'Réussi'),
(7, 9, 3, 12000.00, 120, 360.00, 'Réussi'),
(9, 11, 3, 18000.00, 180, 450.00, 'Réussi'),
(1, 2, 3, 5000.00, 50, 0, 'Réussi'),
(1, 4, 3, 8000.00, 100, 0, 'Réussi'),
(3, 6, 3, 12000.00, 120, 0, 'Réussi'),
(5, 8, 3, 15000.00, 150, 0, 'Réussi'),
(7, 10, 3, 10000.00, 100, 0, 'Réussi');