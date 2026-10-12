# 🚀 Application de Gestion Chauffagiste

## Description
Cette application permet de gérer les interventions, les utilisateurs (chauffagistes, secrétaires, admins), les pièces détachées, les véhicules, et les plannings dans une entreprise de chauffagistes.

---

## Fonctionnalités principales
- **Gestion des utilisateurs** : création de chauffagistes, secrétaires, et admins avec des rôles spécifiques.
- **Gestion des interventions** : assignation des chauffagistes, véhicules, pièces détachées, ajout de remarques.
- **Gestion des stocks et des véhicules** : CRUD complet pour les pièces détachées et les véhicules.
- **Planning des interventions** : chaque rôle accède à un planning personnalisé (chauffagiste, secrétaire, admin).
- **Sécurisation par rôles** : accès aux pages limité par rôle (Admin, Secrétaire, Chauffagiste).

---

## Fonctionnalités avancées
- ✅ **Contrôle d’unicité** : interdiction de double-assignation d’un même chauffagiste ou véhicule sur une même date/heure.
- ✅ **Calendrier FullCalendar dynamique** : affichage différent selon le rôle + clic pour afficher l’intervention.
- ✅ **Sélecteurs intelligents** : seuls les chauffagistes apparaissent pour l’assignation dans les interventions.
- ✅ **Remarque chauffagiste** : chaque chauffagiste peut ajouter une remarque à ses interventions uniquement.
- ✅ **Sécurité renforcée** : vérifications d’accès sur toutes les routes sensibles.

---

## Rôles & restrictions

| Rôle          | Droits                                                                 |
|---------------|------------------------------------------------------------------------|
| **Admin**      | Accès complet à tous les modules (utilisateurs, stocks, véhicules...) |
| **Secrétaire** | Accès complet à tous les modules **mais pas aux utilisateurs** |
| **Chauffagiste** | Accède uniquement à ses interventions et peut y ajouter des remarques |

---

## Installation

### Prérequis :
- PHP 8.x
- Composer
- Symfony 7.x
- Base de données PostgreSQL ou MySQL

### Étapes :
### 1. Clonez le projet
```bash
git clone https://gitea.btssio-poitiers.fr/sermandm/HegreEtConfort.git
cd HegreEtConfort
```
### 2. Installez les dépendances
```bash
composer install
```
### 3. Créez la base de données
```bash
php bin/console doctrine:database:create
```
### 4. Appliquez les migrations
```bash
php bin/console doctrine:migrations:migrate
```

### 5. Créez un utilisateur admin (exemple PostgreSQL) :
```sql
INSERT INTO "HegreEtConfort".public.utilisateur (
  id, email, first_name, last_name, birth_date, phone, roles, password
)
VALUES (
  1000, 'admin@admin.admin', 'admin', 'admin', '2025-04-10', '0000000000',
  '["ROLE_ADMIN"]',
  '$2y$13$4jqoZVgncgDJ6oPFDswZeeiVmt9TF2AC.xoBwyyrrbNl5Xz8r.50e'
);
```

### 6. Démarrez le serveur Symfony :
```bash
symfony server:start
```

➡️ Accédez ensuite à l’application : [http://localhost:8000](http://localhost:8000)

---

## Technologies utilisées
- Symfony 7.x
- Doctrine ORM
- Twig
- PHP 8.x
- FullCalendar.js
- PostgreSQL (ou MySQL selon config)

---

## Auteur
Développé dans le cadre du BTS SIO - D'Hegre Et Confort 
- Maxim SERMAND
- Alyssa ALLARD
- Giovanny BRUNET
- Lucas RAGUENEAU