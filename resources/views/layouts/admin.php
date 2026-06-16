<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $title ?? 'Administration' ?> — Ma Scolarité Admin</title>
  <link rel="stylesheet" href="/css/app.css"/>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚙️</text></svg>"/>
</head>
<body>
<div class="app-layout">

  <!-- ── SIDEBAR ADMIN ── -->
  <aside class="sidebar">
    <div class="sb-header">
      <div class="sb-brand">
        <span class="sb-brand-icon">📚</span>
        Ma Scolarité
      </div>
    </div>

    <div class="sb-user">
      <div class="sb-avatar">👤</div>
      <div class="sb-name"><?= htmlspecialchars($admin['nom'] ?? 'Directeur ITES II Plateaux') ?></div>
      <div class="sb-mat"><?= htmlspecialchars($admin['email'] ?? 'admin@ites.ci') ?></div>
      <span class="sb-role"><?= htmlspecialchars($admin['role'] ?? 'Super Admin') ?></span>
    </div>

    <div class="sb-divider"></div>

    <nav class="sb-nav">
      <a href="/admin/dashboard"
         class="sb-item <?= (str_contains($_SERVER['REQUEST_URI'], '/admin/dashboard') ? 'active' : '') ?>">
        Tableau de bord
      </a>
      <a href="/admin/candidatures"
         class="sb-item <?= (str_contains($_SERVER['REQUEST_URI'], 'candidatures') ? 'active' : '') ?>">
        Candidatures
        <?php if (!empty($nbCandidaturesAttente)): ?>
          <span class="badge-notif"><?= $nbCandidaturesAttente ?></span>
        <?php endif; ?>
      </a>
      <a href="/admin/paiements"
         class="sb-item <?= (str_contains($_SERVER['REQUEST_URI'], 'paiements') ? 'active' : '') ?>">
        Paiements
        <?php if (!empty($nbPaiementsAttente)): ?>
          <span class="badge-notif"><?= $nbPaiementsAttente ?></span>
        <?php endif; ?>
      </a>
      <a href="/admin/etudiants"
         class="sb-item <?= (str_contains($_SERVER['REQUEST_URI'], 'etudiants') ? 'active' : '') ?>">
        Étudiants
      </a>
      <a href="/admin/documents"
         class="sb-item <?= (str_contains($_SERVER['REQUEST_URI'], 'documents') ? 'active' : '') ?>">
        Documents
      </a>
      <a href="/admin/messages"
         class="sb-item <?= (str_contains($_SERVER['REQUEST_URI'], '/admin/messages') ? 'active' : '') ?>">
        Messagerie
        <?php if (!empty($nbMessagesNonLus)): ?>
          <span class="badge-notif"><?= $nbMessagesNonLus ?></span>
        <?php endif; ?>
      </a>
    </nav>

    <div class="sb-divider"></div>
    <form method="POST" action="/admin/deconnexion">
      <input type="hidden" name="_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>"/>
      <button type="submit" class="sb-logout" style="border:none;background:none;width:100%;text-align:left;">
        Se déconnecter
      </button>
    </form>
  </aside>

  <!-- ── MAIN ADMIN ── -->
  <div class="main-wrap">

    <div class="topbar">
      <span class="topbar-title"><?= $pageTitle ?? 'Tableau de bord' ?></span>
      <div class="topbar-right">
        <span class="topbar-date">📅 <?= date('d F Y') ?></span>
        <span class="badge badge-primary">Super Admin</span>
      </div>
    </div>

    <?php if (!empty($_SESSION['success'])): ?>
      <div class="alert alert-success" style="margin:16px 36px 0;">
        <span>✅</span> <?= htmlspecialchars($_SESSION['success']) ?>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['error'])): ?>
      <div class="alert alert-danger" style="margin:16px 36px 0;">
        <span>❌</span> <?= htmlspecialchars($_SESSION['error']) ?>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="content">
      <?= $content ?? '' ?>
    </div>
  </div>
</div>

<div class="toast-container"></div>
<script src="/js/app.js"></script>
<?= $scripts ?? '' ?>
</body>
</html>
