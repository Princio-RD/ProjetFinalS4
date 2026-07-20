# Taches.md - Projet Mobile Money

## Equipe
- Princio : Module Operateur / Prefixe / Operation / Tarif
- Iavo : Module Client / Compte / Acte

---

## Setup Initial @Both

### Configuration
- [x] Configurer .env (SQLite, base_url)
- [x] Verifier app/Config/Database.php
- [x] Configurer app/Config/Routes.php
- [x] Creer base.sql avec toutes les tables
- [x] Tester la connexion SQLite

### Migrations
- [x] CreateOperateurTable - id_operateur, nom, prefixe
- [x] CreateOperationTable - id_type_operation, libelle
- [x] CreateTarifTable - id_bareme, id_type_operation, montant_min, montant_max, frais
- [x] CreateClientTable - id_client, numero_telephone, date_creation
- [x] CreateCompteTable - id_compte, id_client, id_operateur, solde
- [x] CreateActeTable - id_acte, id_compte_source, id_compte_destination, id_type_operation, montant, frais_applique, date_operation, statut

### Seeders
- [x] OperationSeeder - Depot, Retrait, Transfert
- [x] OperateurSeeder - Orange, Telma, Airtel
- [x] TarifSeeder - Baremess de frais (retrait et transfert)
- [x] ClientSeeder - Clients de test
- [x] CompteSeeder - Comptes de test
- [x] ActeSeeder - Transactions de test

---

## Module Admin - Operateur / Prefixe / Operation / Tarif @Princio

### Modeles
- [x] OperateurModel.php
  - [x] CRUD standard
  - [x] findAll()
  - [x] find($id)
  - [x] insert($data)
  - [x] update($id, $data)
  - [x] delete($id)

- [x] OperationModel.php
  - [x] CRUD standard
  - [x] findAll()
  - [x] find($id)
  - [x] insert($data)
  - [x] update($id, $data)
  - [x] delete($id)

- [x] TarifModel.php
  - [x] CRUD standard
  - [x] findAll()
  - [x] find($id)
  - [x] insert($data)
  - [x] update($id, $data)
  - [x] delete($id)
  - [x] calculerFrais($id_type_operation, $montant) - Calcule les frais selon le bareme

### Controleurs Admin
- [x] Admin/Auth.php
  - [x] login() - Affiche le formulaire de connexion
  - [x] authenticate() - Verifie les identifiants
  - [x] logout() - Deconnexion

- [x] Admin/Dashboard.php
  - [x] index() - Affiche le tableau de bord avec :
    - [x] Total clients
    - [x] Total comptes
    - [x] Solde total
    - [x] Gains par type d'operation (Depot, Retrait, Transfert)
    - [x] Total des gains
    - [x] Liste des clients avec leurs comptes
    - [x] Comptes par operateur

- [x] Admin/Operateur.php
  - [x] index() - Liste des prefixes
  - [x] store() - Ajouter un prefixe
  - [x] delete($id) - Supprimer un prefixe

- [x] Admin/Operation.php
  - [x] index() - Liste des operations et baremes
  - [x] storeOperation() - Ajouter un type d'operation
  - [x] storeTarif() - Ajouter un bareme de frais
  - [x] deleteTarif($id) - Supprimer un bareme

### Vues Admin
- [x] admin/login.php
- [x] admin/dashboard.php
- [x] admin/operateur.php
- [x] admin/operation.php

### Routes Admin
- [x] GET /admin/login -> Admin\Auth::login
- [x] POST /admin/auth -> Admin\Auth::authenticate
- [x] GET /admin/logout -> Admin\Auth::logout
- [x] GET /admin -> Admin\Dashboard::index
- [x] GET /admin/operateur -> Admin\Operateur::index
- [x] POST /admin/operateur/store -> Admin\Operateur::store
- [x] GET /admin/operateur/delete/(:num) -> Admin\Operateur::delete
- [x] GET /admin/operation -> Admin\Operation::index
- [x] POST /admin/operation/store -> Admin\Operation::storeOperation
- [x] POST /admin/operation/tarif -> Admin\Operation::storeTarif
- [x] GET /admin/operation/tarif/delete/(:num) -> Admin\Operation::deleteTarif

