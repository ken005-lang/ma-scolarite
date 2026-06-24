<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ma Scolarité — Accueil</title>
  <link rel="stylesheet" href="/css/app.css"/>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>"/>
</head>
  <style>
    .schools-section { padding: 56px 200px 80px; }
    .schools-section-header { margin-bottom: 36px; }
    .schools-section-header h2 { font-size: 26px; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
    .schools-section-header p  { font-size: 15px; color: var(--grey-600); }
    .schools-grid { display: flex; gap: 36px; }

    .school-card {
      flex: 1; background: var(--white); border-radius: 16px;
      padding: 28px; box-shadow: var(--shadow);
      display: flex; flex-direction: column; gap: 14px;
      border: 2px solid transparent; transition: all .2s; position: relative;
    }
    .school-card.active { border-color: var(--primary); box-shadow: 0 8px 32px rgba(24,127,228,.16); cursor: pointer; }
    .school-card.inactive { opacity: .72; }
    .school-card:hover.active { transform: translateY(-3px); box-shadow: 0 12px 36px rgba(24,127,228,.22); }

    .school-card-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; }
    .school-card-name { font-size: 17px; font-weight: 700; color: var(--dark); line-height: 1.4; flex: 1; }
    .school-card-emoji { font-size: 36px; flex-shrink: 0; }
    .school-card-desc { font-size: 13px; color: var(--grey-600); line-height: 1.6; flex: 1; }
    .filiere-tags { display: flex; gap: 8px; flex-wrap: wrap; }
    .school-card-btn {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      padding: 13px; border-radius: var(--radius-sm);
      font-size: 14px; font-weight: 600; border: none;
      width: 100%; transition: all .18s; margin-top: auto;
    }
    .btn-active   { background: var(--primary); color: #fff; cursor: pointer; box-shadow: 0 4px 12px rgba(24,127,228,.28); }
    .btn-active:hover { background: var(--primary-dark); }
    .btn-inactive { background: var(--grey-100); color: var(--grey-600); cursor: not-allowed; }

    .hero-stats { display: flex; gap: 48px; padding: 28px 200px; background: var(--white); border-bottom: 1px solid var(--grey-100); }
    .hero-stat { display: flex; flex-direction: column; gap: 4px; }
    .hero-stat-value { font-size: 28px; font-weight: 700; color: var(--primary); }
    .hero-stat-label { font-size: 13px; color: var(--grey-600); }
  </style>
</head>
<body>

<!-- NAVBAR — sans bouton "Espace étudiant" -->
<header class="navbar">
  <a href="/" class="navbar-logo">
    <span>📚</span> Ma Scolarité
  </a>
  <nav class="navbar-links">
    <a href="/" class="active">Accueil</a>
    <a href="#ecoles">Écoles</a>
    <a href="#">À propos</a>
    <a href="#">Contact</a>
  </nav>
  <div class="navbar-actions">
    <a href="/admin/connexion" class="btn btn-primary btn-sm">Administration</a>
  </div>
</header>

<!-- HERO -->
<section class="hero">
  <div class="hero-title">Suivez votre scolarité,<br>en toute simplicité.</div>
  <p class="hero-sub">
    Paiements Mobile Money sécurisés, suivi du solde en temps réel,
    messagerie intégrée avec l'administration.
    Tout depuis votre téléphone ou votre ordinateur.
  </p>
  <div style="display:flex;gap:12px;margin-top:28px;">
    <a href="#ecoles" class="btn btn-white">Choisir mon école →</a>
    <a href="/portail/connexion" class="btn btn-outline" style="border-color:rgba(255,255,255,.5);color:#fff;">
      J'ai déjà un matricule
    </a>
  </div>
</section>

<!-- STATS -->
<div class="hero-stats">
  <div class="hero-stat"><span class="hero-stat-value">3</span><span class="hero-stat-label">Établissements partenaires</span></div>
  <div class="hero-stat"><span class="hero-stat-value">4</span><span class="hero-stat-label">Filières disponibles</span></div>
  <div class="hero-stat"><span class="hero-stat-value">4</span><span class="hero-stat-label">Opérateurs Mobile Money</span></div>
  <div class="hero-stat"><span class="hero-stat-value">100%</span><span class="hero-stat-label">Suivi en temps réel</span></div>
</div>

<!-- ÉCOLES -->
<section class="schools-section" id="ecoles">
  <div class="schools-section-header">
    <h2>Choisissez votre école</h2>
    <p>Sélectionnez l'établissement auquel vous souhaitez accéder pour voir les informations et vous inscrire.</p>
  </div>

  <div class="schools-grid">

    <!-- ITES II Plateaux — École active -->
    <div class="school-card active" onclick="window.location='/ecoles/ites'">
      <div class="school-card-top">
        <div class="school-card-name">ITES II Plateaux<br>Institut de Technologies et Spécialités</div>
        <span class="school-card-emoji">🎓</span>
      </div>
      <p class="school-card-desc">
        Grande école privée d'excellence créée en 1989, formant des élites dans les filières
        industrielles et tertiaires. Située à Cocody II Plateaux, quartier Sanon, Abidjan.
      </p>
      <div class="filiere-tags">
        <span class="badge badge-primary">Informatique</span>
        <span class="badge badge-primary">Électronique</span>
        <span class="badge badge-accent">Finance</span>
        <span class="badge badge-accent">Communication</span>
      </div>
      <button class="school-card-btn btn-active">Accéder à l'école →</button>
    </div>

    <!-- ISTP — Inactive -->
    <div class="school-card inactive">
      <div class="school-card-top">
        <div class="school-card-name">ISTP<br>Institut Supérieur de Technologie</div>
        <span class="school-card-emoji">🔧</span>
      </div>
      <p class="school-card-desc">
        Spécialisé en génie civil, mécanique industrielle et maintenance.
        Basé à Yopougon, Abidjan.
      </p>
      <div class="filiere-tags">
        <span class="badge badge-grey">Génie Civil</span>
        <span class="badge badge-grey">Maintenance</span>
      </div>
      <button class="school-card-btn btn-inactive" disabled>Accéder à l'école →</button>
    </div>

    <!-- ISCOM — Inactive -->
    <div class="school-card inactive">
      <div class="school-card-top">
        <div class="school-card-name">ISCOM<br>Institut Supérieur de Communication</div>
        <span class="school-card-emoji">📡</span>
      </div>
      <p class="school-card-desc">
        Journalisme, Relations Publiques, Marketing Digital et Audiovisuel.
        Basé à Plateau, Abidjan.
      </p>
      <div class="filiere-tags">
        <span class="badge badge-grey">Journalisme</span>
        <span class="badge badge-grey">Marketing Digital</span>
      </div>
      <button class="school-card-btn btn-inactive" disabled>Accéder à l'école →</button>
    </div>

  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <span class="footer-logo">📚 Ma Scolarité</span>
  <span>© 2026 Ma Scolarité — Digitalisation du suivi de la scolarité</span>
  <span>Mémoire de Licence Informatique · Abidjan, Côte d'Ivoire</span>
</footer>

<div class="toast-container"></div>
<script src="/js/app.js"></script>
</body>
</html>

