<?php
/**
 * MA SCOLARITÉ — Routeur de simulation
 * Lancer : cd public && php -S localhost:8000 index.php
 */
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';

// Fichiers statiques (css, js, images)
$publicFile = __DIR__ . $uri;
if ($uri !== '/' && file_exists($publicFile) && is_file($publicFile)) {
    return false;
}

define('VIEWS', __DIR__ . '/../resources/views');

function render(string $view): void {
    $path = VIEWS . '/' . $view;
    if (file_exists($path)) {
        require $path;
    } else {
        http_response_code(404);
        echo "<h2 style='font-family:sans-serif;padding:40px;'>Vue introuvable : $view</h2>";
    }
}

// ══ ROUTES ══════════════════════════════════════

// Accueil
if ($uri === '/') { render('public/home.php'); exit; }

// École ITES (ancien slug esca redirige aussi)
if ($uri === '/ecoles/ites' || $uri === '/ecoles/esca') {
    render('public/ecole.php'); exit;
}

// Candidature
if (str_starts_with($uri, '/ecoles/') && str_ends_with($uri, '/candidature')) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['success'] = 'Candidature soumise avec succès ! Vous recevrez une réponse par email.';
        header('Location: /'); exit;
    }
    render('public/candidature.php'); exit;
}

// Paiement inscription
if (str_starts_with($uri, '/inscription/paiement')) {
    render('public/paiement-inscription.php'); exit;
}

// ── PORTAIL ÉTUDIANT ─────────────────────────
if ($uri === '/portail/connexion') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Connexion directe sans vérification pour la démo
        $_SESSION['etudiant_id'] = 42;
        header('Location: /portail/dashboard'); exit;
    }
    render('portail/login.php'); exit;
}

if ($uri === '/portail/dashboard') {
    // Pas de redirection forcée — accès direct pour la démo
    if (empty($_SESSION['etudiant_id'])) { $_SESSION['etudiant_id'] = 42; }
    render('portail/dashboard.php'); exit;
}

if ($uri === '/portail/paiement') {
    if (empty($_SESSION['etudiant_id'])) { $_SESSION['etudiant_id'] = 42; }
    render('portail/paiement.php'); exit;
}

if ($uri === '/portail/messages' || $uri === '/portail/reduction') {
    if (empty($_SESSION['etudiant_id'])) { $_SESSION['etudiant_id'] = 42; }
    render('portail/dashboard.php'); exit;
}

if ($uri === '/portail/deconnexion') {
    unset($_SESSION['etudiant_id']);
    header('Location: /portail/connexion'); exit;
}

// ── ADMINISTRATION ────────────────────────────
if ($uri === '/admin' || $uri === '/admin/connexion') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Connexion directe sans vérification pour la démo
        $_SESSION['admin_id'] = 1;
        header('Location: /admin/dashboard'); exit;
    }
    render('admin/login.php'); exit;
}

if ($uri === '/admin/inscription') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['admin_id'] = 1;
        header('Location: /admin/dashboard'); exit;
    }
    render('admin/login.php'); exit;
}

if ($uri === '/admin/dashboard') {
    // Accès direct pour la démo
    if (empty($_SESSION['admin_id'])) { $_SESSION['admin_id'] = 1; }
    render('admin/dashboard.php'); exit;
}

if ($uri === '/admin/deconnexion') {
    unset($_SESSION['admin_id']);
    header('Location: /admin/connexion'); exit;
}

// Téléchargements simulés
if (str_starts_with($uri, '/documents/telecharger/')) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="document_ma_scolarite.pdf"');
    echo "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f\n0000000009 00000 n\n0000000058 00000 n\n0000000115 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n190\n%%EOF";
    exit;
}

// 404
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>Page introuvable — Ma Scolarité</title>
  <link rel="stylesheet" href="/css/app.css"/>
</head>
<body style="display:flex;align-items:center;justify-content:center;min-height:100vh;background:var(--bg);">
  <div style="text-align:center;padding:48px;">
    <div style="font-size:64px;margin-bottom:16px;">🔍</div>
    <h1 style="font-size:28px;font-weight:700;color:var(--dark);margin-bottom:8px;">Page introuvable</h1>
    <p style="color:var(--grey-600);margin-bottom:24px;">L'URL <code><?= htmlspecialchars($uri) ?></code> n'existe pas.</p>
    <a href="/" class="btn btn-primary">← Retour à l'accueil</a>
  </div>
</body>
</html>
