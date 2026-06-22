<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payer ma scolarité — Portail Étudiant</title>
  <link rel="stylesheet" href="/css/app.css"/>
  <style>
    .pay-layout { display: grid; grid-template-columns: 1fr 400px; gap: 24px; }

    /* Suggestions montant */
    .suggestions { display: flex; gap: 10px; margin: 10px 0 16px; flex-wrap: wrap; }
    .suggestion-btn {
      padding: 8px 18px; border: 2px solid var(--grey-300);
      border-radius: var(--radius-full); font-size: 13px; font-weight: 600;
      background: var(--white); cursor: pointer; transition: all .15s; color: var(--dark);
    }
    .suggestion-btn:hover, .suggestion-btn.active {
      border-color: var(--primary); background: var(--primary-light); color: var(--primary);
    }

    /* Récap carte */
    .recap-card { background: var(--grey-100); border-radius: var(--radius); padding: 20px; }
    .recap-line { display: flex; justify-content: space-between; padding: 8px 0; font-size: 13px; border-bottom: 1px solid var(--grey-300); }
    .recap-line:last-child { border: none; font-weight: 700; font-size: 15px; }
    .recap-key { color: var(--grey-600); }

    /* Étapes de confirmation simulée */
    .sim-steps { display: flex; flex-direction: column; gap: 12px; margin: 16px 0; }
    .sim-step  { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: var(--radius-sm); font-size: 13px; }
    .sim-step.pending { background: var(--grey-100); color: var(--grey-600); }
    .sim-step.active  { background: var(--primary-light); color: var(--primary); font-weight: 600; }
    .sim-step.done    { background: var(--accent-light);  color: var(--accent); font-weight: 600; }
    .sim-step-icon { font-size: 20px; width: 28px; text-align: center; }
  </style>
