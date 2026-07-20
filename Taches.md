# Projet Mobile Money

**Membres :**

* Fanilo : etu004043
* Miaro : etu004176

---

## V1

### 1 - Conception de la base de donnees (Fanilo && Miaro)

**Tables à creer :**

* `utilisateur` (id, numero_telephone, est_operateur, solde)
* `prefixe_operateur` (id, prefixe)
* `type_operation` (id, nom) — depôt, retrait, transfert
* `bareme` (id, id_type_operation [FK], borne_inf, borne_sup, frais)
* `operation` (id, id_type_operation [FK], id_envoyeur [FK utilisateur], id_destinataire [FK utilisateur, nullable pour depôt/retrait], montant, frais_applique, date_operation)

**Tâches :**

* [ X ] Modeliser le schema
* [ X ] ecrire `base.sql` à la racine (CREATE TABLE + vues eventuelles)
* [ X ] Creer une vue SQL "situation_comptes" ou "gains_operateur" pour simplifier les requêtes du dashboard operateur
* [ X ] Inserer des donnees de test :
* [ X ] 2-3 prefixes operateur (033, 037)
* [ X ] les 3 types d'operation
* [ X ] le barème complet
* [ X ] quelques utilisateurs + soldes de depart
* [ X ] quelques operations historiques



---

### 2 - Initialisation du projet (Fanilo)

* [ X ] Squelette CodeIgniter 4
* [ X ] Config de la connexion SQLite dans `app/Config/Database.php`
* [ X ] Installer Bootstrap (CDN ou npm) pour le style de base
* [ X ] Creer le repo Git public + premier commit + verifier l'accès public

**Page login / auth (côte client ET operateur) :**

* [ X ] `AuthController` : une seule route d'entree par numero
* [ X ] `UtilisateurModel` : methode `findByNumero()`, `create()`
* [ X ] Formulaire avec un seul champ "numero de telephone"
* [ X ] Validation regex du numero (ex: `^0(33|37)[0-9]{7}$` selon les prefixes configures, idealement verifiee dynamiquement contre `prefixe_operateur`)
* [ X ] Logique :
* [ X ] numero inexistant → creation automatique de l'utilisateur (`est_operateur = 0`) + solde initial à 0, puis redirection dashboard
* [ X ] numero existant → redirection directe selon `est_operateur` (dashboard client ou dashboard operateur)


* [ X ] Bouton "Se connecter" + gestion des erreurs de format (message si regex invalide)
* [ X ] Session CI4 pour stocker l'utilisateur connecte (`id_utilisateur`, `est_operateur`)
* [ X ] Middleware/filter CI4 pour proteger les routes selon le rôle (client vs operateur)

---

### 3 - Côte operateur (Miaro)

**Dashboard :**

* [ X ] Vue d'ensemble : total des gains cumules (somme des `frais_applique` sur retrait + transfert)
* [ X ] Filtre par periode (jour/semaine/mois) si le temps le permet, sinon total global suffit pour v1

**Configuration des prefixes :**

* [ X ] CRUD sur `prefixe_operateur` (ajouter/supprimer un prefixe valable)

**Gestion des types d'operation et barèmes :**

* [ X ] Liste des types d'operation existants
* [ X ] Pour chaque type, CRUD sur les tranches de `bareme` (borne_inf, borne_sup, frais), modifiable comme demande dans le sujet

**Situation des comptes clients :**

* [ X ] Liste des utilisateurs avec leur solde actuel
* [ X ] Recherche/filtre par numero

---

### 4 - Côte client (Fanilo)

**Dashboard :**

* [ X ] Affichage du solde courant
* [ X ] Accès aux 3 operations + historique

**Operations :**

