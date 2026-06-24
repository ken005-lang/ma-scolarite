<?php setlocale(LC_TIME, 'fr_FR.UTF-8'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Administration — Ma Scolarité</title>
  <link rel="stylesheet" href="/css/app.css"/>
  <style>
    .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px; }
    .three-col { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 18px; }

    /* Vue messagerie */
    .msg-layout { display: grid; grid-template-columns: 340px 1fr; gap: 18px; }
    .candidature-row {
      display: flex; align-items: center; gap: 12px;
      padding: 12px 14px; border-radius: 9px; margin-bottom: 6px;
      cursor: pointer; border: 1px solid transparent; transition: all .15s;
    }
    .candidature-row:hover  { background: var(--grey-100); border-color: var(--grey-300); }
    .candidature-row.active { background: var(--primary-light); border-color: var(--primary); }
    .cand-avatar {
      width: 40px; height: 40px; border-radius: 50%;
      background: var(--primary-light); display: flex;
      align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;
    }
    .cand-info { flex: 1; }
    .cand-name { font-size: 13px; font-weight: 600; color: var(--dark); }
    .cand-sub  { font-size: 11px; color: var(--grey-600); margin-top: 2px; }

    /* Boutons action admin */
    .action-btns { display: flex; gap: 10px; margin-top: 18px; flex-wrap: wrap; }

    /* Paiements en attente */
    .paiement-row {
      display: flex; align-items: center; justify-content: space-between;
      padding: 12px 0; border-bottom: 1px solid var(--grey-100); font-size: 13px;
    }
    .paiement-row:last-child { border: none; }
  </style>
</head>
<body style="background:var(--bg);">
<?php
// ── Données simulation ─────────────────────────
$admin = ['nom' => 'ITES II Plateaux', 'email' => 'admin@ites.ci', 'role' => 'Super Admin'];

$nbCandidaturesAttente = 1;
$nbPaiementsAttente    = 1;
$nbMessagesNonLus      = 99;

$candidatures = [
  ['id'=>1,'nom'=>'KOUAMÉ Aya Marie',  'filiere'=>'Informatique','date'=>'10 juin 2026','statut'=>'en_attente','email'=>'kouame.aya@email.ci','tel'=>'+225 07 58 23 41 00','naissance'=>'14 mars 2004','lieu_naiss'=>'Abidjan','residence'=>'Cocody','formation'=>'Baccalauréat C','diplome'=>'Bac C','etat'=>'Affectée État','doc'=>'CNI.pdf','lettre'=>'Lettre_motivation.pdf','resp'=>'KOUAMÉ Jean (Père) — +225 05 44 12 88 00'],
];
$paiementsPhysiques = [
  ['id'=>1,'nom'=>'KOUASSI Ama','mat'=>'MAT-2026-0031','ref'=>'NSIA-2026-00312','montant'=>90000],
];

$barData = [
  ['mois'=>'Jan','val'=>740,'h'=>75],
  ['mois'=>'Fév','val'=>890,'h'=>90],
  ['mois'=>'Mar','val'=>1100,'h'=>108],
  ['mois'=>'Avr','val'=>980,'h'=>96],
  ['mois'=>'Mai','val'=>1050,'h'=>103],
  ['mois'=>'Juin','val'=>1240,'h'=>124,'accent'=>true],
];

$vueCourante = $_GET['vue'] ?? 'dashboard'; // dashboard | messagerie
?>

