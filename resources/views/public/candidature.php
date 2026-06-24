<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Candidature — ITES II Plateaux</title>
  <link rel="stylesheet" href="/css/app.css"/>
  <style>
    .candidature-page { max-width: 1100px; margin: 0 auto; padding: 32px 24px 80px; }
    .page-header { margin-bottom: 28px; }
    .breadcrumb { font-size: 13px; color: var(--grey-600); margin-bottom: 8px; }
    .breadcrumb a { color: var(--primary); }
    .page-title { font-size: 28px; font-weight: 700; color: var(--dark); }
    .page-sub   { font-size: 15px; color: var(--grey-600); margin-top: 4px; }

    .form-card { background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow); padding: 36px; }
    .form-section-title {
      font-size: 17px; font-weight: 700; color: var(--dark);
      margin-bottom: 6px; padding-bottom: 14px;
      border-bottom: 1px solid var(--grey-100);
    }
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
    .form-grid-1 { display: grid; grid-template-columns: 1fr; gap: 20px; margin-top: 20px; }

    /* Photo upload */
    .photo-upload-zone {
      width: 140px; height: 160px; flex-shrink: 0;
      border: 2px dashed var(--grey-300); border-radius: var(--radius);
      background: var(--grey-100); display: flex; flex-direction: column;
      align-items: center; justify-content: center; gap: 6px;
      cursor: pointer; transition: all .18s; text-align: center;
    }
    .photo-upload-zone:hover { border-color: var(--primary); background: var(--primary-light); }
    .photo-upload-zone img { width: 100%; height: 100%; object-fit: cover; border-radius: var(--radius); display: none; }
    .photo-upload-zone .upload-placeholder { display: flex; flex-direction: column; align-items: center; gap: 6px; }
    .photo-upload-zone .upload-placeholder span { font-size: 36px; }
    .photo-upload-zone .upload-placeholder p { font-size: 11px; color: var(--grey-600); }
    .form-top-row { display: flex; gap: 24px; align-items: flex-start; }
    .form-top-fields { flex: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

    /* Responsables */
    .responsable-bloc {
      background: var(--grey-100); border: 1px solid var(--grey-300);
      border-radius: var(--radius); padding: 20px; margin-top: 16px;
    }
    .responsable-bloc-title {
      font-size: 13px; font-weight: 700; color: var(--dark);
      margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center;
    }

    /* Récapitulatif */
    .recap-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--grey-100); font-size: 13px; }
    .recap-key { color: var(--grey-600); }
    .recap-val { font-weight: 600; color: var(--dark); }

    /* Navigation boutons */
    .form-nav { display: flex; justify-content: space-between; align-items: center; margin-top: 32px; padding-top: 20px; border-top: 1px solid var(--grey-100); }
  </style>
</head>
<body style="background:var(--bg);">

<!-- NAVBAR -->
<header class="navbar">
  <a href="/" class="navbar-logo"><span>📚</span> Ma Scolarité</a>
  <nav class="navbar-links">
    <a href="/">Accueil</a>
    <a href="/ecoles/ites" class="active">Écoles</a>
  </nav>
</header>

