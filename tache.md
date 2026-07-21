# Taches.md - Projet Mobile Money

## Equipe
- Princio : Module Operateur / Prefixe / Operation / Tarif / Commissions
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
- [x] CreateCommissionTable - id_commission, id_operateur_source, id_operateur_destination, pourcentage

### Seeders
- [x] OperationSeeder - Depot, Retrait, Transfert
- [x] OperateurSeeder - Orange, Telma, Airtel
- [x] TarifSeeder - Baremess de frais (retrait et transfert)
- [x] ClientSeeder - Clients de test
- [x] CompteSeeder - Comptes de test
- [x] ActeSeeder - Transactions de test
- [x] CommissionSeeder - Commissions entre operateurs

---

## Version 1 (v1) - Fonctionnalites de base

### Module Admin - Operateur / Prefixe / Operation / Tarif @Princio

#### Modeles
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

#### Controleurs Admin
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
  - [x] edit($id) - Formulaire de modification
  - [x] update($id) - Modifier un prefixe
  - [x] delete($id) - Supprimer un prefixe

- [x] Admin/Operation.php
  - [x] index() - Liste des operations et baremes
  - [x] storeOperation() - Ajouter un type d'operation
  - [x] storeTarif() - Ajouter un bareme de frais
  - [x] deleteTarif($id) - Supprimer un bareme

#### Vues Admin
- [x] admin/login.php
- [x] admin/dashboard.php
- [x] admin/operateur.php
- [x] admin/edit.php
- [x] admin/operation.php

#### Routes Admin
- [x] GET /admin/login -> Admin\Auth::login
- [x] POST /admin/auth -> Admin\Auth::authenticate
- [x] GET /admin/logout -> Admin\Auth::logout
- [x] GET /admin -> Admin\Dashboard::index
- [x] GET /admin/operateur -> Admin\Operateur::index
- [x] POST /admin/operateur/store -> Admin\Operateur::store
- [x] GET /admin/operateur/edit/(:num) -> Admin\Operateur::edit/$1
- [x] POST /admin/operateur/update/(:num) -> Admin\Operateur::update/$1
- [x] GET /admin/operateur/delete/(:num) -> Admin\Operateur::delete/$1
- [x] GET /admin/operation -> Admin\Operation::index
- [x] POST /admin/operation/store -> Admin\Operation::storeOperation
- [x] POST /admin/operation/tarif -> Admin\Operation::storeTarif
- [x] GET /admin/operation/tarif/delete/(:num) -> Admin\Operation::deleteTarif/$1

---

### Module Client / Compte / Acte @Iavo

#### Modeles
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

#### Controleurs Client
- [x] Client/AuthController.php
  - [x] login() - Affiche le formulaire de connexion
  - [x] loginAuto() - Authentification automatique par numero de telephone
  - [x] logout() - Deconnexion

- [x] Client/DashboardController.php
  - [x] index() - Affiche le tableau de bord client

- [x] Client/OperationController.php
  - [x] solde($idCompte) - Afficher le solde d'un compte
  - [x] depotForm($idCompte) - Formulaire de depot
  - [x] depot($idCompte) - Traitement du depot
  - [x] retraitForm($idCompte) - Formulaire de retrait
  - [x] retrait($idCompte) - Traitement du retrait avec frais
  - [x] transfertForm($idCompte) - Formulaire de transfert
  - [x] transfert($idCompte) - Traitement du transfert avec frais
  - [x] historique($idCompte) - Historique des transactions

#### Vues Client
- [x] client/login.php
- [x] client/dashboard.php
- [x] client/solde.php
- [x] client/depot.php
- [x] client/retrait.php
- [x] client/transfert.php
- [x] client/historique.php

#### Routes Client
- [x] GET /login -> Client\AuthController::login
- [x] POST /auth/loginAuto -> Client\AuthController::loginAuto
- [x] GET /logout -> Client\AuthController::logout
- [x] GET /dashboard -> Client\DashboardController::index
- [x] GET /compte/(:num)/solde -> Client\OperationController::solde/$1
- [x] GET /compte/(:num)/depot -> Client\OperationController::depotForm/$1
- [x] POST /compte/(:num)/depot -> Client\OperationController::depot/$1
- [x] GET /compte/(:num)/retrait -> Client\OperationController::retraitForm/$1
- [x] POST /compte/(:num)/retrait -> Client\OperationController::retrait/$1
- [x] GET /compte/(:num)/transfert -> Client\OperationController::transfertForm/$1
- [x] POST /compte/(:num)/transfert -> Client\OperationController::transfert/$1
- [x] GET /compte/(:num)/historique -> Client\OperationController::historique/$1

---

## Version 2 (v2) - Commissions et fonctionnalites avancees

### Module Admin - Commissions et gains @Princio

#### Modeles
- [x] CommissionModel.php
  - [x] CRUD standard
  - [x] getCommission($idSource, $idDestination) - Recupere le pourcentage de commission
  - [x] getAllCommissions() - Liste toutes les commissions avec noms des operateurs
  - [x] findAll()
  - [x] find($id)
  - [x] insert($data)
  - [x] update($id, $data)
  - [x] delete($id)

- [x] OperateurModel.php (MODIFIE)
  - [x] Ajout du champ commission_autre (OU utilise CommissionModel)

