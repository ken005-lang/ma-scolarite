<?php setlocale(LC_TIME, 'fr_FR.UTF-8'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tableau de bord — Portail Étudiant</title>
  <link rel="stylesheet" href="/css/app.css"/>
  <!-- Favicon using 📚 emoji as SVG data URI -->
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='0.9em' font-size='90'>📚</text></svg>">
  <style>
    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .pay-row { display:flex; align-items:center; justify-content:space-between; padding:12px 14px; border-radius:8px; margin-bottom:6px; font-size:13px; }
    .pay-row:nth-child(odd)  { background: var(--grey-100); }
    .pay-row:nth-child(even) { background: var(--white); border: 1px solid var(--grey-100); }
    .pay-left  { display:flex; flex-direction:column; gap:3px; }
    .pay-amt   { font-weight:700; color:var(--dark); font-size:14px; }
    .pay-date  { font-size:11px; color:var(--grey-600); }
    .file-uploader { width:100%; border:1px dashed var(--grey-200); background:var(--white); padding:18px; border-radius:8px; display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer; }
    .file-uploader .fu-icon { font-size:28px; margin-bottom:8px; }
    .file-uploader .fu-text { font-size:13px; color:var(--grey-700); }
  </style>
</head>
<body style="background:var(--bg);">
<?php
// ── Données de simulation ────────────────────
$etudiant = [
  'nom'       => 'CAPÉ',
  'prenom'    => 'Kenania',
  'matricule' => 'MAT-2026-0042',
  'filiere'   => 'Informatique',
  'niveau'    => 'Licence 1',
  'montant_total'  => 450000,
  'montant_paye'   => 220000,
  'date_limite'    => '31 décembre 2026',
];
$montant_restant = $etudiant['montant_total'] - $etudiant['montant_paye'];
$pct = round(($etudiant['montant_paye'] / $etudiant['montant_total']) * 100);
$nbMessagesNonLus = 1;
$etudiant['montant_paye'] = 230000;
$paiements = [
  ['date'=>'12 avr. 2026','montant'=>110000,'operateur'=>'Wave','statut'=>'confirme'],
  // Entrée '02 mars 2026' (Orange Money) supprimée 
];
$messages = [
  ['from'=>'Administration ITES II Plateaux','text'=>'Rappel : prochaine tranche de 90 000 FCFA due le 30 juin 2026.','time'=>'1 juin','unread'=>true],
  ['from'=>'Administration ITES II Plateaux','text'=>'Votre versement du 12 avril a bien été reçu. Merci !','time'=>'12 avr.','unread'=>false],
];
?>

<div class="app-layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sb-header">
      <div class="sb-brand"><span class="sb-brand-icon">📚</span> Ma Scolarité</div>
    </div>
    <div class="sb-user">
      <div class="sb-avatar">🎓</div>
      <div class="sb-name"><?= $etudiant['nom'].' '.$etudiant['prenom'] ?></div>
      <div class="sb-mat"><?= $etudiant['matricule'] ?></div>
      <span class="sb-role"><?= $etudiant['niveau'] ?></span>
    </div>
    <div class="sb-divider"></div>
    <nav class="sb-nav">
      <a href="/portail/dashboard" class="sb-item active">Tableau de bord</a>
      <a href="/portail/paiement"  class="sb-item">Payer ma scolarité</a>
      <a href="/portail/messages"  class="sb-item">
        Messagerie
        <?php if($nbMessagesNonLus > 0): ?><span class="badge-notif"><?= $nbMessagesNonLus ?></span><?php endif; ?>
      </a>
      <!-- 'Demande de réduction' supprimée -->
      <a href="#" class="sb-item" id="chatbot-trigger-link">Aide / Chatbot</a>
    </nav>
    <div class="sb-divider"></div>
    <form method="POST" action="/portail/deconnexion">
      <button type="submit" class="sb-logout" style="border:none;background:none;width:100%;text-align:left;">Se déconnecter</button>
    </form>
  </aside>

  <!-- MAIN -->
  <div class="main-wrap">

    <!-- Topbar -->
    <div class="topbar">
      <span class="topbar-title">Tableau de bord</span>
      <div class="topbar-right">
        <span class="topbar-date">📅 <?= (new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'dd MMMM yyyy'))->format(new DateTime()) ?></span>
        <span class="badge badge-primary"><?= $etudiant['filiere'] ?> — <?= $etudiant['niveau'] ?></span>
        <span class="badge badge-success">Frais d'inscription validés</span>
      </div>
    </div>

    <div class="content">

      <!-- KPI CARDS -->
      <div class="kpi-grid">
        <div class="kpi-card">
          <div class="kpi-icon" style="background:var(--warning-light);">⏳</div>
          <div class="kpi-label">Solde restant</div>
          <div class="kpi-value" style="color:var(--warning);"><?= number_format($montant_restant,0,',',' ') ?> FCFA</div>
          <div class="kpi-sub">sur <?= number_format($etudiant['montant_total'],0,',',' ') ?> FCFA total</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-icon" style="background:var(--primary-light);">✅</div>
          <div class="kpi-label">Versements effectués</div>
          <div class="kpi-value" style="color:var(--primary);">2 / 5</div>
          <div class="kpi-sub">Prochain : 30 juin 2026</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-icon" style="background:var(--danger-light);">📅</div>
          <div class="kpi-label">Date limite de solde</div>
          <div class="kpi-value" style="color:var(--danger);font-size:16px;"><?= $etudiant['date_limite'] ?></div>
          <div class="kpi-sub">203 jours restants</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-icon" style="background:var(--accent-light);">🎓</div>
          <div class="kpi-label">Statut SCOLAIRE</div>
          <div class="kpi-value" style="color:var(--accent);">Affecté</div>
          <div class="kpi-sub"><?= $etudiant['filiere'] ?> — <?= $etudiant['niveau'] ?></div>
        </div>
      </div>

      <!-- BARRE DE PROGRESSION -->
      <div class="card" style="margin-bottom:18px;">
        <div class="card-title">Progression du paiement</div>
        <div class="card-divider"></div>
        <div class="progress-wrap">
          <div class="progress-meta">
            <span class="progress-label"><?= number_format($etudiant['montant_paye'],0,',',' ') ?> FCFA payés sur <?= number_format($etudiant['montant_total'],0,',',' ') ?> FCFA</span>
            <span class="progress-pct"><?= $pct ?>%</span>
          </div>
          <div class="progress-track">
            <div class="progress-fill" data-width="<?= $pct ?>%"></div>
          </div>
        </div>
      </div>

      <!-- CTA PAIEMENT -->
      <div class="cta-band">
        <div>
          <h3>💳 Payer ma scolarité maintenant</h3>
          <div class="op-pills" style="margin-top:8px;">
            <span class="op-pill">Wave</span>
            <span class="op-pill">Orange Money</span>
            <span class="op-pill">MTN MoMo</span>
            <span class="op-pill">Moov Money</span>
            <!-- Nouveau pill pour notifier un paiement physique (couleur sidebar) -->
            <span class="op-pill" style="background:var(--primary-dark);color:#ffffff;border-color:var(--primary-dark);">Notifier un paiement physique</span>
          </div>
        </div>
        <a href="/portail/paiement" class="btn btn-white">Payer maintenant →</a>
      </div>

      <!-- GRILLE : Historique + Messagerie -->
      <div class="two-col">

        <!-- Historique -->
        <div class="card">
          <div class="card-title">Historique des versements</div>
          <div class="card-divider"></div>
          <?php foreach($paiements as $p): 
            if($p['operateur'] === 'Physique') continue; // supprime l'entrée 'Physique' demandée
          ?>
          <div class="pay-row">
            <div class="pay-left">
              <span class="pay-amt"><?= $p['montant'] > 0 ? number_format($p['montant'],0,',',' ').' FCFA' : '— FCFA' ?></span>
              <span class="pay-date"><?= $p['date'] ?></span>
            </div>
            <span class="badge badge-<?= $p['operateur']==='Physique'?'grey':'primary' ?>"><?= $p['operateur'] ?></span>
            <span class="badge badge-<?= $p['statut']==='confirme'?'accent':'warning' ?>">
              <?= $p['statut']==='confirme' ? ' Confirmé' : '⏳ En attente' ?>
            </span>
          </div>
          <?php endforeach; ?>
          
        </div>

        <!-- Messagerie -->
        <div class="card">
          <div class="card-title">Messagerie</div>
          <div class="card-divider"></div>
          <?php foreach($messages as $m): ?>
          <div class="msg-row <?= $m['unread']?'unread':'' ?>">
            <div class="msg-avatar">🏫</div>
            <div class="msg-body">
              <div class="msg-from"><?= $m['from'] ?></div>
              <div class="msg-text"><?= $m['text'] ?></div>
            </div>
            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
              <span class="msg-time"><?= $m['time'] ?></span>
              <?php if($m['unread']): ?><div class="msg-dot"></div><?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
          <div class="card-divider"></div>
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--grey-600);margin-bottom:10px;">Envoyer un message</div>
          <textarea class="form-input form-textarea" rows="3" placeholder="Écrivez votre message à l'administration…"></textarea>
          <div style="display:flex;gap:10px;margin-top:10px;">
              <button class="btn btn-primary btn-sm" onclick="showToast('Message envoyé à l\'administration ✅','success')">✉️ Envoyer</button>
            </div>

            <!-- Champ d'upload PDF pour demande de réduction -->
            <div style="margin-top:8px;display:flex;flex-direction:column;gap:8px;align-items:flex-start;">
              <div class="file-uploader" id="reduction-uploader" tabindex="0" role="button" aria-label="Téléverser un justificatif PDF">
                <div class="fu-icon">📤</div>
                <div class="fu-text">Cliquez ou déposez un fichier PDF ici</div>
                <input type="file" id="reduction-file" name="reduction_file" accept="application/pdf" style="display:none" />
              </div>
              <div style="font-size:12px;color:var(--grey-600);">Téléversez ici votre document de demande de réduction (en format PDF s'il vous plaît).</div>
              <div>
                <a href="/portail/reduction" class="btn btn-ghost btn-sm">📄 Demande de réduction</a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div><!-- /content -->
  </div><!-- /main-wrap -->
</div><!-- /app-layout -->

<!-- CHATBOT -->
<button class="fab" id="chatbot-fab" title="Aide chatbot">🤖</button>
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
  const uploader = document.getElementById('reduction-uploader');
  const fileInput = document.getElementById('reduction-file');
  uploader?.addEventListener('click', () => fileInput?.click());
  uploader?.addEventListener('keydown', (e) => { if(e.key==='Enter' || e.key===' ') fileInput?.click(); });
  fileInput?.addEventListener('change', (ev) => {
    const f = ev.target.files && ev.target.files[0];
    const txt = document.querySelector('#reduction-uploader .fu-text');
    if(f) txt.textContent = f.name;
  });
</script>
<script>
  document.getElementById('chatbot-trigger-link')?.addEventListener('click', e => {
    e.preventDefault();
    document.getElementById('chatbot-fab').click();
  });
</script>
</body>
</html>

