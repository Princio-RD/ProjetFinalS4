
CREATE TABLE Operateur (
    id_operateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prefixe VARCHAR(3) NOT NULL UNIQUE
);


CREATE TABLE Operation (
    id_type_operation INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(30) NOT NULL UNIQUE
);


CREATE TABLE Tarif (
    id_bareme INT AUTO_INCREMENT PRIMARY KEY,
    id_type_operation INT NOT NULL,
    montant_min DECIMAL(15,2) NOT NULL,
    montant_max DECIMAL(15,2) NOT NULL,
    frais DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (id_type_operation) REFERENCES Operation(id_type_operation)
);


CREATE TABLE Client (
    id_client INT AUTO_INCREMENT PRIMARY KEY,
    numero_telephone VARCHAR(15) NOT NULL UNIQUE,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Compte (
    id_compte INT AUTO_INCREMENT PRIMARY KEY,
    id_client INT NOT NULL,
    id_operateur INT NOT NULL,
    solde DECIMAL(15,2) NOT NULL DEFAULT 0,
    FOREIGN KEY (id_client) REFERENCES Client(id_client),
    FOREIGN KEY (id_operateur) REFERENCES Operateur(id_operateur)
);


CREATE TABLE Acte (
    id_acte INT AUTO_INCREMENT PRIMARY KEY,
    id_compte_source INT NOT NULL,
    id_compte_destination INT NULL,
    id_type_operation INT NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    frais_applique DECIMAL(15,2) NOT NULL DEFAULT 0,
    date_operation DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(20) NOT NULL DEFAULT 'Réussi',
    FOREIGN KEY (id_compte_source) REFERENCES Compte(id_compte),
    FOREIGN KEY (id_compte_destination) REFERENCES Compte(id_compte),
    FOREIGN KEY (id_type_operation) REFERENCES Operation(id_type_operation)
);

INSERT INTO Operation (libelle) VALUES ('Dépôt'), ('Retrait'), ('Transfert');

-- =========================================================
-- Exemple de barème de frais (à adapter selon type d'opération)
-- =========================================================
-- Remplacer id_type_operation par l'id réel du type concerné (ex: 2 = Retrait)
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
(2, 1000001, 2000000, 3000);
