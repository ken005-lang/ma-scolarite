<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Connexion Étudiant — Ma Scolarité</title>
  <link rel="stylesheet" href="/css/app.css"/>
</head>
<body>
<div class="auth-page">

  <!-- Gauche : branding -->
  <div class="auth-left">
    <div style="font-size:52px;margin-bottom:24px;">📚</div>
    <h1>Ma Scolarité</h1>
    <p>
      Accédez à votre portail étudiant pour consulter votre solde,
      effectuer vos paiements Mobile Money et échanger avec l'administration,
      tout depuis votre navigateur.
    </p>
    <div style="margin-top:36px;display:flex;flex-direction:column;gap:14px;">
      <div style="display:flex;align-items:center;gap:12px;color:rgba(255,255,255,.78);font-size:14px;">
        <span style="font-size:20px;">💳</span> Paiement Wave, Orange Money, MTN, Moov
      </div>
      <div style="display:flex;align-items:center;gap:12px;color:rgba(255,255,255,.78);font-size:14px;">
        <span style="font-size:20px;">📊</span> Suivi du solde en temps réel
      </div>
      <div style="display:flex;align-items:center;gap:12px;color:rgba(255,255,255,.78);font-size:14px;">
        <span style="font-size:20px;">📬</span> Messagerie avec l'administration
      </div>
      <div style="display:flex;align-items:center;gap:12px;color:rgba(255,255,255,.78);font-size:14px;">
        <span style="font-size:20px;">🔒</span> Accès sécurisé par matricule
      </div>
    </div>
  </div>

  <!-- Droite : formulaire — SANS champ mot de passe -->
  <div class="auth-right">
    <div class="auth-card">

      <div style="font-size:40px;margin-bottom:16px;">🎓</div>
      <h2>Espace Étudiant</h2>
      <p class="auth-sub">Connectez-vous avec votre matricule pour accéder à votre portail.</p>

      <!-- Formulaire : matricule uniquement -->
      <form onsubmit="return handleLogin(event)">
        <div style="display:flex;flex-direction:column;gap:20px;">
          <div class="form-group">
            <label class="form-label">Matricule étudiant <span style="color:var(--danger)">*</span></label>
            <input class="form-input" type="text" id="matricule"
                   placeholder="Ex : MAT-2026-0042"
                   style="font-family:monospace;letter-spacing:.5px;font-size:15px;"/>
          </div>
          <button type="submit" class="btn btn-primary btn-full" id="btn-login" style="padding:14px;">
            Se connecter →
          </button>
        </div>
      </form>

      <div style="margin-top:24px;text-align:center;font-size:13px;color:var(--grey-600);">
        Vous n'avez pas encore de matricule ?<br>
        <a href="/ecoles/ites" style="color:var(--primary);font-weight:600;">Candidater à l'ITES →</a>
      </div>

      <div style="margin-top:14px;text-align:center;font-size:12px;color:var(--grey-600);">
        Administration ?
        <a href="/admin/connexion" style="color:var(--grey-600);text-decoration:underline;">Accès admin</a>
      </div>

    </div>
  </div>
</div>

<div class="toast-container"></div>
<script src="/js/app.js"></script>
<script>
function handleLogin(e) {
  e.preventDefault();
  const mat = (document.getElementById('matricule').value || '').trim();
  const btn = document.getElementById('btn-login');
  btn.disabled = true;
  btn.textContent = '⏳ Connexion…';

  setTimeout(() => {
    // Accepter n'importe quel matricule pour la démo, ou vide → dashboard direct
    showToast('Connexion réussie ! Redirection…', 'success');
    setTimeout(() => { window.location.href = '/portail/dashboard'; }, 900);
  }, 800);
  return false;
}
</script>
</body>
</html>