<div class="candidature-page">
  <div class="page-header">
    <div class="breadcrumb">
      <a href="/">Accueil</a> › <a href="/ecoles/ites">ITES II Plateaux</a> › Candidature
    </div>
    <h1 class="page-title">Formulaire de candidature</h1>
    <p class="page-sub">Remplissez les 4 étapes pour soumettre votre dossier à l'ITES II Plateaux.</p>
  </div>

  <!-- STEPPER -->
  <div class="stepper" style="margin-bottom:32px;">
    <div class="step-item active" id="step-indicator-1">
      <div class="step-circle">1</div>
      <div class="step-label">Infos personnelles</div>
    </div>
    <div class="step-item" id="step-indicator-2">
      <div class="step-circle">2</div>
      <div class="step-label">Filière & Documents</div>
    </div>
    <div class="step-item" id="step-indicator-3">
      <div class="step-circle">3</div>
      <div class="step-label">Responsables</div>
    </div>
    <div class="step-item" id="step-indicator-4">
      <div class="step-circle">4</div>
      <div class="step-label">Récapitulatif</div>
    </div>
  </div>

  <form method="POST" action="/ecoles/ites/candidature" enctype="multipart/form-data" id="candidature-form">
    <input type="hidden" name="_token" value="<?= $_SESSION['csrf_token'] ?? 'sim_token_2026' ?>"/>

    <!-- ════ ÉTAPE 1 : Informations personnelles ════ -->
    <div class="form-card step-content" id="step-1">
      <div class="form-section-title">Étape 1 — Informations personnelles</div>

      <!-- Photo + Nom/Prénom -->
      <div class="form-top-row" style="margin-top:20px;">
        <div class="photo-upload-zone" onclick="document.getElementById('photo_input').click()">
          <img src="" alt="Aperçu photo" id="photo_preview"/>
          <div class="upload-placeholder">
            <span>📷</span>
            <p>Photo d'identité *<br><small>JPG/PNG max 2Mo</small></p>
          </div>
        </div>
        <input type="file" id="photo_input" name="photo" accept="image/*" style="display:none;" required/>

        <div class="form-top-fields">
          <div class="form-group">
            <label class="form-label">Nom <span>*</span></label>
            <input class="form-input" type="text" name="nom" placeholder="Votre nom de famille" required/>
          </div>
          <div class="form-group">
            <label class="form-label">Prénom <span>*</span></label>
            <input class="form-input" type="text" name="prenom" placeholder="Votre prénom" required/>
          </div>
          <div class="form-group">
            <label class="form-label">Statut <span>*</span></label>
            <select class="form-select" name="statut_etat" required>
              <option value="">-- Choisir --</option>
              <option value="affecte">Affecté(e) de l'État</option>
              <option value="non_affecte">Non affecté(e)</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Date de naissance <span>*</span></label>
            <input class="form-input" type="date" name="date_naissance" required/>
          </div>
        </div>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Lieu de naissance <span>*</span></label>
          <input class="form-input" type="text" name="lieu_naissance" placeholder="Ville, Pays" required/>
        </div>
        <div class="form-group">
          <label class="form-label">Lieu de résidence <span>*</span></label>
          <input class="form-input" type="text" name="lieu_residence" placeholder="Quartier, Commune, Ville" required/>
        </div>
        <div class="form-group">
          <label class="form-label">Téléphone <span>*</span></label>
          <input class="form-input" type="tel" name="telephone" placeholder="+225 07 XX XX XX XX" required/>
        </div>
        <div class="form-group">
          <label class="form-label">Email <span>*</span></label>
          <input class="form-input" type="email" name="email" placeholder="votre@email.ci" required/>
        </div>
        <div class="form-group">
          <label class="form-label">Dernière formation <span>*</span></label>
          <input class="form-input" type="text" name="derniere_formation" placeholder="Ex : BTS Commerce" required/>
        </div>
        <div class="form-group">
          <label class="form-label">Dernier diplôme <span>*</span></label>
          <input class="form-input" type="text" name="dernier_diplome" placeholder="Ex : BTS, Bac, Licence" required/>
        </div>
      </div>

      <div class="form-nav">
        <span></span>
        <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant →</button>
      </div>
    </div>

    <!-- ════ ÉTAPE 2 : Filière & Documents ════ -->
    <div class="form-card step-content hidden" id="step-2">
      <div class="form-section-title">Étape 2 — Filière & Documents</div>

      <div class="form-grid-2" style="margin-top:20px;">
        <div class="form-group">
          <label class="form-label">Type de filière <span>*</span></label>
          <select class="form-select" name="type_filiere" id="type_filiere" required>
            <option value="">-- Choisir un type --</option>
            <option value="industrielle">Filières industrielles (Informatique, Mécatronique)</option>
            <option value="tertiaire">Filières tertiaires (Finance, Communication)</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Filière <span>*</span></label>
          <select class="form-select" name="filiere_id" id="filiere_id" required disabled>
            <option value="">-- Choisissez d'abord un type --</option>
          </select>
        </div>
      </div>

      <div style="margin-top:24px;display:flex;flex-direction:column;gap:16px;">

        <div class="form-group">
          <label class="form-label">
            Document d'identité <span>*</span>
            <span style="font-weight:400;color:var(--grey-600);font-size:12px;">(CNI, CMU ou Récépissé — PDF uniquement)</span>
          </label>
          <div class="upload-zone" onclick="document.getElementById('doc_identite_input').click()">
            <div class="upload-icon">📄</div>
            <p>Cliquez pour sélectionner votre document d'identité (PDF)</p>
            <p style="margin-top:4px;font-size:11px;">Max 5 Mo</p>
          </div>
          <input type="file" id="doc_identite_input" name="document_identite" accept=".pdf" required style="display:none;"/>
          <div id="doc_identite_name" style="margin-top:6px;font-size:12px;color:var(--accent);"></div>
        </div>

        <div class="form-group">
          <label class="form-label">
            Lettre de motivation
            <span style="font-weight:400;color:var(--grey-600);font-size:12px;">(facultatif)</span>
          </label>
          <div class="upload-zone" onclick="document.getElementById('lettre_input').click()">
            <div class="upload-icon">📝</div>
            <p>Cliquez pour ajouter une lettre de motivation (optionnel)</p>
            <p style="margin-top:4px;font-size:11px;">PDF ou Word — Max 5 Mo</p>
          </div>
          <input type="file" id="lettre_input" name="lettre_motivation" accept=".pdf,.doc,.docx" style="display:none;"/>
          <div id="lettre_name" style="margin-top:6px;font-size:12px;color:var(--accent);"></div>
        </div>

      </div>

      <div class="form-nav">
        <button type="button" class="btn btn-ghost" onclick="prevStep()">← Retour</button>
        <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant →</button>
      </div>
    </div>

    <!-- ════ ÉTAPE 3 : Responsables financiers ════ -->
    <div class="form-card step-content hidden" id="step-3">
      <div class="form-section-title">Étape 3 — Responsables financiers</div>
      <p style="margin-top:12px;font-size:13px;color:var(--grey-600);">
        Indiquez la ou les personnes en charge du financement de votre scolarité (minimum 1, maximum 2).
      </p>

      <!-- Responsable 1 -->
      <div class="responsable-bloc">
        <div class="responsable-bloc-title">
          <span>👤 Responsable 1 (obligatoire)</span>
        </div>
        <div class="form-grid-2" style="margin-top:0;">
          <div class="form-group">
            <label class="form-label">Nom complet <span>*</span></label>
            <input class="form-input" type="text" name="responsables[0][nom_complet]" placeholder="Nom et prénom" required/>
          </div>
          <div class="form-group">
            <label class="form-label">Lien de parenté <span>*</span></label>
            <select class="form-select" name="responsables[0][lien_parente]" required>
              <option value="">-- Choisir --</option>
              <option value="Père">Père</option>
              <option value="Mère">Mère</option>
              <option value="Tuteur">Tuteur</option>
              <option value="Frère/Sœur">Frère / Sœur</option>
              <option value="Employeur">Employeur</option>
              <option value="Autre">Autre</option>
            </select>
          </div>
          <div class="form-group" style="grid-column:1/-1;">
            <label class="form-label">Numéro de téléphone <span>*</span></label>
            <input class="form-input" type="tel" name="responsables[0][telephone]" placeholder="+225 07 XX XX XX XX" required/>
          </div>
        </div>
      </div>

      <!-- Bouton ajouter -->
      <button type="button" class="btn btn-ghost btn-sm" id="btn-add-responsable" style="margin-top:12px;">
        + Ajouter un 2ème responsable
      </button>

      <!-- Responsable 2 (caché par défaut) -->
      <div class="responsable-bloc hidden" id="responsable-2">
        <div class="responsable-bloc-title">
          <span>👤 Responsable 2 (optionnel)</span>
          <button type="button" class="btn btn-danger btn-sm" id="btn-remove-responsable">Supprimer</button>
        </div>
        <div class="form-grid-2" style="margin-top:0;">
          <div class="form-group">
            <label class="form-label">Nom complet</label>
            <input class="form-input" type="text" name="responsables[1][nom_complet]" placeholder="Nom et prénom"/>
          </div>
          <div class="form-group">
            <label class="form-label">Lien de parenté</label>
            <select class="form-select" name="responsables[1][lien_parente]">
              <option value="">-- Choisir --</option>
              <option>Père</option><option>Mère</option>
              <option>Tuteur</option><option>Frère / Sœur</option>
              <option>Employeur</option><option>Autre</option>
            </select>
          </div>
          <div class="form-group" style="grid-column:1/-1;">
            <label class="form-label">Numéro de téléphone</label>
            <input class="form-input" type="tel" name="responsables[1][telephone]" placeholder="+225 07 XX XX XX XX"/>
          </div>
        </div>
      </div>

      <div class="form-nav">
        <button type="button" class="btn btn-ghost" onclick="prevStep()">← Retour</button>
        <button type="button" class="btn btn-primary" onclick="nextStep()">Suivant →</button>
      </div>
    </div>

    <!-- ════ ÉTAPE 4 : Récapitulatif ════ -->
    <div class="form-card step-content hidden" id="step-4">
      <div class="form-section-title">Étape 4 — Récapitulatif & Soumission</div>

      <div class="alert alert-info" style="margin-top:16px;">
        <span>ℹ️</span>
        Vérifiez vos informations avant de soumettre. Après soumission, vous recevrez un email de confirmation et l'administration examinera votre dossier sous 48h.
      </div>

      <div style="margin-top:20px;">
        <div style="font-size:13px;font-weight:700;color:var(--grey-600);text-transform:uppercase;letter-spacing:.4px;margin-bottom:10px;">
          Informations personnelles
        </div>
        <div id="recap-infos">
          <!-- Rempli dynamiquement par JS -->
          <div class="recap-row"><span class="recap-key">Nom complet</span><span class="recap-val" id="recap-nom">—</span></div>
          <div class="recap-row"><span class="recap-key">Email</span><span class="recap-val" id="recap-email">—</span></div>
          <div class="recap-row"><span class="recap-key">Téléphone</span><span class="recap-val" id="recap-tel">—</span></div>
          <div class="recap-row"><span class="recap-key">Filière choisie</span><span class="recap-val" id="recap-filiere">—</span></div>
          <div class="recap-row"><span class="recap-key">Document identité</span><span class="recap-val" id="recap-doc">—</span></div>
        </div>
      </div>

      <div style="margin-top:20px;">
        <label style="display:flex;align-items:flex-start;gap:10px;font-size:13px;cursor:pointer;">
          <input type="checkbox" name="certifie" required style="margin-top:3px;flex-shrink:0;"/>
          <span>Je certifie sur l'honneur que toutes les informations fournies sont exactes et complètes. Je comprends que toute fausse déclaration entraîne le rejet de ma candidature.</span>
        </label>
      </div>

      <div class="form-nav">
        <button type="button" class="btn btn-ghost" onclick="prevStep()">← Retour</button>
        <button type="submit" class="btn btn-accent">
           Soumettre ma candidature
        </button>
      </div>
    </div>

  </form>
