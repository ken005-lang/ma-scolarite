/* ═══════════════════════════════════════════════
   MA SCOLARITÉ — app.js
   Fonctions globales : toast, chatbot, stepper,
   filières dynamiques, progress bar, simulateur
═══════════════════════════════════════════════ */

'use strict';

// ────────────────────────────────────────────────
// 1. TOAST NOTIFICATIONS
// ────────────────────────────────────────────────
function showToast(message, type = 'default', duration = 3000) {
  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  toast.textContent = message;
  container.appendChild(toast);
  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(8px)';
    toast.style.transition = 'all .3s';
    setTimeout(() => toast.remove(), 300);
  }, duration);
}

// ────────────────────────────────────────────────
// 2. CHATBOT STATIQUE
// ────────────────────────────────────────────────
const FAQ = [
  {
    mots: ['solde', 'reste', 'restant', 'payer', 'montant', 'combien'],
    rep: '💰 Votre solde restant est affiché sur votre tableau de bord, dans la carte "Solde restant". Il se met à jour automatiquement après chaque paiement confirmé.'
  },
  {
    mots: ['wave', 'orange', 'mtn', 'moov', 'mobile money', 'paiement', 'payer', 'régler'],
    rep: '📱 Pour payer, cliquez sur "💳 Payer ma scolarité" dans le menu gauche ou le bandeau bleu. Choisissez votre opérateur (Wave, Orange Money, MTN MoMo ou Moov Money), entrez le montant et votre numéro.'
  },
  {
    mots: ['banque', 'nsia', 'uba', 'physique', 'guichet', 'agence', 'virement', 'reçu'],
    rep: '🏦 Pour un paiement physique, utilisez votre référence unique (ex : SCO-ETU0042-T3-2026) à l\'agence NSIA ou UBA. Après paiement, entrez le N° de reçu dans la section "Paiement physique" de votre portail.'
  },
  {
    mots: ['matricule', 'connexion', 'accès', 'mot de passe', 'identifiant', 'connecter'],
    rep: '🎓 Votre matricule (ex : MAT-2026-0042) vous a été envoyé par email après validation de votre paiement d\'inscription. Utilisez-le avec votre mot de passe initial pour vous connecter.'
  },
  {
    mots: ['réduction', 'remise', 'bourse', 'aide', 'demande'],
    rep: '📄 Pour soumettre une demande de réduction, allez dans "Demande de réduction" dans le menu gauche. Joignez votre document justificatif en PDF. L\'administration vous répondra par messagerie.'
  },
  {
    mots: ['message', 'contacter', 'admin', 'administration', 'question', 'problème'],
    rep: '✉️ Utilisez la section "Messagerie" de votre portail pour envoyer un message à l\'administration. Vous recevrez leur réponse dans votre messagerie et par email.'
  },
  {
    mots: ['soldée', 'fini', 'terminé', '100%', 'tout payé', 'completé'],
    rep: ' Quand votre scolarité est entièrement soldée, votre barre de progression atteint 100% et vous recevez un email de confirmation. Le statut passe à "Scolarité soldée".'
  },
  {
    mots: ['filière', 'informatique', 'finance', 'communication', 'mécatronique', 'choisir'],
    rep: '📚 L\'ESCA propose 4 filières : Informatique et Mécatronique (filières industrielles), Finance et Communication (filières tertiaires). Vous choisissez votre filière lors de la candidature.'
  },
  {
    mots: ['confirmation', 'email', 'reçu', 'notification'],
    rep: '📧 Après chaque paiement confirmé, vous recevez une notification dans votre messagerie interne ET un email de confirmation avec le détail du versement et votre nouveau solde restant.'
  },
  {
    mots: ['inscription', 'candidature', 'dossier', 'inscrire', 's\'inscrire'],
    rep: '📋 Pour vous inscrire : 1) Téléchargez la grille des frais sur la page de l\'école 2) Cliquez sur "S\'inscrire" 3) Remplissez le formulaire 4) Attendez la validation par email (sous 48h).'
  },
];

function rechercherReponse(question) {
  const q = question.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
  for (const item of FAQ) {
    if (item.mots.some(mot => q.includes(mot.normalize('NFD').replace(/[\u0300-\u036f]/g, '')))) {
      return item.rep;
    }
  }
  return '🤔 Je n\'ai pas de réponse précise à cette question. Envoyez un message à l\'administration via la section "Messagerie" — ils vous répondront rapidement. Je ne peux répondre qu\'aux questions liées à l\'application.';
}

