<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ITES II Plateaux — Institut de Technologies et Spécialités</title>
  <link rel="stylesheet" href="/css/app.css"/>
  <style>
    .school-header {
      background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
      padding: 40px 200px; display: flex; align-items: center; gap: 28px;
    }
    .school-header-logo {
      width: 88px; height: 88px; border-radius: 50%;
      background: var(--white); display: flex; align-items: center;
      justify-content: center; font-size: 40px; flex-shrink: 0;
    }
    .school-header-info h1 { font-size: 28px; font-weight: 700; color: #fff; margin-bottom: 8px; }
    .school-header-socials { display: flex; gap: 10px; flex-wrap: wrap; }
    .social-tag {
      background: rgba(255,255,255,.15); color: #fff;
      border-radius: var(--radius-full); padding: 4px 14px;
      font-size: 12px; font-weight: 500; text-decoration: none;
      transition: background .15s;
    }
    .social-tag:hover { background: rgba(255,255,255,.28); }

    .school-content { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; padding: 40px 200px 64px; }

    /* Documents */
    .doc-row {
      display: flex; align-items: center; gap: 14px;
      padding: 14px 16px; border-radius: 10px; margin-bottom: 10px;
      border: 1px solid transparent; transition: all .15s;
    }
    .doc-row.obligatoire { background: var(--primary-light); border-color: var(--primary); }
    .doc-row.optionnel   { background: var(--grey-100); border-color: var(--grey-300); }
    .doc-icon { font-size: 28px; flex-shrink: 0; }
    .doc-info { flex: 1; }
    .doc-name { font-size: 14px; font-weight: 600; color: var(--dark); }
    .doc-meta { font-size: 11px; color: var(--grey-600); margin-top: 2px; }
    .doc-meta.required { color: var(--primary); font-weight: 600; }

    /* Filières */
    .filieres-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 12px; }
    .filiere-tag {
      display: flex; align-items: center; gap: 8px;
      padding: 12px 16px; border-radius: 10px;
      font-size: 13px; font-weight: 600;
    }
    .filiere-industrielle { background: var(--primary-light); color: var(--primary); }
    .filiere-tertiaire    { background: var(--accent-light);  color: var(--accent); }

    /* Bouton inscription */
    .inscrire-section { margin-top: 20px; }
    #btn-inscrire {
      background: var(--accent); color: #fff;
      border: none; border-radius: var(--radius-sm);
      padding: 16px 32px; font-size: 16px; font-weight: 700;
      width: 100%; cursor: pointer; text-align: center;
      box-shadow: 0 6px 20px rgba(30,193,148,.3);
      display: flex; align-items: center; justify-content: center; gap: 10px;
      transition: all .2s; text-decoration: none;
    }
    #btn-inscrire:hover { filter: brightness(1.06); transform: translateY(-2px); }
    #note-inscription { font-size: 12px; color: var(--grey-600); text-align: center; margin-top: 10px; }
  </style>
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
  <a href="/" class="navbar-logo"><span>📚</span> Ma Scolarité</a>
  <nav class="navbar-links">
    <a href="/">Accueil</a>
    <a href="/ecoles/ites" class="active">Écoles</a>
    <a href="#">À propos</a>
    <a href="#">Contact</a>
  </nav>
  <div class="navbar-actions">
    <a href="/portail/connexion" class="btn btn-primary">Se connecter</a>
  </div>
</header>

<!-- BREADCRUMB -->
<div style="padding:12px 200px;font-size:13px;color:var(--grey-600);background:var(--white);border-bottom:1px solid var(--grey-100);">
  <a href="/" style="color:var(--primary);">Accueil</a> › ITES II Plateaux
</div>

<!-- HEADER ÉCOLE -->
<div class="school-header">
  <div class="school-header-logo">🎓</div>
  <div class="school-header-info">
    <h1>ITES II Plateaux — Institut de Technologies et Spécialités</h1>
    <div class="school-header-socials">
      <a href="#" class="social-tag">🌐 Site web</a>
      <a href="#" class="social-tag">📘 Facebook</a>
      <a href="#" class="social-tag">📸 Instagram</a>
      <a href="#" class="social-tag">📞 +225 07 47 95 22 14</a>
    </div>
  </div>
</div>

