<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Administration — Ma Scolarité</title>
  <link rel="stylesheet" href="/css/app.css"/>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>"/>
</head>
  <style>
    .auth-tabs { display:flex; gap:0; margin-bottom:28px; border-bottom:2px solid var(--grey-100); }
    .auth-tab {
      flex:1; padding:12px; text-align:center; font-size:14px; font-weight:600;
      cursor:pointer; color:var(--grey-600); border-bottom:2px solid transparent;
      margin-bottom:-2px; transition:all .15s;
    }
    .auth-tab.active { color:var(--primary); border-bottom-color:var(--primary); }
    .auth-tab:hover:not(.active) { color:var(--dark); background:var(--grey-100); }
    .auth-panel { display:none; }
    .auth-panel.active { display:block; }
  </style>
</head>
<body>
<div class="auth-page">

  <!-- Gauche -->
  <div class="auth-left" style="background:linear-gradient(135deg,#0A3A6B,var(--primary-dark));">
    <div style="font-size:52px;margin-bottom:24px;">⚙️</div>
    <h1>Administration</h1>
    <p>
      Gérez les candidatures, validez les paiements, suivez les recouvrements
      et communiquez avec les étudiants.
    </p>
    <div style="margin-top:36px;display:flex;flex-direction:column;gap:14px;">
      <div style="display:flex;align-items:center;gap:12px;color:rgba(255,255,255,.78);font-size:14px;">
        <span style="font-size:20px;">📋</span> Gestion des candidatures
      </div>
      <div style="display:flex;align-items:center;gap:12px;color:rgba(255,255,255,.78);font-size:14px;">
        <span style="font-size:20px;">💰</span> Validation des paiements
      </div>
      <div style="display:flex;align-items:center;gap:12px;color:rgba(255,255,255,.78);font-size:14px;">
        <span style="font-size:20px;">🎓</span> Attribution des matricules
      </div>
      <div style="display:flex;align-items:center;gap:12px;color:rgba(255,255,255,.78);font-size:14px;">
        <span style="font-size:20px;">📊</span> Tableau de bord et statistiques
      </div>
    </div>
  </div>

  <!-- Droite -->
  <div class="auth-right">
    <div class="auth-card">

      <div style="font-size:40px;margin-bottom:16px;">🔐</div>

      <!-- Onglets Connexion / Inscription -->
      <div class="auth-tabs">
        <div class="auth-tab active" onclick="switchTab('connexion')">Connexion</div>
        <div class="auth-tab" onclick="switchTab('inscription')">Créer un compte</div>
      </div>

      <!-- ── PANNEAU CONNEXION ── -->
      <div class="auth-panel active" id="panel-connexion">
        <h2 style="margin-bottom:6px;">Accès Administration</h2>
        <p class="auth-sub">Connectez-vous avec vos identifiants administrateur.</p>

        <form onsubmit="return handleAdminLogin(event)">
          <div style="display:flex;flex-direction:column;gap:18px;">
            <div class="form-group">
              <label class="form-label">Adresse email professionnelle</label>
              <input class="form-input" type="email" id="admin-email" placeholder="admin@ites.ci"/>
            </div>
            <div class="form-group">
              <label class="form-label">Mot de passe</label>
              <input class="form-input" type="password" id="admin-password" placeholder="Votre mot de passe"/>
            </div>
            <button type="submit" class="btn btn-primary btn-full" id="btn-admin-login" style="padding:14px;">
              Accéder au dashboard →
            </button>
          </div>
        </form>
      </div>

      <!-- ── PANNEAU INSCRIPTION ── -->
      <div class="auth-panel" id="panel-inscription">
        <h2 style="margin-bottom:6px;">Créer un compte admin</h2>
        <p class="auth-sub">Remplissez les informations pour créer votre accès administrateur.</p>

        <form onsubmit="return handleAdminRegister(event)">
          <div style="display:flex;flex-direction:column;gap:16px;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
              <div class="form-group">
                <label class="form-label">Nom de l'établissement</label>
                <input class="form-input" type="text" placeholder="Votre nom"/>
              </div>
              <!--<div class="form-group">
                <label class="form-label">Prénom</label>
                <input class="form-input" type="text" placeholder="Votre prénom"/>
              </div>
            </div>-->
            <br>
            <div class="form-group">
              <label class="form-label">Adresse email professionnelle</label>
              <input class="form-input" type="email" placeholder="votre@ites.ci"/>
            </div>
            <!--<div class="form-group">
              <label class="form-label">Rôle</label>
              <select class="form-select">
                <option value="">-- Choisir un rôle --</option>
                <option value="super_admin">Super Administrateur</option>
                <option value="secretaire">Secrétaire</option>
                <option value="comptable">Comptable</option>
              </select>
            </div>-->
            <br>
            <div class="form-group">
              <label class="form-label">Mot de passe</label>
              <input class="form-input" type="password" placeholder="Créez un mot de passe sécurisé"/>
            </div>
            <br>
            <div class="form-group">
              <label class="form-label">Confirmer le mot de passe</label>
              <input class="form-input" type="password" placeholder="Répétez le mot de passe"/>
            </div>
            <button type="submit" class="btn btn-accent btn-full" style="padding:14px;">
              Créer mon compte →
            </button>
          </div>
        </form>
      </div>

      <div style="margin-top:18px;text-align:center;font-size:12px;color:var(--grey-600);">
        <a href="/" style="color:var(--grey-600);text-decoration:underline;">← Retour à l'accueil</a>
        &nbsp;·&nbsp;
        <a href="/portail/connexion" style="color:var(--grey-600);text-decoration:underline;">Espace étudiant</a>
      </div>

    </div>
  </div>
</div>

<div class="toast-container"></div>
<script src="/js/app.js"></script>
<script>
function switchTab(tab) {
  document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.auth-panel').forEach(p => p.classList.remove('active'));
  document.querySelector(`.auth-tab:nth-child(${tab==='connexion'?1:2})`).classList.add('active');
  document.getElementById(`panel-${tab}`).classList.add('active');
}

function handleAdminLogin(e) {
  e.preventDefault();
  const btn = document.getElementById('btn-admin-login');
  btn.disabled = true;
  btn.textContent = '⏳ Connexion…';
  // Pas de vérification — accès direct pour la démo
  setTimeout(() => {
    showToast('Connexion réussie ! Redirection…', 'success');
    setTimeout(() => { window.location.href = '/admin/dashboard'; }, 900);
  }, 800);
  return false;
}

function handleAdminRegister(e) {
  e.preventDefault();
  showToast('Compte créé avec succès ! Connexion en cours…', 'success');
  setTimeout(() => { window.location.href = '/admin/dashboard'; }, 1200);
  return false;
}
</script>
</body>
</html>