<div class="app-layout">

  <!-- SIDEBAR ADMIN -->
  <aside class="sidebar">
    <div class="sb-header">
      <div class="sb-brand"><span class="sb-brand-icon">📚</span> Ma Scolarité</div>
    </div>
    <div class="sb-user">
      <div class="sb-avatar">👤</div>
      <div class="sb-name"><?= htmlspecialchars($admin['nom']) ?></div>
      <div class="sb-mat"><?= htmlspecialchars($admin['email']) ?></div>
      <span class="sb-role"><?= htmlspecialchars($admin['role']) ?></span>
    </div>
    <div class="sb-divider"></div>
    <nav class="sb-nav">
      <a href="/admin/dashboard" class="sb-item <?= $vueCourante==='dashboard'?'active':'' ?>">
        Tableau de bord
      </a>
      <a href="#" class="sb-item" onclick="showToast('Section Étudiants')">
        Étudiants
      </a>
      <a href="#" class="sb-item" onclick="showToast('Section Documents')">
        Documents et décisions administratives
      </a>
      <a href="/admin/dashboard?vue=messagerie" class="sb-item">
        Messagerie
        <span class="badge-notif"><?= $nbMessagesNonLus ?></span>
      </a>
    </nav>
    <div class="sb-divider"></div>
    <form method="POST" action="/admin/deconnexion">
      <button type="submit" class="sb-logout" style="border:none;background:none;width:100%;text-align:left;">Se déconnecter</button>
    </form>
  </aside>

  <!-- MAIN -->
  <div class="main-wrap">

    <div class="topbar">
      <span class="topbar-title">
        <?= $vueCourante==='messagerie' ? 'Messagerie — Administration' : 'Tableau de bord — Administration' ?>
      </span>
      <div class="topbar-right">
        <span class="topbar-date">📅 <?= (new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'dd MMMM yyyy'))->format(new DateTime()) ?></span>
        <span class="badge badge-primary">Super Admin</span>
      </div>
    </div>

    <div class="content">

    <?php if ($vueCourante === 'dashboard'): ?>
    <!-- ════════════════════════════════════════
         VUE DASHBOARD
    ════════════════════════════════════════ -->

      <!-- KPI -->
      <div class="kpi-grid">
        <div class="kpi-card">
          <div class="kpi-icon" style="background:var(--primary-light);">👥</div>
          <div class="kpi-label">Total étudiants</div>
          <div class="kpi-value" style="color:var(--primary);">47</div>
          <div class="kpi-sub">dont 5 sans matricule</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-icon" style="background:var(--accent-light);">📈</div>
          <div class="kpi-label">Taux de recouvrement</div>
          <div class="kpi-value" style="color:var(--accent);">68%</div>
          <div class="kpi-sub">32% restant à recouvrer</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-icon" style="background:#F0EBFF;">💰</div>
          <div class="kpi-label">Paiements ce mois</div>
          <div class="kpi-value" style="color:#7C3AED;font-size:17px;">1 240 000 FCFA</div>
          <div class="kpi-sub">+18% vs mois précédent</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-icon" style="background:var(--warning-light);">📋</div>
          <div class="kpi-label">Dossiers en attente</div>
          <div class="kpi-value" style="color:var(--warning);"><?= $nbCandidaturesAttente ?></div>
          <div class="kpi-sub">candidatures à traiter</div>
        </div>
      </div>

      <!-- ACTIONS RAPIDES (simplifiées) -->
      <div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
        <button class="btn btn-primary btn-sm" onclick="showToast('Sélectionner un étudiant pour attribuer son matricule')">🎓 Attribuer un matricule</button>
      </div>

      <div class="two-col" style="grid-template-columns: 1fr 380px;">

        <!-- Graphique revenus -->
        <div class="card">
          <div class="card-title">Revenus mensuels 2026</div>
          <div class="card-divider"></div>
          <div class="bar-chart">
            <?php foreach($barData as $b): ?>
            <div class="bar-col">
              <div class="bar-val"><?= $b['val'] ?>k</div>
              <div class="bar <?= !empty($b['accent']) ? 'accent-bar' : '' ?>"
                   style="height:<?= $b['h'] ?>px"
                   onclick="showToast('<?= $b['mois'] ?> 2026 : <?= number_format($b['val']*1000, 0, ',', ' ') ?> FCFA')">
              </div>
              <div class="bar-lbl"><?= $b['mois'] ?></div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Paiements physiques à valider (restauré) -->
        <div class="card">
          <div class="card-title">Paiements physiques à valider</div>
          <div class="card-divider"></div>
          <?php foreach($paiementsPhysiques as $p): ?>
          <div class="paiement-row">
            <div>
              <div style="font-weight:600;font-size:13px;color:var(--dark);"><?= $p['nom'] ?></div>
              <div style="font-size:11px;color:var(--grey-600);">
                <?= $p['mat'] ?> · <span class="badge badge-grey"><?= $p['ref'] ?></span>
              </div>
            </div>
            <div>
              <a href="/admin/paiements/<?= $p['id'] ?>" class="btn btn-ghost btn-sm">Voir</a>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

      </div>

      <!-- Table candidatures -->
      <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;">
          <div class="card-title">Dernières candidatures</div>
          <a href="/admin/dashboard?vue=messagerie" class="btn btn-ghost btn-sm">Voir toutes →</a>
        </div>
        <div class="card-divider"></div>
        <div class="table-wrap">
          <table class="table-base">
            <thead>
              <tr>
                <th>Candidat</th>
                <th>Filière</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($candidatures as $c): ?>
              <tr>
                <td>
                  <div class="td-name"><?= htmlspecialchars($c['nom']) ?></div>
                  <div class="td-sub"><?= htmlspecialchars($c['email']) ?></div>
                </td>
                <td>
                  <span class="badge <?= in_array($c['filiere'],['Informatique','Mécatronique'])?'badge-primary':'badge-accent' ?>">
                    <?= $c['filiere'] ?>
                  </span>
                </td>
                <td style="font-size:12px;color:var(--grey-600);"><?= $c['date'] ?></td>
                <td>
                  <?php
                  $badgeClass = match($c['statut']) {
                    'en_attente' => 'badge-warning',
                    'acceptee'   => 'badge-accent',
                    'refusee'    => 'badge-danger',
                    default      => 'badge-grey'
                  };
                  $badgeLabel = match($c['statut']) {
                    'en_attente' => '⏳ En attente',
                    'acceptee'   => ' Acceptée',
                    'refusee'    => ' Refusée',
                    default      => '—'
                  };
                  ?>
                  <span class="badge <?= $badgeClass ?>"><?= $badgeLabel ?></span>
                </td>
                <td>
                  <?php if($c['statut']==='en_attente'): ?>
                  <a href="/admin/dashboard?vue=messagerie&id=<?= $c['id'] ?>" class="btn btn-primary btn-sm">Examiner</a>
                  <?php else: ?>
                  <a href="/admin/dashboard?vue=messagerie&id=<?= $c['id'] ?>" class="btn btn-ghost btn-sm">Voir</a>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    <?php else: ?>
    <!-- ════════════════════════════════════════
         VUE MESSAGERIE / CANDIDATURES
    ════════════════════════════════════════ -->

      <!-- Onglets -->
      <div class="tabs">
        <div class="tab active" data-target="panel-candidatures">
          📋 Candidatures <span class="tab-badge"><?= $nbCandidaturesAttente ?></span>
        </div>
        <div class="tab" data-target="panel-messages">
          💬 Messages étudiants <span class="tab-badge">3</span>
        </div>
        <div class="tab" data-target="panel-physiques">
          🏦 Paiements physiques <span class="tab-badge"><?= $nbPaiementsAttente ?></span>
        </div>
        <div class="tab" data-target="panel-digital">
          💳 Paiements digitaux <span class="tab-badge">94</span>
        </div>
      </div>

      <!-- PANEL CANDIDATURES -->
      <div id="panel-candidatures" class="tab-panel">
        <?php $selectedId = (int)($_GET['id'] ?? $candidatures[0]['id']); ?>
        <div class="msg-layout">

          <!-- Liste -->
          <div class="card" style="padding:16px;">
            <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--grey-600);margin-bottom:12px;">
              Dossiers reçus
            </div>
            <?php foreach($candidatures as $c): ?>
            <div class="candidature-row <?= $c['id']===$selectedId?'active':'' ?>"
                 onclick="window.location='/admin/dashboard?vue=messagerie&id=<?= $c['id'] ?>'">
              <div class="cand-avatar">
                <?= strpos($c['nom'],'YAO')!==false||strpos($c['nom'],'AMÉ')!==false||strpos($c['nom'],'AÏTÉ')!==false ? '👩' : (strpos($c['nom'],'IBAT')!==false?'👩':'👨') ?>
              </div>
              <div class="cand-info">
                <div class="cand-name"><?= htmlspecialchars($c['nom']) ?></div>
                <div class="cand-sub"><?= $c['filiere'] ?> · <?= $c['date'] ?></div>
              </div>
              <?php
              $bc2 = match($c['statut']) { 'en_attente'=>'badge-warning','acceptee'=>'badge-accent','refusee'=>'badge-danger',default=>'badge-grey'};
              $bl2 = match($c['statut']) { 'en_attente'=>'⏳','acceptee'=>'','refusee'=>'',default=>'—'};
              ?>
              <span class="badge <?= $bc2 ?>"><?= $bl2 ?></span>
            </div>
            <?php endforeach; ?>
          </div>

          <!-- Détail -->
          <?php
          $selected = null;
          foreach($candidatures as $c) { if($c['id']===$selectedId){ $selected=$c; break; } }
          if(!$selected) $selected=$candidatures[0];
          $bc3 = match($selected['statut']) { 'en_attente'=>'badge-warning','acceptee'=>'badge-accent','refusee'=>'badge-danger',default=>'badge-grey'};
          $bl3 = match($selected['statut']) { 'en_attente'=>'⏳ En attente','acceptee'=>' Acceptée','refusee'=>' Refusée',default=>'—'};
          ?>
          <div class="detail-panel">

            <!-- En-tête candidat -->
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;">
              <div style="width:60px;height:60px;border-radius:50%;background:var(--primary-light);display:flex;align-items:center;justify-content:center;font-size:28px;flex-shrink:0;">👩</div>
              <div>
                <div style="font-size:18px;font-weight:700;color:var(--dark);"><?= htmlspecialchars($selected['nom']) ?></div>
                <div style="font-size:12px;color:var(--grey-600);">Candidature reçue le <?= $selected['date'] ?></div>
                <span class="badge <?= $bc3 ?>" style="margin-top:6px;display:inline-flex;"><?= $bl3 ?></span>
              </div>
            </div>

            <!-- Infos -->
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--grey-600);margin-bottom:10px;">
              Informations personnelles
            </div>
            <div class="detail-row"><span class="detail-key">Nom complet</span><span class="detail-val"><?= htmlspecialchars($selected['nom']) ?></span></div>
            <div class="detail-row"><span class="detail-key">Date de naissance</span><span class="detail-val"><?= $selected['naissance'] ?></span></div>
            <div class="detail-row"><span class="detail-key">Lieu de naissance</span><span class="detail-val"><?= $selected['lieu_naiss'] ?></span></div>
            <div class="detail-row"><span class="detail-key">Lieu de résidence</span><span class="detail-val"><?= $selected['residence'] ?></span></div>
            <div class="detail-row"><span class="detail-key">Téléphone</span><span class="detail-val"><?= $selected['tel'] ?></span></div>
            <div class="detail-row"><span class="detail-key">Email</span><span class="detail-val"><?= $selected['email'] ?></span></div>
            <div class="detail-row"><span class="detail-key">Statut</span><span class="detail-val"><span class="badge badge-grey"><?= $selected['etat'] ?></span></span></div>
            <div class="detail-row"><span class="detail-key">Filière choisie</span>
              <span class="detail-val">
                <span class="badge <?= in_array($selected['filiere'],['Informatique','Mécatronique'])?'badge-primary':'badge-accent' ?>">
                  <?= $selected['filiere'] ?>
                </span>
              </span>
            </div>
            <div class="detail-row"><span class="detail-key">Dernier diplôme</span><span class="detail-val"><?= $selected['diplome'] ?></span></div>
            <div class="detail-row"><span class="detail-key">Responsable financier</span><span class="detail-val" style="font-size:12px;"><?= htmlspecialchars($selected['resp']) ?></span></div>

            <!-- Documents joints -->
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--grey-600);margin:14px 0 10px;">
              Documents joints
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;">
              <span class="badge badge-primary" style="cursor:pointer;" onclick="showToast('Ouverture : <?= $selected['doc'] ?>')">
                📄 <?= $selected['doc'] ?>
              </span>
              <?php if($selected['lettre']): ?>
              <span class="badge badge-grey" style="cursor:pointer;" onclick="showToast('Ouverture : <?= $selected['lettre'] ?>')">
                📝 <?= $selected['lettre'] ?>
              </span>
              <?php else: ?>
              <span class="badge badge-grey">📝 Pas de lettre de motivation</span>
              <?php endif; ?>
            </div>

            <!-- Message personnalisé -->
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--grey-600);margin-bottom:8px;">
              Message à envoyer à l'étudiant
            </div>
            <textarea class="form-input form-textarea" id="message_admin" rows="3"
                      placeholder="Ex : Votre candidature a été examinée par notre équipe…"></textarea>

            <!-- Boutons action -->
            <?php if($selected['statut']==='en_attente'): ?>
            <div class="action-btns">
              <button class="btn btn-accent" onclick="actionCandidature('accepter', <?= $selected['id'] ?>, '<?= addslashes($selected['nom']) ?>')">
                 Accepter la candidature
              </button>
              <button class="btn btn-danger" onclick="actionCandidature('refuser', <?= $selected['id'] ?>, '<?= addslashes($selected['nom']) ?>')">
                 Refuser
              </button>
              <button class="btn btn-ghost" onclick="actionCandidature('attente', <?= $selected['id'] ?>, '<?= addslashes($selected['nom']) ?>')">
                ⏸ Mettre en attente
              </button>
            </div>
            <?php else: ?>
            <div class="alert alert-<?= $selected['statut']==='acceptee'?'success':'danger' ?>" style="margin-top:16px;">
              <span><?= $selected['statut']==='acceptee'?'':'' ?></span>
              <span>Cette candidature a déjà été <strong><?= $selected['statut']==='acceptee'?'acceptée':'refusée' ?></strong>.</span>
            </div>
            <?php endif; ?>

            <div style="margin-top:10px;font-size:11px;color:var(--grey-600);">
              ✉️ Un email de notification est envoyé automatiquement à l'étudiant lors de chaque décision.
            </div>

          </div>
        </div>
      </div>

      <!-- PANEL MESSAGES ÉTUDIANTS -->
      <div id="panel-messages" class="tab-panel hidden">
        <div class="card">
          <div class="card-title">Messages des étudiants</div>
          <div class="card-divider"></div>
          <?php
          $msgs = [
            ['nom'=>'Kenania CAPE','mat'=>'MAT-2026-0042','msg'=>'Bonjour, je voudrais savoir si ma référence bancaire NSIA-2026-00420 a bien été reçue ?','time'=>'11 juin 2026','unread'=>true],
            ['nom'=>'DIABATÉ Aminata','mat'=>'MAT-2026-0015','msg'=>'Est-il possible d\'obtenir un délai supplémentaire pour le paiement de ma 3ème tranche ?','time'=>'09 juin 2026','unread'=>true],
            ['nom'=>'N\'GORAN Paul','mat'=>'MAT-2026-0029','msg'=>'Merci pour la confirmation de mon versement. Pouvez-vous m\'envoyer un reçu officiel PDF ?','time'=>'08 juin 2026','unread'=>false],
          ];
          foreach($msgs as $m):
          ?>
          <div class="msg-row <?= $m['unread']?'unread':'' ?>">
            <div class="msg-avatar">🎓</div>
            <div class="msg-body">
              <div class="msg-from"><?= htmlspecialchars($m['nom']) ?> <span style="font-weight:400;color:var(--grey-600);font-size:11px;"><?= $m['mat'] ?></span></div>
              <div class="msg-text"><?= htmlspecialchars($m['msg']) ?></div>
            </div>
            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:6px;">
              <span class="msg-time"><?= $m['time'] ?></span>
              <?php if($m['unread']): ?><div class="msg-dot"></div><?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
          <div class="card-divider"></div>
          <textarea class="form-input form-textarea" rows="2" placeholder="Répondre à l'étudiant sélectionné…"></textarea>
          <div style="margin-top:10px;">
            <button class="btn btn-primary btn-sm" onclick="showToast('Réponse envoyée à l\'étudiant ','success')">✉️ Envoyer la réponse</button>
          </div>
        </div>
      </div>

      <!-- PANEL PAIEMENTS PHYSIQUES -->
      <div id="panel-physiques" class="tab-panel hidden">
        <div class="card">
          <div class="card-title">Paiements physiques à valider</div>
          <div class="card-divider"></div>
          <div class="table-wrap">
            <table class="table-base">
              <thead>
                <tr><th>Étudiant</th><th>Référence bancaire</th><th>Montant déclaré</th><th>Soumis le</th><th>Action</th></tr>
              </thead>
              <tbody>
                <?php foreach($paiementsPhysiques as $p): ?>
                <tr>
                  <td>
                    <div class="td-name"><?= $p['nom'] ?></div>
                    <div class="td-sub"><?= $p['mat'] ?></div>
                  </td>
                  <td><span class="badge badge-grey"><?= $p['ref'] ?></span></td>
                  <td style="font-weight:700;">
                    <input type="text" class="form-input" placeholder="EX: 90 000" />
                  </td>
                  <td style="font-size:12px;color:var(--grey-600);">11 juin 2026</td>
                  <td style="display:flex;gap:8px;">
                    <button class="btn btn-accent btn-sm" onclick="validerPaiement(<?= $p['id'] ?>,'<?= $p['nom'] ?>',this)"> Valider</button>
                    <button class="btn btn-danger btn-sm"  onclick="rejeterPaiement('<?= $p['nom'] ?>')"> Rejeter</button>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- PANEL PAIEMENTS DIGITAUX (placeholder) -->
      <div id="panel-digital" class="tab-panel hidden">
        <div class="card">
          <div class="card-title">Paiements digitaux</div>
          <div class="card-divider"></div>
          <div style="padding:16px;color:var(--grey-600);">Aucun paiement digital à traiter pour le moment.</div>
        </div>
      </div>

    <?php endif; ?>

    </div><!-- /content -->
  </div><!-- /main-wrap -->