<!-- CONTENU -->
<div class="school-content">

  <!-- COLONNE GAUCHE : Présentation + Filières -->
  <div style="display:flex;flex-direction:column;gap:20px;">

    <div class="card">
      <div class="card-title">Présentation de l'école</div>
      <div class="card-divider"></div>
      <p style="font-size:14px;color:var(--grey-600);line-height:1.7;">
        L'ITES II Plateaux est un établissement d'enseignement supérieur privé basé à Cocody, Abidjan,
        Côte d'Ivoire. Fondée en 2005, elle forme des cadres compétents dans les domaines
        du commerce, de la finance, de la communication et des nouvelles technologies.
      </p>
      <p style="font-size:14px;color:var(--grey-600);line-height:1.7;margin-top:12px;">
        Notre mission est d'offrir une formation de qualité, accessible et adaptée aux réalités
        économiques de la région UEMOA. Nous accompagnons nos étudiants de l'inscription
        jusqu'à l'insertion professionnelle.
      </p>
      <div style="margin-top:16px;display:flex;flex-direction:column;gap:6px;font-size:13px;color:var(--grey-600);">
        <span>🏛️ Quartier Sanon, Cocody II Plateaux, Abidjan</span>
        <span>📞 +225 07 47 95 22 14</span>
        <span>✉️ contact@ites-iiplateaux.ci</span>
      </div>
    </div>

    <div class="card">
      <div class="card-title">Filières disponibles</div>
      <div class="card-divider"></div>
      <div style="margin-bottom:10px;">
        <div style="font-size:12px;font-weight:600;color:var(--grey-600);text-transform:uppercase;letter-spacing:.4px;margin-bottom:8px;">
          Filières industrielles
        </div>
        <div class="filieres-grid" style="grid-template-columns:1fr 1fr;margin-bottom:14px;">
          <div class="filiere-tag filiere-industrielle">💻 Informatique</div>
          <div class="filiere-tag filiere-industrielle">⚙️ Mécatronique</div>
        </div>
        <div style="font-size:12px;font-weight:600;color:var(--grey-600);text-transform:uppercase;letter-spacing:.4px;margin-bottom:8px;">
          Filières tertiaires
        </div>
        <div class="filieres-grid" style="grid-template-columns:1fr 1fr;">
          <div class="filiere-tag filiere-tertiaire">💰 Finance</div>
          <div class="filiere-tag filiere-tertiaire">📡 Communication</div>
        </div>
      </div>
    </div>

  </div>

  <!-- COLONNE DROITE : Documents + Inscription -->
  <div style="display:flex;flex-direction:column;gap:20px;">

    <div class="card">
      <div class="card-title">Documents à télécharger</div>
      <div class="card-divider"></div>

      <!-- Document OBLIGATOIRE -->
      <div class="doc-row obligatoire">
        <span class="doc-icon">📄</span>
        <div class="doc-info">
          <div class="doc-name">Grille des frais de scolarité 2026</div>
          <div class="doc-meta required">📌 OBLIGATOIRE — PDF · 245 Ko</div>
        </div>
        <a href="/documents/telecharger/1"
           class="btn btn-primary btn-sm"
           id="btn-dl-obligatoire"
           download>
          ⬇ Télécharger
        </a>
      </div>

      <!-- Documents optionnels -->
      <div class="doc-row optionnel">
        <span class="doc-icon">📄</span>
        <div class="doc-info">
          <div class="doc-name">Guide d'inscription étudiant</div>
          <div class="doc-meta">PDF · 180 Ko</div>
        </div>
        <a href="/documents/telecharger/2" class="btn btn-ghost btn-sm" download>⬇ Télécharger</a>
      </div>

      <div class="doc-row optionnel">
        <span class="doc-icon">🎬</span>
        <div class="doc-info">
          <div class="doc-name">Présentation de l'école (vidéo)</div>
          <div class="doc-meta">MP4 · 12 Mo</div>
        </div>
        <a href="/documents/telecharger/3" class="btn btn-ghost btn-sm" download>⬇ Télécharger</a>
      </div>

      <div class="doc-row optionnel">
        <span class="doc-icon">📄</span>
        <div class="doc-info">
          <div class="doc-name">Règlement intérieur</div>
          <div class="doc-meta">PDF · 320 Ko</div>
        </div>
        <a href="/documents/telecharger/4" class="btn btn-ghost btn-sm" download>⬇ Télécharger</a>
      </div>

    </div>

    <!-- BOUTON INSCRIPTION -->
    <div class="card">
      <div class="inscrire-section">
        <!-- Bouton caché par défaut, visible après téléchargement -->
        <a href="/ecoles/ites/candidature" class="btn hidden" id="btn-inscrire">
          S'inscrire à cette école
        </a>

        <!-- Message avant téléchargement -->
        <div id="note-inscription"
             style="background:var(--warning-light);border:1px solid var(--warning);border-radius:var(--radius-sm);padding:16px;text-align:center;">
          <div style="font-size:20px;margin-bottom:6px;">⬇️</div>
          <div style="font-size:13px;font-weight:600;color:#7A4700;">
            Téléchargez d'abord la grille des frais (document obligatoire)
          </div>
          <div style="font-size:12px;color:var(--grey-600);margin-top:4px;">
            Le bouton d'inscription apparaîtra automatiquement après le téléchargement.
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

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