</head>
<body style="background:var(--bg);">
<?php
$etudiant = [
  'nom'           => 'CAPE',
  'prenom'        => 'Kenania',
  'matricule'     => 'MAT-2026-0042',
  'filiere'       => 'Informatique',
  'niveau'        => 'Licence 1',
  'montant_total' => 450000,
  'montant_paye'  => 220000,
];
$montant_restant = $etudiant['montant_total'] - $etudiant['montant_paye'];
$pct = round(($etudiant['montant_paye'] / $etudiant['montant_total']) * 100);
$nbMessagesNonLus = 1;
?>
<div class="app-layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sb-header">
      <div class="sb-brand"><span class="sb-brand-icon">📚</span> Ma Scolarité</div>
    </div>
    <div class="sb-user">
      <div class="sb-avatar">🎓</div>
      <div class="sb-name"><?= $etudiant['prenom'].' '.$etudiant['nom'] ?></div>
      <div class="sb-mat"><?= $etudiant['matricule'] ?></div>
      <span class="sb-role"><?= $etudiant['niveau'] ?></span>
    </div>
    <div class="sb-divider"></div>
    <nav class="sb-nav">
      <a href="/portail/dashboard" class="sb-item">Tableau de bord</a>
      <a href="/portail/paiement"  class="sb-item active">Payer ma scolarité</a>
      <a href="/portail/messages"  class="sb-item">
        Messagerie
        <?php if($nbMessagesNonLus > 0): ?><span class="badge-notif"><?= $nbMessagesNonLus ?></span><?php endif; ?>
      </a>
      <!-- 'Demande de réduction' supprimée -->
      <a href="#" class="sb-item" id="chatbot-trigger-link">Aide / Chatbot</a>
    </nav>
    <div class="sb-divider"></div>
    <form method="POST" action="/portail/deconnexion">
      <button type="submit" class="sb-logout" style="border:none;background:none;width:100%;text-align:left;">⬅ Se déconnecter</button>
    </form>
  </aside>

  <!-- MAIN -->
  <div class="main-wrap">

    <div class="topbar">
      <span class="topbar-title">Payer ma scolarité</span>
      <div class="topbar-right">
        <span class="topbar-date">📅 <?= date('d F Y') ?></span>
        <span class="badge badge-warning">Solde restant : <?= number_format($montant_restant,0,',',' ') ?> FCFA</span>
      </div>
    </div>

    <div class="content">

      <!-- VUE FORMULAIRE -->
      <div id="vue-paiement">

        <div class="pay-layout">

          <!-- COLONNE GAUCHE : formulaire -->
          <div style="display:flex;flex-direction:column;gap:18px;">

            <!-- Opérateur -->
            <div class="card">
              <div class="card-title">1. Choisir votre opérateur</div>
              <div class="card-divider"></div>
              <input type="hidden" id="operateur_choisi" value=""/>
              <div class="operators-grid">
                <div class="op-card" data-operateur="wave" onclick="choisirOp(this)">
                  <div class="op-name" style="color:#0E9CE0;">Wave</div>
                </div>
                <div class="op-card" data-operateur="orange_money" onclick="choisirOp(this)">
                  <div class="op-name" style="color:#FF6600;">Orange Money</div>
                </div>
                <div class="op-card" data-operateur="mtn" onclick="choisirOp(this)">
                  <div class="op-name" style="color:#CC9900;">MTN MoMo</div>
                </div>
                <div class="op-card" data-operateur="moov" onclick="choisirOp(this)">
                  <div class="op-name" style="color:var(--primary);">Moov Money</div>
                </div>
              </div>
            </div>

            <!-- Montant -->
            <div class="card">
              <div class="card-title">2. Saisir le montant</div>
              <div class="card-divider"></div>
              <p style="font-size:13px;color:var(--grey-600);margin-bottom:10px;">Suggestions rapides :</p>
              <div class="suggestions">
                <button type="button" class="suggestion-btn montant-suggestion" data-montant="50000">50 000 FCFA</button>
                <button type="button" class="suggestion-btn montant-suggestion" data-montant="100000">100 000 FCFA</button>
                <button type="button" class="suggestion-btn montant-suggestion" data-montant="<?= $montant_restant ?>">
                  Tout solder — <?= number_format($montant_restant,0,',',' ') ?> FCFA
                </button>
              </div>
              <div class="form-group">
                <label class="form-label">Montant personnalisé (FCFA) <span style="color:var(--danger)">*</span></label>
                <input class="form-input" type="number" id="montant" name="montant"
                       placeholder="Ex : 90000" min="5000" max="<?= $montant_restant ?>"
                       oninput="mettreAJourRecap()"/>
                <div class="form-hint">Minimum : 5 000 FCFA — Maximum : <?= number_format($montant_restant,0,',',' ') ?> FCFA (solde restant)</div>
              </div>
            </div>

            <!-- Téléphone -->
            <div class="card">
              <div class="card-title">3. Numéro de téléphone</div>
              <div class="card-divider"></div>
              <div class="form-group">
                <label class="form-label">Numéro associé au compte Mobile Money <span style="color:var(--danger)">*</span></label>
                <input class="form-input" type="tel" id="telephone" name="telephone"
                       placeholder="+225 07 XX XX XX XX"
                       oninput="mettreAJourRecap()"/>
              </div>
            </div>

            <!-- Paiement physique -->
            <div class="card">
              <div style="font-size:14px;font-weight:700;color:var(--dark);margin-bottom:8px;">🏦 Paiement physique en banque</div>
              <!-- Description de paiement physique supprimée -->
              <!-- ref-box supprimée -->
              <div class="form-group" style="margin-top:12px;">
                <input class="form-input" type="text" id="ref_bancaire" placeholder="N° de reçu bancaire"/>
              </div>
              <button type="button" class="btn btn-ghost btn-full" style="margin-top:10px;"
                      onclick="soumettreRefBancaire()">
                Soumettre pour validation →
              </button>
            </div>

          </div>

          <!-- COLONNE DROITE : récapitulatif -->
          <div style="display:flex;flex-direction:column;gap:16px;">

            <div class="card" style="position:sticky;top:20px;">
              <div class="card-title">Récapitulatif</div>
              <div class="card-divider"></div>

              <!-- Progression -->
              <div style="margin-bottom:16px;">
                <div style="display:flex;justify-content:space-between;font-size:12px;color:var(--grey-600);margin-bottom:6px;">
                  <span>Scolarité payée</span>
                  <span id="recap-pct"><?= $pct ?>%</span>
                </div>
                <div class="progress-track">
                  <div class="progress-fill" id="recap-progress-fill" data-width="<?= $pct ?>%"></div>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--grey-600);margin-top:4px;">
                  <span><?= number_format($etudiant['montant_paye'],0,',',' ') ?> FCFA payés</span>
                  <span><?= number_format($montant_restant,0,',',' ') ?> FCFA restants</span>
                </div>
              </div>

              <div class="recap-card">
                <div class="recap-line">
                  <span class="recap-key">Opérateur</span>
                  <span id="recap-op">—</span>
                </div>
                <div class="recap-line">
                  <span class="recap-key">Numéro</span>
                  <span id="recap-tel">—</span>
                </div>
                <!-- Ligne 'Référence' supprimée par demande utilisateur -->
                <div class="recap-line">
                  <span class="recap-key">Montant</span>
                  <span id="recap-montant" style="color:var(--primary);">—</span>
                </div>
              </div>

              <button type="button" class="btn btn-primary btn-full" style="margin-top:16px;" onclick="confirmerPaiement()">
                💳 Confirmer le paiement
              </button>

              <div style="margin-top:12px;padding:10px;background:var(--accent-light);border-radius:var(--radius-sm);font-size:11px;color:var(--accent);text-align:center;">
                🔒 Paiement sécurisé · Confirmation immédiate par email
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- VUE SIMULATION (cachée par défaut) -->
      <div id="vue-simulation" style="display:none;max-width:560px;margin:0 auto;">
        <div class="card" style="text-align:center;padding:40px 32px;">
          <div style="font-size:48px;margin-bottom:16px;">📱</div>
          <h2 style="font-size:22px;font-weight:700;margin-bottom:8px;">Traitement en cours…</h2>
          <p style="font-size:14px;color:var(--grey-600);margin-bottom:28px;">
            Une demande de confirmation a été envoyée à votre numéro.<br>
            Validez sur votre téléphone pour confirmer le paiement.
          </p>
          <div class="sim-steps">
            <div class="sim-step done"    id="sim-1"><span class="sim-step-icon">✅</span> Paiement initié</div>
            <div class="sim-step active"  id="sim-2"><span class="sim-step-icon">⏳</span> En attente de confirmation OTP</div>
            <div class="sim-step pending" id="sim-3"><span class="sim-step-icon">📧</span> Mise à jour du solde</div>
            <div class="sim-step pending" id="sim-4"><span class="sim-step-icon">✉️</span> Envoi email de confirmation</div>
          </div>
          <button type="button" class="btn btn-accent btn-full" id="btn-simuler-confirm" onclick="simulerConfirmation()">
            🎬 [DÉMO] Simuler la confirmation OTP
          </button>
        </div>
      </div>

      <!-- VUE SUCCÈS (cachée par défaut) -->
      <div id="vue-succes" style="display:none;max-width:560px;margin:0 auto;">
        <div class="card" style="text-align:center;padding:48px 32px;">
          <div style="font-size:64px;margin-bottom:16px;animation:toastIn .5s ease;">✅</div>
          <h2 style="font-size:24px;font-weight:700;margin-bottom:8px;color:var(--accent);">Paiement confirmé !</h2>
          <p style="font-size:15px;color:var(--grey-600);margin-bottom:24px;">
            Votre versement a été enregistré avec succès.
          </p>

          <div class="recap-card" style="text-align:left;margin-bottom:24px;">
            <div class="recap-line">
              <span class="recap-key">Montant versé</span>
              <span id="succes-montant" style="color:var(--accent);font-weight:700;">—</span>
            </div>
            <div class="recap-line">
              <span class="recap-key">Opérateur</span>
              <span id="succes-op">—</span>
            </div>
            <div class="recap-line">
              <span class="recap-key">Référence</span>
              <span id="succes-ref" style="font-size:12px;color:var(--primary);">—</span>
            </div>
            <div class="recap-line">
              <span class="recap-key">Nouveau solde restant</span>
              <span id="succes-solde" style="color:var(--warning);font-weight:700;">—</span>
            </div>
          </div>

          <div class="alert alert-success" style="margin-bottom:20px;">
            <span>✉️</span>
            <span>Un email de confirmation a été envoyé à votre adresse. Vérifiez aussi votre messagerie interne.</span>
          </div>

          <a href="/portail/dashboard" class="btn btn-primary btn-full">← Retour au tableau de bord</a>
        </div>
      </div>

    </div><!-- /content -->
  </div><!-- /main-wrap -->