function initChatbot() {
  const fab    = document.getElementById('chatbot-fab');
  const modal  = document.getElementById('chatbot-modal');
  const close  = document.getElementById('chatbot-close');
  const input  = document.getElementById('chatbot-input');
  const send   = document.getElementById('chatbot-send');
  const msgs   = document.getElementById('chatbot-messages');

  if (!fab || !modal) return;

  function appendMsg(text, role) {
    const div = document.createElement('div');
    div.className = `cb-msg ${role}`;
    div.textContent = text;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
  }

  fab.addEventListener('click', () => {
    modal.classList.toggle('open');
    if (modal.classList.contains('open') && msgs.children.length === 0) {
      appendMsg('👋 Bonjour ! Je suis l\'assistant Ma Scolarité. Posez-moi une question sur l\'application.', 'bot');
    }
  });

  close.addEventListener('click', () => modal.classList.remove('open'));

  function handleSend() {
    const q = input.value.trim();
    if (!q) return;
    appendMsg(q, 'user');
    input.value = '';
    setTimeout(() => appendMsg(rechercherReponse(q), 'bot'), 400);
  }

  send.addEventListener('click', handleSend);
  input.addEventListener('keydown', e => { if (e.key === 'Enter') handleSend(); });
}

// ────────────────────────────────────────────────
// 3. STEPPER (formulaire candidature)
// ────────────────────────────────────────────────
let currentStep = 1;
const totalSteps = 4;

function goToStep(n) {
  // Masquer toutes les étapes
  document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
  // Afficher l'étape cible
  const target = document.getElementById(`step-${n}`);
  if (target) target.classList.remove('hidden');

  // Mettre à jour le stepper visuel
  document.querySelectorAll('.step-item').forEach((el, i) => {
    el.classList.remove('active', 'done');
    if (i + 1 < n)  el.classList.add('done');
    if (i + 1 === n) el.classList.add('active');
  });
  currentStep = n;
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function nextStep() {
  if (!validateStep(currentStep)) return;
  if (currentStep < totalSteps) goToStep(currentStep + 1);
}

function prevStep() {
  if (currentStep > 1) goToStep(currentStep - 1);
}

function validateStep(step) {
  const section = document.getElementById(`step-${step}`);
  if (!section) return true;
  let valid = true;
  section.querySelectorAll('[required]').forEach(input => {
    input.classList.remove('error');
    if (!input.value.trim()) {
      input.classList.add('error');
      valid = false;
    }
  });
  if (!valid) showToast('Veuillez remplir tous les champs obligatoires.', 'danger');
  return valid;
}

// ────────────────────────────────────────────────
// 4. FILIÈRES DYNAMIQUES
// ────────────────────────────────────────────────
function initFilieresDynamiques() {
  const typeSelect    = document.getElementById('type_filiere');
  const filiereSelect = document.getElementById('filiere_id');
  if (!typeSelect || !filiereSelect) return;

  const filieres = {
    industrielle: [
      { value: '1', label: '💻 Informatique' },
      { value: '2', label: '⚙️ Mécatronique' },
    ],
    tertiaire: [
      { value: '3', label: '💰 Finance' },
      { value: '4', label: '📡 Communication' },
    ],
  };

  typeSelect.addEventListener('change', function () {
    filiereSelect.innerHTML = '<option value="">-- Choisir une filière --</option>';
    (filieres[this.value] || []).forEach(f => {
      filiereSelect.innerHTML += `<option value="${f.value}">${f.label}</option>`;
    });
    filiereSelect.disabled = !this.value;
  });

  filiereSelect.disabled = true;
}

// ────────────────────────────────────────────────
// 5. DÉVERROUILLAGE BOUTON INSCRIPTION
// ────────────────────────────────────────────────
function initDocumentObligatoire() {
  const dlBtn      = document.getElementById('btn-dl-obligatoire');
  const inscribeBtn = document.getElementById('btn-inscrire');
  const note       = document.getElementById('note-inscription');
  if (!dlBtn) return;

  // Vérifier si déjà téléchargé (session simulée via localStorage)
  if (localStorage.getItem('doc_obligatoire_telecharge') === '1') {
    if (inscribeBtn) inscribeBtn.classList.remove('hidden');
    if (note) note.classList.add('hidden');
  }

  dlBtn.addEventListener('click', function () {
    localStorage.setItem('doc_obligatoire_telecharge', '1');
    if (inscribeBtn) {
      inscribeBtn.classList.remove('hidden');
      inscribeBtn.style.animation = 'toastIn .4s ease';
    }
    if (note) note.classList.add('hidden');
    showToast(' Document téléchargé ! Vous pouvez maintenant vous inscrire.', 'success');
  });
}

// ────────────────────────────────────────────────
// 6. PROGRESS BAR ANIMÉE
// ────────────────────────────────────────────────
function initProgressBar() {
  document.querySelectorAll('.progress-fill').forEach(el => {
    const target = el.dataset.width || '0';
    el.style.width = '0%';
    setTimeout(() => { el.style.width = target; }, 400);
  });
}

// ────────────────────────────────────────────────
// 7. SÉLECTEUR OPÉRATEUR MOBILE MONEY
// ────────────────────────────────────────────────
function initOperateurSelector() {
  document.querySelectorAll('.op-card').forEach(card => {
    card.addEventListener('click', function () {
      document.querySelectorAll('.op-card').forEach(c => c.classList.remove('selected'));
      this.classList.add('selected');
      const hidden = document.getElementById('operateur_selectionne');
      if (hidden) hidden.value = this.dataset.operateur;
    });
  });
}

// ────────────────────────────────────────────────
// 8. SIMULATION PAIEMENT (bouton démo)
// ────────────────────────────────────────────────
function simulerPaiement(reference, montant) {
  const btn = document.getElementById('btn-simuler');
  if (!btn) return;

  btn.addEventListener('click', async function () {
    btn.disabled = true;
    btn.textContent = '⏳ Traitement en cours…';

    // Simuler un délai réseau (2s)
    await new Promise(r => setTimeout(r, 2000));

    // Dans une vraie app : appel AJAX vers /portail/paiement/simuler/{reference}
    // Ici on simule visuellement
    showToast(` Paiement de ${montant} FCFA confirmé ! Référence : ${reference}`, 'success', 5000);

    // Mettre à jour la barre de progression visuellement
    const fill = document.querySelector('.progress-fill');
    if (fill) {
      const current = parseInt(fill.style.width) || 0;
      const ajout   = Math.min(current + 25, 100);
      fill.style.width = ajout + '%';
      document.querySelector('.progress-pct').textContent = ajout + '%';
    }

    btn.textContent = ' Paiement simulé avec succès';
    btn.style.background = 'var(--accent)';

    // Rediriger après 2s
    setTimeout(() => {
      window.location.href = `/portail/paiement/confirmation/${reference}`;
    }, 2500);
  });
}

// ────────────────────────────────────────────────
// 9. RESPONSABLES FINANCIERS (ajouter / supprimer)
// ────────────────────────────────────────────────
function initResponsables() {
  const addBtn    = document.getElementById('btn-add-responsable');
  const bloc2     = document.getElementById('responsable-2');
  if (!addBtn || !bloc2) return;

  addBtn.addEventListener('click', function () {
    bloc2.classList.remove('hidden');
    addBtn.classList.add('hidden');
  });

  const removeBtn = document.getElementById('btn-remove-responsable');
  if (removeBtn) {
    removeBtn.addEventListener('click', function () {
      bloc2.classList.add('hidden');
      addBtn.classList.remove('hidden');
      // Vider les champs
      bloc2.querySelectorAll('input, select').forEach(i => i.value = '');
    });
  }
}

// ────────────────────────────────────────────────
// 10. TABS MESSAGERIE ADMIN
// ────────────────────────────────────────────────
function initTabs() {
  document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', function () {
      const parent = this.closest('.tabs');
      parent.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      this.classList.add('active');

      const target = this.dataset.target;
      if (target) {
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
        const panel = document.getElementById(target);
        if (panel) panel.classList.remove('hidden');
      }
    });
  });
}