</div>

<!-- FOOTER -->
<footer class="footer">
  <span class="footer-logo">📚 Ma Scolarité</span>
  <span>© 2026 Ma Scolarité</span>
</footer>

<div class="toast-container"></div>
<script src="/js/app.js"></script>
<script>
  // Afficher nom du fichier après sélection
  ['doc_identite_input','lettre_input'].forEach(id => {
    document.getElementById(id)?.addEventListener('change', function() {
      const nameEl = document.getElementById(id.replace('_input','_name'));
      if (nameEl && this.files[0]) nameEl.textContent = ' ' + this.files[0].name;
    });
  });

  // Remplir le récapitulatif à l'étape 4
  const originalNextStep = window.nextStep;
  window.nextStep = function() {
    originalNextStep?.();
    if (currentStep === 4) {
      const nom    = document.querySelector('[name="nom"]')?.value || '—';
      const prenom = document.querySelector('[name="prenom"]')?.value || '';
      const email  = document.querySelector('[name="email"]')?.value || '—';
      const tel    = document.querySelector('[name="telephone"]')?.value || '—';
      const filS   = document.getElementById('filiere_id');
      const filiere = filS?.options[filS.selectedIndex]?.text || '—';
      const docName = document.getElementById('doc_identite_input')?.files[0]?.name || '—';

      document.getElementById('recap-nom').textContent    = `${prenom} ${nom}`;
      document.getElementById('recap-email').textContent  = email;
      document.getElementById('recap-tel').textContent    = tel;
      document.getElementById('recap-filiere').textContent= filiere;
      document.getElementById('recap-doc').textContent    = docName;
    }
  };
</script>
</body>
</html>