#### Controleurs Admin (MODIFIES)
- [x] Admin/Operateur.php
  - [x] index() - Liste des prefixes ET des commissions
  - [x] store() - Ajouter un prefixe
  - [x] edit($id) - Formulaire de modification
  - [x] update($id) - Modifier un prefixe
  - [x] delete($id) - Supprimer un prefixe
  - [x] storeCommission() - Ajouter/Modifier une commission
  - [x] deleteCommission($id) - Supprimer une commission

- [x] Admin/Dashboard.php (MODIFIE)
  - [x] index() - Affiche le tableau de bord avec :
    - [x] Total clients
    - [x] Total comptes
    - [x] Solde total
    - [x] Gains par operateur (separe)
      - [x] Depot par operateur
      - [x] Retrait par operateur
      - [x] Transfert par operateur
      - [x] Total par operateur
    - [x] Situation des gains vers les autres operateurs
      - [x] Frais collectes par operateur source
      - [x] Commission (%) par paire d'operateurs
      - [x] Montant a payer par operateur destination
    - [x] Situation des montants a envoyer a chaque operateur
    - [x] Liste des clients avec leurs comptes
    - [x] Comptes par operateur

#### Vues Admin (MODIFIES)
- [x] admin/operateur.php
  - [x] Formulaire d'ajout de prefixe
  - [x] Liste des prefixes
  - [x] Formulaire de configuration des commissions
  - [x] Liste des commissions configurées

- [x] admin/dashboard.php
  - [x] Cartes statistiques
  - [x] Tableau gains par operateur
  - [x] Tableau gains vers les autres operateurs
  - [x] Tableau montants a envoyer
  - [x] Liste des clients

#### Routes Admin (AJOUTEES)
- [x] POST /admin/operateur/commission/store -> Admin\Operateur::storeCommission
- [x] GET /admin/operateur/commission/delete/(:num) -> Admin\Operateur::deleteCommission/$1

---

### Module Client - Nouvelles fonctionnalites @Iavo

#### Controleurs Client (MODIFIES)
- [x] Client/OperationController.php
  - [x] transfert($idCompte) - MODIFIE : Ajout de l'option "inclure frais"
  - [x] transfertForm($idCompte) - MODIFIE : Ajout checkbox "Inclure les frais"
  - [x] transfertMultipleForm($idCompte) - NOUVEAU : Formulaire envoi multiple
  - [x] transfertMultiple($idCompte) - NOUVEAU : Traitement envoi multiple

#### Vues Client (MODIFIEES / AJOUTEES)
- [x] client/transfert.php - MODIFIE :
  - [x] Ajout checkbox "Inclure les frais dans le retrait"
  - [x] Affichage des frais calcules en temps reel
  - [x] Information sur l'operateur du destinataire

- [x] client/transfert_multiple.php - NOUVEAU :
  - [x] Formulaire avec plusieurs numéros de destination
  - [x] Montant total a repartir
  - [x] Liste des destinataires (même opérateur uniquement)

#### Routes Client (AJOUTEES)
- [x] GET /compte/(:num)/transfert-multiple -> Client\OperationController::transfertMultipleForm/$1
- [x] POST /compte/(:num)/transfert-multiple -> Client\OperationController::transfertMultiple/$1

---

## Fonctionnalites Version 2

### Cote Admin (Princio)
- [x] Configuration des commissions par paire d'operateurs
  - [x] Orange -> Telma : X%
  - [x] Orange -> Airtel : X%
  - [x] Telma -> Orange : X%
  - [x] Telma -> Airtel : X%
  - [x] Airtel -> Orange : X%
  - [x] Airtel -> Telma : X%
- [x] Dashboard avec gains separes par operateur
- [x] Situation des gains vers les autres operateurs
- [x] Situation des montants a envoyer a chaque operateur

### Cote Client (Iavo)
- [x] Option "Inclure les frais" lors d'un retrait
  - [x] Retrait avec frais inclus (montant net)
  - [x] Retrait sans frais (montant brut)
- [x] Envoi multiple vers plusieurs numeros
  - [x] Selection de plusieurs destinataires
  - [x] Repartition automatique du montant
  - [x] Meme operateur uniquement
  - [x] Vérification des numeros

---

## Identifiants par defaut

| Role | Identifiant | Mot de passe |
|------|-------------|--------------|
| Admin | local | okeybrada |
| Client | Numero telephone | Auto-login |

---

## Tags

| Version | Tag | Date | Statut |
|---------|-----|------|--------|
| Version 1 | v1 | Lundi 13h | [x] TERMINE |
| Version 2 | v2 | Mardi (à definir) | [x] EN COURS |
| Version 3 | v3 | Final | [x] A FAIRE |

---

## Checklist finale v2

- [x] Toutes les routes fonctionnent
- [x] base.sql complet (table Commission ajoutee)
- [x] Taches.md mis a jour
- [x] CommissionSeeder fonctionnel
- [x] Dashboard admin avec gains separes
- [x] Option "inclure frais" fonctionnelle
- [x] Envoi multiple fonctionnel
- [x] Tag v2 cree
- [x] Push sur GitHub


epr: manao page  epargne pour chaque transfert 