</div><!-- /app-layout -->

<div class="toast-container"></div>
<script src="/js/app.js"></script>
<script>
function validerPaiement(id, nom, btn) {
  if (!confirm(`Confirmer la validation du paiement de ${nom} ?`)) return;
  btn.disabled = true;
  btn.textContent = '⏳…';
  setTimeout(() => {
    btn.textContent = ' Validé';
    btn.style.background = 'var(--accent)';
    showToast(` Paiement de ${nom} validé ! Email de confirmation envoyé.`, 'success', 5000);
  }, 1200);
}

function rejeterPaiement(nom) {
  if (!confirm(`Rejeter le paiement de ${nom} ?`)) return;
  showToast(` Paiement de ${nom} rejeté. L'étudiant a été notifié.`, 'danger');
}

function actionCandidature(action, id, nom) {
  const msg = document.getElementById('message_admin').value;
  const labels = { accepter:'acceptée', refuser:'refusée', attente:'mise en attente' };
  if (!confirm(`Confirmer : candidature de ${nom} sera ${labels[action]} ?`)) return;
  const toastType = action==='accepter'?'success': action==='refuser'?'danger':'default';
  showToast(` Candidature de ${nom} ${labels[action]}. Email envoyé automatiquement.`, toastType, 6000);
  setTimeout(() => window.location.reload(), 2000);
}
</script>
</body>
</html>

