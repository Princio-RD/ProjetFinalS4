# Taches.md - Projet Mobile Money

## Equipe
- Iavo : Module Operateur / Prefixe / Operation / Tarif
- Princio : Module Client / Compte / Acte

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

## Module Operateur / Prefixe / Operation / Tarif @Princio

### Modeles
- [x] OperateurModel.php - CRUD operateurs
- [x] OperationModel.php - CRUD operations
- [x] TarifModel.php - CRUD baremes

### Controleurs Admin
- [x] Admin/Auth.php - Login admin
- [x] Admin/Dashboard.php - Dashboard admin
- [x] Admin/Operateur.php - Gestion des prefixes
- [x] Admin/Operation.php - Gestion operations et baremes

### Vues Admin
- [x] admin/login.php - Page connexion
- [x] admin/dashboard.php - Dashboard avec :
  - [x] Situation des comptes clients
  - [x] Gains par frais (retrait et transfert)
  - [x] Liste des clients avec comptes
  - [x] Comptes par operateur
- [x] admin/operateur.php - Gestion des prefixes
- [x] admin/operation.php - Gestion operations et baremes

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
- [x] ClientModel.php - CRUD clients
- [x] CompteModel.php - CRUD comptes
- [x] ActeModel.php - CRUD transactions

### Controleurs Client
- [x] AuthController.php - Login client
- [x] DashboardController.php - Dashboard client

### Vues Client
- [x] client/login.php - Page connexion
- [x] client/dashboard.php - Dashboard client

### Routes Client
- [x] GET /login -> AuthController::login
- [x] POST /auth/loginAuto -> AuthController::loginAuto
- [x] GET /logout -> AuthController::logout
- [x] GET /dashboard -> DashboardController::index

---

## Fonctionnalites Client @Iavo

### Operations
- [x] Voir le solde
- [x] Faire un depot
- [x] Faire un retrait
- [x] Faire un transfert
- [x] Voir l'historique

---

## Identifiants par defaut

| Role | Identifiant | Mot de passe |
|------|-------------|--------------|
| Admin | local | okeybrada |
| Client | Numero telephone | Auto-login |

---


## Checklist finale v1

- [x] Toutes les routes fonctionnent
- [x] base.sql complet
- [ ] Taches.md rempli
- [x] Tag v1 cree
- [ ] Push sur GitHub