</div><!-- /app-layout -->

<!-- CHATBOT -->
<button class="fab" id="chatbot-fab">🤖</button>
<div class="chatbot-modal" id="chatbot-modal">
  <div class="cb-header"><h4>🤖 Assistant</h4><button id="chatbot-close">✕</button></div>
  <div class="cb-messages" id="chatbot-messages"></div>
  <div class="cb-input-row">
    <input type="text" id="chatbot-input" placeholder="Posez votre question…"/>
    <button id="chatbot-send">➤</button>
  </div>
</div>

<div class="toast-container"></div>
<script src="/js/app.js"></script>
<script>
const MONTANT_RESTANT = <?= $montant_restant ?>;

function choisirOp(card) {
  document.querySelectorAll('.op-card').forEach(c => c.classList.remove('selected'));
  card.classList.add('selected');
  document.getElementById('operateur_choisi').value = card.dataset.operateur;
  document.getElementById('recap-op').textContent = card.querySelector('.op-name').textContent;
}

function mettreAJourRecap() {
  const m   = parseInt(document.getElementById('montant').value) || 0;
  const tel = document.getElementById('telephone').value || '—';
  document.getElementById('recap-montant').textContent = m > 0 ? m.toLocaleString('fr-FR') + ' FCFA' : '—';
  document.getElementById('recap-tel').textContent = tel;
}

