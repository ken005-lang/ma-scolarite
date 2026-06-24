<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Paiement des frais d'inscription — Ma Scolarité</title>
  <link rel="stylesheet" href="/css/app.css"/>
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📚</text></svg>"/>
</head>
  <style>
    .pay-page { max-width: 1060px; margin: 0 auto; padding: 32px 24px 80px; }
    .pay-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 24px; }

    /* Montant */
    .montant-line { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; font-size: 14px; }
    .montant-line.total { border-top: 2px solid var(--grey-100); margin-top: 8px; padding-top: 14px; }
    .montant-line.total .montant-val { font-size: 20px; font-weight: 700; color: var(--primary); }

    /* Opérateurs */
    .op-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin: 14px 0; }
    .op-btn {
      display: flex; flex-direction: column; align-items: center; gap: 6px;
      padding: 14px 10px; border: 2px solid var(--grey-300); border-radius: var(--radius);
      background: var(--white); cursor: pointer; transition: all .15s; font-size: 12px; font-weight: 600;
    }
    .op-btn span { font-size: 26px; }
    .op-btn:hover, .op-btn.selected { border-color: var(--primary); background: var(--primary-light); }
    .op-btn.wave   .op-name { color: #0E9CE0; }
    .op-btn.orange .op-name { color: #FF6600; }
    .op-btn.mtn    .op-name { color: #CC9900; }
    .op-btn.moov   .op-name { color: var(--primary); }

    /* Paiement physique */
    .physical-section {
      border-top: 1px solid var(--grey-100); margin-top: 24px; padding-top: 20px;
    }
    .physical-title { font-size: 14px; font-weight: 700; color: var(--dark); margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }

    /* Confirmation */
    .confirmation-card {
      max-width: 560px; margin: 80px auto; text-align: center;
      background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow); padding: 48px 40px;
    }
    .confirmation-icon { font-size: 64px; margin-bottom: 20px; }
    .confirmation-title { font-size: 26px; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
    .confirmation-sub   { font-size: 15px; color: var(--grey-600); margin-bottom: 28px; }
  </style>
</head>
<body style="background:var(--bg);">

<header class="navbar">
  <a href="/" class="navbar-logo"><span>📚</span> Ma Scolarité</a>
</header>

<!-- ══ PAGE PAIEMENT ══ -->
<div class="pay-page" id="page-paiement">

  <div style="margin-bottom:24px;">
    <div style="font-size:13px;color:var(--grey-600);margin-bottom:8px;">Processus d'inscription › Paiement</div>
    <h1 style="font-size:28px;font-weight:700;color:var(--dark);">Paiement des frais d'inscription</h1>
    <p style="font-size:14px;color:var(--grey-600);margin-top:4px;">ITES II Plateaux — École Supérieure de Commerce d'Abidjan</p>
  </div>

  <!-- Alerte acceptation -->
  <div class="alert alert-success">
    <span>🎉</span>
    <div>
      <strong>Félicitations ! Votre candidature a été acceptée.</strong><br>
      Veuillez procéder au paiement des frais d'inscription pour finaliser votre dossier et obtenir votre matricule.
    </div>
  </div>

  <div class="pay-grid">

    <!-- COLONNE GAUCHE : Montant + Référence -->
    <div style="display:flex;flex-direction:column;gap:16px;">

      <div class="card">
        <div class="card-title">Montant à régler</div>
        <div class="card-divider"></div>
        <div class="montant-line">
          <span style="color:var(--grey-600);">Frais d'inscription</span>
          <span style="font-weight:600;">125 000 FCFA</span>
        </div>
        <div class="montant-line">
          <span style="color:var(--grey-600);">Frais annexes (dossier, badge…)</span>
          <span style="font-weight:600;">15 000 FCFA</span>
        </div>
        <div class="montant-line total">
          <span style="font-weight:700;color:var(--dark);">Total à payer</span>
          <span class="montant-val">140 000 FCFA</span>
        </div>
      </div>

      <div class="card">
        <div class="card-title">Votre référence de paiement</div>
        <div class="card-divider"></div>
        <div class="ref-box">
          <div class="ref-code">SCO-ETU0001-INSCR-2026</div>
          <div class="ref-hint">Utilisez cette référence pour tout paiement physique en agence bancaire</div>
        </div>
        <div class="alert alert-info" style="margin-top:12px;">
          <span>ℹ️</span>
          <div>Cette référence est unique et liée à votre dossier. Conservez-la précieusement.</div>
        </div>
      </div>

    </div>

    <!-- COLONNE DROITE : Modes de paiement -->
    <div class="card">
      <div class="card-title">Choisir votre mode de paiement</div>
      <div class="card-divider"></div>

      <!-- Mobile Money -->
      <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--grey-600);margin-bottom:10px;">
        📱 Paiement Mobile Money
      </div>

      <input type="hidden" id="operateur_selectionne" value=""/>
      <div class="op-grid">
        <button type="button" class="op-btn wave" data-operateur="wave" onclick="selectOp(this)">
          <span>🌊</span>
          <span class="op-name">Wave</span>
        </button>
        <button type="button" class="op-btn orange" data-operateur="orange_money" onclick="selectOp(this)">
          <span>🟠</span>
          <span class="op-name">Orange Money</span>
        </button>
        <button type="button" class="op-btn mtn" data-operateur="mtn" onclick="selectOp(this)">
          <span>🟡</span>
          <span class="op-name">MTN MoMo</span>
        </button>
        <button type="button" class="op-btn moov" data-operateur="moov" onclick="selectOp(this)">
          <span>🔵</span>
          <span class="op-name">Moov Money</span>
        </button>
      </div>

      <div class="form-group" style="margin-top:14px;">
        <label class="form-label">Numéro de téléphone <span style="color:var(--danger);">*</span></label>
        <input class="form-input" type="tel" id="tel_paiement" placeholder="+225 07 XX XX XX XX"/>
      </div>

      <!-- Récapitulatif avant confirmation -->
      <div id="recap-mm" style="display:none;background:var(--grey-100);border-radius:var(--radius-sm);padding:14px;margin-top:12px;font-size:13px;">
        <div style="font-weight:700;margin-bottom:8px;color:var(--dark);">Récapitulatif</div>
        <div style="display:flex;justify-content:space-between;margin-bottom:4px;"><span style="color:var(--grey-600);">Montant</span><strong>140 000 FCFA</strong></div>
        <div style="display:flex;justify-content:space-between;margin-bottom:4px;"><span style="color:var(--grey-600);">Opérateur</span><strong id="recap-op">—</strong></div>
        <div style="display:flex;justify-content:space-between;"><span style="color:var(--grey-600);">Numéro</span><strong id="recap-tel-mm">—</strong></div>
      </div>

      <button type="button" class="btn btn-primary btn-full" style="margin-top:16px;" onclick="lancerPaiementMM()">
        💳 Payer maintenant — 140 000 FCFA
      </button>

      <!-- Simuler (mode démo) -->
      <button type="button" class="btn btn-ghost btn-full btn-sm" id="btn-simuler" style="margin-top:8px;display:none;" onclick="simulerPaiementInscription()">
        🎬 [DÉMO] Simuler la confirmation du paiement
      </button>

      <!-- Paiement physique -->
      <div class="physical-section">
        <div class="physical-title">
          <span>🏦</span> Paiement physique en banque (NSIA / UBA)
        </div>
        <p style="font-size:12px;color:var(--grey-600);margin-bottom:12px;line-height:1.6;">
          Après avoir effectué le virement en agence avec votre référence
          <strong>SCO-ETU0001-INSCR-2026</strong>, entrez votre N° de reçu ci-dessous.
          L'administration vérifiera et validera votre paiement sous 24h.
        </p>
        <div class="form-group">
          <label class="form-label">N° de reçu bancaire</label>
          <input class="form-input" type="text" id="ref_bancaire" placeholder="Ex : NSIA-2026-000123"/>
        </div>
        <button type="button" class="btn btn-ghost btn-full" style="margin-top:10px;" onclick="soumettreRefBancaire()">
          Soumettre pour validation →
        </button>
      </div>

    </div>
  </div>
</div>

<!-- ══ PAGE CONFIRMATION (cachée par défaut) ══ -->
<div id="page-confirmation" style="display:none;">
  <div class="confirmation-card">
    <div class="confirmation-icon"></div>
    <div class="confirmation-title">Paiement confirmé !</div>
    <div class="confirmation-sub">
      Votre paiement de <strong>140 000 FCFA</strong> a été reçu et enregistré.<br>
      Référence : <strong>SCO-ETU0001-INSCR-2026</strong>
    </div>
    <div class="ref-box" style="margin-bottom:24px;">
      <div class="ref-code"> Dossier complet</div>
      <div class="ref-hint">Votre matricule vous sera attribué et envoyé par email sous 24h.</div>
    </div>
    <p style="font-size:13px;color:var(--grey-600);margin-bottom:24px;">
      Un email de confirmation a été envoyé à votre adresse. Vérifiez également vos spams.
    </p>
    <a href="/" class="btn btn-primary">Retour à l'accueil →</a>
  </div>
</div>

<div class="toast-container"></div>
<script src="/js/app.js"></script>
<script>
  function selectOp(btn) {
    document.querySelectorAll('.op-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    document.getElementById('operateur_selectionne').value = btn.dataset.operateur;

    // Afficher le récapitulatif
    const recap = document.getElementById('recap-mm');
    recap.style.display = 'block';
    document.getElementById('recap-op').textContent = btn.querySelector('.op-name').textContent;

    // Afficher le bouton simuler en mode démo
    document.getElementById('btn-simuler').style.display = 'flex';
  }

  document.getElementById('tel_paiement')?.addEventListener('input', function() {
    document.getElementById('recap-tel-mm').textContent = this.value || '—';
  });

  function lancerPaiementMM() {
    const op  = document.getElementById('operateur_selectionne').value;
    const tel = document.getElementById('tel_paiement').value.trim();
    if (!op)  { showToast('Veuillez choisir un opérateur.', 'danger'); return; }
    if (!tel) { showToast('Veuillez entrer votre numéro de téléphone.', 'danger'); return; }
    showToast(`📱 Demande envoyée à ${tel} — Confirmez sur votre téléphone.`, 'default', 4000);
    document.getElementById('btn-simuler').style.display = 'flex';
  }

  function simulerPaiementInscription() {
    const btn = document.getElementById('btn-simuler');
    btn.disabled = true;
    btn.textContent = '⏳ Traitement…';
    setTimeout(() => {
      document.getElementById('page-paiement').style.display = 'none';
      document.getElementById('page-confirmation').style.display = 'block';
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }, 2000);
  }

  function soumettreRefBancaire() {
    const ref = document.getElementById('ref_bancaire').value.trim();
    if (!ref) { showToast('Veuillez entrer votre référence bancaire.', 'danger'); return; }
    showToast(' Référence soumise ! L\'administration vérifiera sous 24h.', 'success', 5000);
  }
</script>
</body>
</html>

