# Projet Mobile Money

**Membres :**
- Fanilo : etu004043
- Miaro : etu004176

---

## V1

### 1 - Conception de la base de donnees (Fanilo && Miaro)

**Tables à creer :**

- `utilisateur` (id, numero_telephone, est_operateur, date_creation)
- `solde` (id, id_utilisateur [FK], valeur, date_maj)
- `prefixe_operateur` (id, prefixe)
- `type_operation` (id, nom) — depôt, retrait, transfert
- `bareme` (id, id_type_operation [FK], borne_inf, borne_sup, frais)
- `operation` (id, id_type_operation [FK], id_envoyeur [FK utilisateur], id_destinataire [FK utilisateur, nullable pour depôt/retrait], montant, frais_applique, date_operation)

**Tâches :**
- [ ] Modeliser le schema 
- [ ] ecrire `base.sql` à la racine (CREATE TABLE + vues eventuelles)
- [ ] Creer une vue SQL "situation_comptes" ou "gains_operateur" pour simplifier les requêtes du dashboard operateur
- [ ] Inserer des donnees de test :
  - [ ] 2-3 prefixes operateur (033, 037)
  - [ ] les 3 types d'operation
  - [ ] le barème complet donne en exemple dans le sujet (9 tranches)
  - [ ] quelques utilisateurs + soldes de depart
  - [ ] quelques operations historiques

---

### 2 - Initialisation du projet (Fanilo)

- [ ] Squelette CodeIgniter 4
- [ ] Config de la connexion SQLite dans `app/Config/Database.php`
- [ ] Installer Bootstrap (CDN ou npm) pour le style de base
- [ ] Creer le repo Git public + premier commit + verifier l'accès public

**Page login / auth (côte client ET operateur) :**

- [ ] `AuthController` : une seule route d'entree par numero
- [ ] `UtilisateurModel` : methode `findByNumero()`, `create()`
- [ ] Formulaire avec un seul champ "numero de telephone"
- [ ] Validation regex du numero (ex: `^0(33|37)[0-9]{7}$` selon les prefixes configures, idealement verifiee dynamiquement contre `prefixe_operateur`)
- [ ] Logique :
  - [ ] numero inexistant → creation automatique de l'utilisateur (`est_operateur = 0`) + solde initial à 0, puis redirection dashboard
  - [ ] numero existant → redirection directe selon `est_operateur` (dashboard client ou dashboard operateur)
- [ ] Bouton "Se connecter" + gestion des erreurs de format (message si regex invalide)
- [ ] Session CI4 pour stocker l'utilisateur connecte (`id_utilisateur`, `est_operateur`)
- [ ] Middleware/filter CI4 pour proteger les routes selon le rôle (client vs operateur)

---

### 3 - Côte operateur (Miaro)

**Dashboard :**
- [ ] Vue d'ensemble : total des gains cumules (somme des `frais_applique` sur retrait + transfert)
- [ ] Filtre par periode (jour/semaine/mois) si le temps le permet, sinon total global suffit pour v1

**Configuration des prefixes :**
- [ ] CRUD sur `prefixe_operateur` (ajouter/supprimer un prefixe valable)

**Gestion des types d'operation et barèmes :**
- [ ] Liste des types d'operation existants
- [ ] Pour chaque type, CRUD sur les tranches de `bareme` (borne_inf, borne_sup, frais), modifiable comme demande dans le sujet

**Situation des comptes clients :**
- [ ] Liste des utilisateurs avec leur solde actuel
- [ ] Recherche/filtre par numero

---

### 4 - Côte client (Fanilo)

**Dashboard :**
- [ ] Affichage du solde courant
- [ ] Accès aux 3 operations + historique

**Operations :**
- [ ] Depôt : formulaire montant → credite le solde directement (simule "automatique", pas de validation operateur)
- [ ] Retrait : formulaire montant → verifie solde suffisant (montant + frais) → calcule le frais selon le barème du type "retrait" → debite
- [ ] Transfert : formulaire montant + numero destinataire → verifie que le destinataire existe (sinon erreur, pas de creation auto ici) → calcule frais selon barème "transfert" → debite envoyeur, credite destinataire
- [ ] Fonction commune `calculerFrais(id_type_operation, montant)` qui cherche la bonne tranche dans `bareme`

**Historique :**
- [ ] Liste des operations de l'utilisateur connecte (envoyees ET reçues), triees par date, avec type/montant/frais

---

### 5 - Livraison V1

- [ ] Mettre à jour `Taches.md` à la racine avec le detail du travail de chaque etudiant pour cette livraison
- [ ] Verifier que `base.sql` est complet et à jour à la racine
- [ ] Soumettre l'URL du repo via le formulaire Google si pas dejà fait
- [ ] Tag `v1` sur la branche main avant 13h