* [ X ] Depôt : formulaire montant → credite le solde directement (simule "automatique", pas de validation operateur)
* [ X ] Retrait : formulaire montant → verifie solde suffisant (montant + frais) → calcule le frais selon le barème du type "retrait" → debite
* [ X ] Transfert : formulaire montant + numero destinataire → verifie que le destinataire existe (sinon erreur, pas de creation auto ici) → calcule frais selon barème "transfert" → debite envoyeur, credite destinataire
* [ X ] Fonction commune `calculerFrais(id_type_operation, montant)` qui cherche la bonne tranche dans `bareme`

**Historique :**

* [ X ] Liste des operations de l'utilisateur connecte (envoyees ET reçues), triees par date, avec type/montant/frais

---

### 5 - Livraison V1

* [ X ] Mettre à jour `Taches.md` à la racine avec le detail du travail de chaque etudiant pour cette livraison
* [ X ] Verifier que `base.sql` est complet et à jour à la racine
* [ X ] Soumettre l'URL du repo via le formulaire Google si pas dejà fait
* [ X ] Tag `v1` sur la branche main avant 13h

---

## V2

### 1 - Mise à jour de la Base de Données (Fanilo && Miaro)

* [ ] Mise à jour de `base.sql` à la racine avec les nouvelles structures :
* [ ] Table `prefixe_autre_operateur` (id, nom_operateur, prefixe) — ex: Telma (034), Airtel (033), Orange (032)
* [ ] Table `config_commission_inter_operateur` (id, pourcentage) — ex: % de frais supplementaires vers les autres reseaux
* [ ] Modification / ajout de colonnes dans `operation` : champ `id_autre_operateur` (FK, nullable) ou flag pour identifier si le transfert est inter-opérateur


* [ ] Mettre à jour les jeux de données de test dans `base.sql` (prefixes externes 032, 031, % de commission par defaut).

---

### 2 - Côte Opérateur (Miaro)

**Configuration des autres opérateurs :**

* [ ] CRUD pour la configuration des préfixes des autres opérateurs (ex: 032, 031, etc.)
* [ ] Interface de paramétrage du **% de commission supplémentaire** pour les transferts vers d'autres opérateurs

**Statistiques & Situation financière avancée :**

* [ ] **Mise à jour de la page "Situation gain via les différents frais"** :
* [ ] Séparation distincte des gains issus de l'opérateur principal vs gains issus des autres opérateurs


* [ ] **Nouvelle section "Situation des montants à envoyer à chaque opérateur"** :
* [ ] Vue récapitulative indiquant le montant total cumulé dû à chaque opérateur tiers suite aux transferts externes



---

### 3 - Côte Client (Fanilo)

**Améliorations du Transfert :**

* [ ] **Détection automatique de l'opérateur du destinataire** :
* [ ] Analyse du préfixe saisi : si réseau interne → barème normal ; si préfixe autre opérateur → calcul du frais de base + majoration du % de commission inter-opérateur


* [ ] **Option "Inclure les frais de retrait lors de l'envoi"** :
* [ ] Ajout d'une case à cocher (checkbox) dans le formulaire de transfert
* [ ] Si cochée : calculer les frais de retrait associés au montant transféré et les prélever sur le solde de l'expéditeur afin que le destinataire reçoive le montant net


* [ ] **Envoi multiple vers plusieurs numéros** :
* [ ] Interface permettant de saisir/ajouter plusieurs numéros de téléphone (ou champ séparé par des virgules/lignes)
* [ ] Logique métier : division égale du montant total saisi entre tous les destinataires
* [ ] Vérification du solde global de l'expéditeur (somme des montants individuels + frais pour chaque destinataire)
* [ ] Exécution en boucle / transactionnelle de chaque transfert



---

### 4 - Livraison V2

* [ ] S'assurer que le fichier `base.sql` unique à la racine intègre toutes les modifications V2 (tables, données de test)
* [ ] Mettre à jour et valider le fichier `Taches.md` à la racine
* [ ] Effectuer les tests globaux sur le flux V2
* [ ] Pusher sur la branche `main`
* [ ] Créer et pusher le tag **`v2`** sur le dépôt GitHub/GitLab public avant 17h10 (`git tag v2 && git push origin v2`)