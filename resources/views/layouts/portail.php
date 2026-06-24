<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $title ?? 'Portail' ?> — Ma Scolarité</title>
  <link rel="stylesheet" href="/css/app.css"/>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>"/>
</head>
<body>
<div class="app-layout">

  <!-- ── SIDEBAR ── -->
  <aside class="sidebar">
    <div class="sb-header">
      <div class="sb-brand">
        <span class="sb-brand-icon">📚</span>
        Ma Scolarité
      </div>
    </div>

    <div class="sb-user">
      <div class="sb-avatar">🎓</div>
      <div class="sb-name"><?= htmlspecialchars($etudiant['nom'] ?? 'Étudiant') . ' ' . htmlspecialchars($etudiant['prenom'] ?? '') ?></div>
      <div class="sb-mat"><?= htmlspecialchars($etudiant['matricule'] ?? 'MAT-XXXX-XXXX') ?></div>
      <span class="sb-role"><?= htmlspecialchars($etudiant['niveau'] ?? 'Licence') ?></span>
    </div>

    <div class="sb-divider"></div>

    <nav class="sb-nav">
      <a href="/portail/dashboard"
         class="sb-item <?= (str_contains($_SERVER['REQUEST_URI'], 'dashboard') ? 'active' : '') ?>">
        Tableau de bord
      </a>
      <a href="/portail/paiement"
         class="sb-item <?= (str_contains($_SERVER['REQUEST_URI'], 'paiement') ? 'active' : '') ?>">
        Payer ma scolarité
      </a>
      <a href="/portail/messages"
         class="sb-item <?= (str_contains($_SERVER['REQUEST_URI'], 'messages') ? 'active' : '') ?>">
        Messagerie
        <?php if (!empty($nbMessagesNonLus)): ?>
          <span class="badge-notif"><?= $nbMessagesNonLus ?></span>
        <?php endif; ?>
      </a>
      <!-- 'Demande de réduction' supprimée -->
      <a href="#" class="sb-item" id="chatbot-trigger-link">
        Aide / Chatbot
      </a>
    </nav>

    <div class="sb-divider"></div>
    <form method="POST" action="/portail/deconnexion">
      <input type="hidden" name="_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>"/>
      <button type="submit" class="sb-logout" style="border:none;background:none;width:100%;text-align:left;">
        ⬅ Se déconnecter
      </button>
    </form>
  </aside>

  <!-- ── MAIN ── -->
  <div class="main-wrap">

    <!-- Topbar -->
    <div class="topbar">
      <span class="topbar-title"><?= $pageTitle ?? 'Tableau de bord' ?></span>
      <div class="topbar-right">
        <span class="topbar-date">📅 <?= date('l d F Y', strtotime('now')) ?></span>
        <span class="badge badge-primary">
          <?= htmlspecialchars($etudiant['filiere'] ?? 'Informatique') ?> — <?= htmlspecialchars($etudiant['niveau'] ?? 'Licence') ?>
        </span>
      </div>
    </div>

    <!-- Flash messages -->
    <?php if (!empty($_SESSION['success'])): ?>
      <div class="alert alert-success" style="margin:16px 36px 0;">
        <span></span> <?= htmlspecialchars($_SESSION['success']) ?>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Contenu de la page -->
    <div class="content">
      <?= $content ?? '' ?>
    </div>
  </div>
</div>

<!-- CHATBOT -->
<button class="fab" id="chatbot-fab" title="Aide">🤖</button>
<div class="chatbot-modal" id="chatbot-modal">
  <div class="cb-header">
    <h4>🤖 Assistant Ma Scolarité</h4>
    <button id="chatbot-close">✕</button>
  </div>
  <div class="cb-messages" id="chatbot-messages"></div>
  <div class="cb-input-row">
    <input type="text" id="chatbot-input" placeholder="Posez votre question…"/>
    <button id="chatbot-send">➤</button>
  </div>
</div>

<div class="toast-container"></div>
<script src="/js/app.js"></script>
<script>
  // Lier le lien sidebar au FAB chatbot
  document.getElementById('chatbot-trigger-link')?.addEventListener('click', (e) => {
    e.preventDefault();
    document.getElementById('chatbot-fab').click();
  });
</script>
<?= $scripts ?? '' ?>
</body>
</html>