// ────────────────────────────────────────────────
// 11. CANDIDATURE — sélection dans la liste admin
// ────────────────────────────────────────────────
function initCandidatureSelect() {
  document.querySelectorAll('.candidature-row').forEach(row => {
    row.addEventListener('click', function () {
      document.querySelectorAll('.candidature-row').forEach(r => r.classList.remove('active'));
      this.classList.add('active');
      const id = this.dataset.id;
      // Dans une vraie app : charger le détail via AJAX ou Livewire
      // Ici on affiche / masque les détails pré-chargés
      document.querySelectorAll('.detail-candidature').forEach(d => d.classList.add('hidden'));
      const detail = document.getElementById(`detail-${id}`);
      if (detail) detail.classList.remove('hidden');
    });
  });
}

// ────────────────────────────────────────────────
// 12. CONFIRMATION AVANT ACTION ADMIN
// ────────────────────────────────────────────────
function confirmerAction(message, formId) {
  if (confirm(message)) {
    document.getElementById(formId).submit();
  }
}

// ────────────────────────────────────────────────
// 13. UPLOAD : prévisualisation photo identité
// ────────────────────────────────────────────────
function initPhotoPreview() {
  const input   = document.getElementById('photo_input');
  const preview = document.getElementById('photo_preview');
  if (!input || !preview) return;

  input.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    if (file.size > 2 * 1024 * 1024) {
      showToast('Image trop lourde (max 2 Mo)', 'danger');
      return;
    }
    const reader = new FileReader();
    reader.onload = e => {
      preview.src = e.target.result;
      preview.classList.remove('hidden');
      document.querySelector('.upload-placeholder').classList.add('hidden');
    };
    reader.readAsDataURL(file);
  });
}

// ────────────────────────────────────────────────
// 14. MONTANT SUGGESTIONS RAPIDES
// ────────────────────────────────────────────────
function initSuggestions() {
  document.querySelectorAll('.montant-suggestion').forEach(btn => {
    btn.addEventListener('click', function () {
      const input = document.getElementById('montant');
      if (input) {
        input.value = this.dataset.montant;
        document.querySelectorAll('.montant-suggestion').forEach(b => b.classList.remove('active', 'btn-primary'));
        this.classList.add('active', 'btn-primary');
      }
    });
  });
}

// ────────────────────────────────────────────────
// 15. INIT GLOBALE
// ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
  initChatbot();
  initFilieresDynamiques();
  initDocumentObligatoire();
  initProgressBar();
  initOperateurSelector();
  initResponsables();
  initTabs();
  initCandidatureSelect();
  initPhotoPreview();
  initSuggestions();
});

