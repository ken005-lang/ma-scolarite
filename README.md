# 📚 Ma Scolarité — Simulation Web
### Mémoire de Licence Informatique · La digitalisation du suivi de la scolarité
**Stack : PHP natif · CSS custom · JS vanilla · Aucune dépendance externe**

---

## 🚀 Démarrage en 30 secondes

### Prérequis
- PHP 8.0 ou supérieur installé sur votre machine
- VSCode (ou tout éditeur)

### Lancer le projet

```bash
# 1. Cloner / ouvrir le dossier dans VSCode

# 2. Ouvrir un terminal dans VSCode (Ctrl + `)

# 3. Aller dans le dossier public
cd public

# 4. Lancer le serveur PHP intégré
php -S localhost:8000 index.php

# 5. Ouvrir dans le navigateur
# http://localhost:8000
```

> ✅ C'est tout. Aucune installation npm, composer ou base de données requise pour la simulation.

---

## 🔐 Identifiants de démonstration

| Espace | Identifiant | Mot de passe |
|---|---|---|
| **Portail Étudiant** | `MAT-2026-0042` | `MAT-2026-0042` |
| **Administration** | `admin@esca.ci` | `Admin@2026` |

---

## 🗺️ Navigation complète du site

```
http://localhost:8000/                        → Accueil (3 cartes écoles)
http://localhost:8000/ecoles/esca             → Présentation ESCA + documents
http://localhost:8000/ecoles/esca/candidature → Formulaire candidature (4 étapes)
http://localhost:8000/inscription/paiement    → Paiement frais inscription
http://localhost:8000/portail/connexion       → Connexion étudiant
http://localhost:8000/portail/dashboard       → Tableau de bord étudiant
http://localhost:8000/portail/paiement        → Paiement Mobile Money
http://localhost:8000/admin/connexion         → Connexion administration
http://localhost:8000/admin/dashboard         → Dashboard admin (vue générale)
http://localhost:8000/admin/dashboard?vue=messagerie          → Messagerie + candidatures
http://localhost:8000/admin/dashboard?vue=messagerie&id=1     → Détail candidature #1
http://localhost:8000/admin/dashboard?vue=messagerie&id=2     → Détail candidature #2
```

---

## 📁 Structure des fichiers

```
ma-scolarite/
│
├── public/                          ← Dossier racine du serveur
│   ├── index.php                    ← Routeur principal (point d'entrée)
│   ├── css/
│   │   └── app.css                  ← Design system complet (tokens + composants)
│   └── js/
│       └── app.js                   ← Logique JS (chatbot, stepper, paiement…)
│
└── resources/
    └── views/
        ├── layouts/
        │   ├── public.php           ← Layout pages publiques
        │   ├── portail.php          ← Layout portail étudiant
        │   └── admin.php            ← Layout administration
        │
        ├── public/
        │   ├── home.php             ← Écran 01 — Accueil
        │   ├── ecole.php            ← Écran 02 — Présentation école
        │   ├── candidature.php      ← Écran 03 — Formulaire candidature
        │   └── paiement-inscription.php  ← Écran 04 — Paiement frais inscription
        │
        ├── portail/
        │   ├── login.php            ← Connexion étudiant
        │   ├── dashboard.php        ← Écran 05 — Tableau de bord étudiant
        │   └── paiement.php         ← Paiement Mobile Money (avec simulation)
        │
        └── admin/
            ├── login.php            ← Connexion administration
            └── dashboard.php        ← Écran 06 — Dashboard + Messagerie admin
```

---

## 🎬 Scénarios de démonstration (jury)

### Scénario A — "Le candidat" (5 min)
1. Aller sur `http://localhost:8000`
2. Cliquer sur la carte **ESCA**
3. Télécharger la **grille des frais** → le bouton "S'inscrire" apparaît
4. Cliquer sur "S'inscrire" → remplir les 4 étapes du formulaire
5. Soumettre → message de confirmation affiché

### Scénario B — "L'administration valide" (3 min)
1. Aller sur `http://localhost:8000/admin/connexion`
2. Se connecter avec `admin@esca.ci` / `Admin@2026`
3. Aller dans **Candidatures** (menu sidebar)
4. Cliquer sur **KOUAMÉ Aya Marie** → examiner le dossier
5. Cliquer **"✅ Accepter la candidature"** → toast de confirmation

### Scénario C — "L'étudiant paie" (4 min)
1. Aller sur `http://localhost:8000/portail/connexion`
2. Se connecter avec `MAT-2026-0042` / `MAT-2026-0042`
3. Observer le **tableau de bord** : KPI, barre de progression 49%
4. Cliquer sur **"Payer maintenant"**
5. Choisir **Wave**, entrer un montant (ex : 90 000), entrer un numéro
6. Cliquer **"Confirmer le paiement"**
7. Cliquer **"[DÉMO] Simuler la confirmation OTP"**
8. Observer les 4 étapes s'animer, puis l'écran de succès

### Scénario D — "Validation paiement physique" (2 min)
1. Dans le dashboard admin → cliquer **"Paiements physiques"** (onglet messagerie)
2. Voir les 3 paiements en attente
3. Cliquer **"✅ Valider"** sur KOUASSI Ama → confirmation dialog → toast succès

---

## 🎨 Design System — Couleurs

| Token | Valeur | Usage |
|---|---|---|
| `--primary` | `#187FE4` | Bleu principal — actions, liens actifs |
| `--primary-dark` | `#0E53A1` | Sidebar, dégradés |
| `--primary-light` | `#E0EFFF` | Fonds clairs, badges |
| `--accent` | `#1EC194` | Vert succès — confirmations, progression |
| `--warning` | `#FF9E00` | Orange — solde restant, en attente |
| `--danger` | `#EF4444` | Rouge — refus, erreurs |
| `--dark` | `#13192C` | Texte principal |
| `--grey-600` | `#687489` | Texte secondaire |
| `--bg` | `#F7F8FC` | Fond général |

---

## ⚙️ Extension VSCode recommandée

Installer l'extension **PHP Server** (bilernetcilik.php-server) pour lancer
le serveur en un clic depuis VSCode sans passer par le terminal.

Ou utiliser le raccourci terminal intégré VSCode :
```
Ctrl + `  →  cd public  →  php -S localhost:8000 index.php
```

---

## 📝 Notes pour le mémoire

- Toutes les données sont **simulées en dur** dans les vues PHP (pas de base de données)
- Les paiements Mobile Money sont **simulés** : le bouton "[DÉMO] Simuler" joue le rôle du callback API
- Les emails sont **simulés** : les toasts verts jouent le rôle des notifications email
- Le chatbot répond à **10 questions types** sur l'application en JS pur
- La session PHP est utilisée pour l'authentification simulée (pas de JWT ni de guard)

---

*Projet réalisé dans le cadre d'un mémoire de Licence Informatique*
*Thème : La digitalisation du suivi de la scolarité — Côte d'Ivoire, 2026*