// Suggestions montant
document.querySelectorAll('.montant-suggestion').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.montant-suggestion').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    document.getElementById('montant').value = this.dataset.montant;
    mettreAJourRecap();
  });
});

function confirmerPaiement() {
  const op  = document.getElementById('operateur_choisi').value;
  const m   = parseInt(document.getElementById('montant').value);
  const tel = document.getElementById('telephone').value.trim();
  if (!op)           { showToast('Choisissez un opérateur.', 'danger'); return; }
  if (!m || m < 5000){ showToast('Entrez un montant valide (min 5 000 FCFA).', 'danger'); return; }
  if (m > MONTANT_RESTANT) { showToast('Montant supérieur au solde restant.', 'danger'); return; }
  if (!tel)          { showToast('Entrez votre numéro de téléphone.', 'danger'); return; }

  document.getElementById('vue-paiement').style.display = 'none';
  document.getElementById('vue-simulation').style.display = 'block';
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function simulerConfirmation() {
  const btn = document.getElementById('btn-simuler-confirm');
  btn.disabled = true;
  btn.textContent = '⏳ Confirmation en cours…';

  const m  = parseInt(document.getElementById('montant').value);
  const op = document.getElementById('recap-op').textContent;

  // Animer les étapes
  setTimeout(() => {
    document.getElementById('sim-2').className = 'sim-step done';
    document.getElementById('sim-2').querySelector('.sim-step-icon').textContent = '✅';
    document.getElementById('sim-3').className = 'sim-step active';
  }, 1000);
  setTimeout(() => {
    document.getElementById('sim-3').className = 'sim-step done';
    document.getElementById('sim-3').querySelector('.sim-step-icon').textContent = '✅';
    document.getElementById('sim-4').className = 'sim-step active';
  }, 2200);
  setTimeout(() => {
    document.getElementById('sim-4').className = 'sim-step done';
    document.getElementById('sim-4').querySelector('.sim-step-icon').textContent = '✅';
  }, 3200);

  setTimeout(() => {
    // Afficher le succès
    document.getElementById('vue-simulation').style.display = 'none';
    document.getElementById('vue-succes').style.display = 'block';
    const nouveauSolde = MONTANT_RESTANT - m;
    document.getElementById('succes-montant').textContent = m.toLocaleString('fr-FR') + ' FCFA';
    document.getElementById('succes-op').textContent = op;
    document.getElementById('succes-solde').textContent =
      nouveauSolde <= 0 ? '🎉 Scolarité soldée !' : nouveauSolde.toLocaleString('fr-FR') + ' FCFA';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }, 4000);
}

function soumettreRefBancaire() {
  const ref = document.getElementById('ref_bancaire').value.trim();
  if (!ref) { showToast('Entrez votre référence bancaire.', 'danger'); return; }
  showToast('✅ Référence bancaire soumise ! Validation sous 24h.', 'success', 5000);
}

document.getElementById('chatbot-trigger-link')?.addEventListener('click', e => {
  e.preventDefault();
  document.getElementById('chatbot-fab').click();
});
</script>
</body>
</html>
