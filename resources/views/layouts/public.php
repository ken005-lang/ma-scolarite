<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $title ?? 'Ma Scolarité' ?> — Ma Scolarité</title>
  <meta name="description" content="Plateforme de suivi de scolarité en ligne — Côte d'Ivoire"/>
  <link rel="stylesheet" href="/css/app.css"/>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>"/>
  <?= $head ?? '' ?>
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
  <a href="/" class="navbar-logo">
    <span>📚</span> Ma Scolarité
  </a>
  <nav class="navbar-links">
    <a href="/" class="<?= ($_SERVER['REQUEST_URI'] === '/' ? 'active' : '') ?>">Accueil</a>
    <a href="/ecoles/esca" class="<?= (str_contains($_SERVER['REQUEST_URI'] ?? '', 'ecoles') ? 'active' : '') ?>">Écoles</a>
    <a href="#">À propos</a>
    <a href="#">Contact</a>
  </nav>
  <div class="navbar-actions">
    <?php if (!empty($showLogin)): ?>
      <a href="/portail/connexion" class="btn btn-primary">Se connecter</a>
    <?php endif; ?>
  </div>
</header>

<!-- FLASH MESSAGES -->
<?php if (!empty($_SESSION['success'])): ?>
  <div class="alert alert-success" style="margin:16px 64px;">
    <span></span> <?= htmlspecialchars($_SESSION['success']) ?>
  </div>
  <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger" style="margin:16px 64px;">
    <span></span> <?= htmlspecialchars($_SESSION['error']) ?>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- CONTENU -->
<main>
  <?= $content ?? '' ?>
</main>

<!-- FOOTER -->
<footer class="footer">
  <span class="footer-logo">📚 Ma Scolarité</span>
  <span>© 2026 Ma Scolarité — Digitalisation du suivi de la scolarité</span>
  <span>Mémoire de Licence Informatique · Abidjan, Côte d'Ivoire</span>
</footer>

<!-- TOAST CONTAINER -->
<div class="toast-container"></div>

<script src="/js/app.js"></script>
<?= $scripts ?? '' ?>
</body>
</html>