---

## Module Client / Compte / Acte @Iavo

### Modeles
- [x] ClientModel.php
  - [x] CRUD standard
  - [x] findAll()
  - [x] find($id)
  - [x] where('numero_telephone', $numero)->first()

- [x] CompteModel.php
  - [x] CRUD standard
  - [x] findAll()
  - [x] find($id)
  - [x] where('id_client', $id)->findAll()
  - [x] update($id, $data)

- [x] ActeModel.php
  - [x] CRUD standard
  - [x] findAll()
  - [x] find($id)
  - [x] insert($data)
  - [x] where('statut', 'Reussi')->findAll()
  - [x] selectSum('frais_applique')->where('id_type_operation', $id)->where('statut', 'Reussi')->first()

### Controleurs Client
- [x] AuthController.php
  - [x] login() - Affiche le formulaire de connexion
  - [x] loginAuto() - Authentification automatique par numero de telephone
  - [x] logout() - Deconnexion

- [x] DashboardController.php
  - [x] index() - Affiche le tableau de bord client

- [x] OperationController.php
  - [x] solde($idCompte) - Afficher le solde d'un compte
  - [x] depotForm($idCompte) - Formulaire de depot
  - [x] depot($idCompte) - Traitement du depot
  - [x] retraitForm($idCompte) - Formulaire de retrait
  - [x] retrait($idCompte) - Traitement du retrait avec frais
  - [x] transfertForm($idCompte) - Formulaire de transfert
  - [x] transfert($idCompte) - Traitement du transfert avec frais
  - [x] historique($idCompte) - Historique des transactions

### Vues Client
- [x] client/login.php
- [x] client/dashboard.php
- [x] client/solde.php
- [x] client/depot.php
- [x] client/retrait.php
- [x] client/transfert.php
- [x] client/historique.php

### Routes Client
- [x] GET /login -> AuthController::login
- [x] POST /auth/loginAuto -> AuthController::loginAuto
- [x] GET /logout -> AuthController::logout
- [x] GET /dashboard -> DashboardController::index
- [x] GET /compte/(:num)/solde -> OperationController::solde/$1
- [x] GET /compte/(:num)/depot -> OperationController::depotForm/$1
- [x] POST /compte/(:num)/depot -> OperationController::depot/$1
- [x] GET /compte/(:num)/retrait -> OperationController::retraitForm/$1
- [x] POST /compte/(:num)/retrait -> OperationController::retrait/$1
- [x] GET /compte/(:num)/transfert -> OperationController::transfertForm/$1
- [x] POST /compte/(:num)/transfert -> OperationController::transfert/$1
- [x] GET /compte/(:num)/historique -> OperationController::historique/$1

---

## Fonctionnalites Implementees

### Cote Client
- [x] Login automatique avec numero de telephone
- [x] Dashboard avec liste des comptes
- [x] Voir le solde d'un compte
- [x] Faire un depot
- [x] Faire un retrait (avec frais)
- [x] Faire un transfert (avec frais)
- [x] Voir l'historique des transactions

### Cote Admin (Operateur)
- [x] Login admin
- [x] Dashboard avec situation globale
- [x] Gestion des prefixes (ajout, suppression)
- [x] Gestion des types d'operations (ajout)
- [x] Gestion des baremes de frais (ajout, suppression)
- [x] Situation des comptes clients
- [x] Gains par type d'operation

---

## Identifiants par defaut

| Role | Identifiant | Mot de passe |
|------|-------------|--------------|
| Admin| local | okeybrada |
| Client| Numero telephone | Auto-login |

---

## Checklist finale v1

- [ ] Toutes les routes fonctionnent
- [ ] base.sql complet
- [ ] Taches.md rempli
- [ ] Tag v1 cree
- [ ] Push sur GitHub