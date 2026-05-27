<?php
// 1. Démarrage de session PRIORITAIRE (Avant toute inclusion)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Inclusions
require_once('../config/connexion.php');
require_once('../fonctions.php');

// 3. Si déjà connecté, on redirige vers le dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

$erreur = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification CSRF
    $token_soumis = $_POST['csrf_token'] ?? '';
    if (!verifier_csrf($token_soumis)) {
        die("LOG_ERROR // CSRF_TOKEN_INVALID // Tentative de faille détectée.");
    }
    
    $email = isset($_POST['email']) ? nettoyer($_POST['email']) : '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    
    if (champ_requis($email) && champ_requis($mot_de_passe)) {
        try {
            $stmt = $pdo->prepare("SELECT id, nom, prenom, mot_de_passe FROM administrateurs WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $admin = $stmt->fetch();
            
            // Vérification du mot de passe
            if ($admin && password_verify($mot_de_passe, $admin['mot_de_passe'])) {
                // Régénération de l'ID de session pour prévenir la fixation de session
                session_regenerate_id(true);
                
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_prenom'] = $admin['prenom'];
                $_SESSION['admin_nom'] = $admin['nom'];
                
                // Redirection finale
                header('Location: dashboard.php');
                exit();
            } else {
                $erreur = "Identifiants système incorrects. Accès refusé.";
            }
        } catch (PDOException $e) {
            error_log("Erreur d'authentification admin : " . $e->getMessage());
            $erreur = "Une erreur technique est survenue.";
        }
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}

$csrf_token = genererTokenCSRF();
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CORE_SYSTEM // AUTHENTICATION</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <style>
        body { background-color: #0d1117; color: #e2e2e2; }
        .font-headline { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased flex items-center justify-center min-h-screen p-4 selection:bg-[#00f719] selection:text-[#003a01]">
    <div class="w-full max-w-md bg-[#161b22]/70 border border-[#30363d] p-8 relative">
        <header class="flex flex-col gap-2 mb-8 text-center">
            <span class="font-mono text-[#00f719] text-xs tracking-[0.3em] uppercase">GATEWAY_CONTROL</span>
            <h1 class="font-headline text-2xl font-bold tracking-tight text-[#e2e2e2]">CONNEXION ADMIN</h1>
        </header>
        <?php if ($erreur): ?>
            <div class="bg-red-950/40 border border-red-500/50 p-4 mb-6 font-mono text-xs text-red-400">
                <span class="font-bold">// ERROR:</span> <?= e($erreur) ?>
            </div>
        <?php endif; ?>
        <form action="connexion.php" method="POST" class="flex flex-col gap-6 font-mono text-sm">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <div class="flex flex-col gap-2">
                <label for="email" class="text-xs text-[#baccb0] uppercase tracking-wider">OPERATOR_EMAIL</label>
                <input type="email" name="email" id="email" required
                       class="bg-[#0d1117] border border-[#30363d] px-4 py-3 text-[#e2e2e2] focus:outline-none focus:border-[#00f719] transition-colors w-full"
                       placeholder="nom@exemple.com">
            </div>
            <div class="flex flex-col gap-2">
                <label for="mot_de_passe" class="text-xs text-[#baccb0] uppercase tracking-wider">SECURITY_PASSPHRASE</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" required
                       class="bg-[#0d1117] border border-[#30363d] px-4 py-3 text-[#e2e2e2] focus:outline-none focus:border-[#00f719] transition-colors w-full"
                       placeholder="••••••••">
            </div>
            
            <div class="flex flex-col gap-2">
                <button type="submit"
                        class="bg-[#00f719] text-[#0d1117] font-bold text-xs py-4 tracking-wider hover:bg-[#00f719]/80 transition-colors uppercase">
                    INITIALIZE_SESSION
                </button>
                <a href="../index.php"
                   class="block text-center border border-[#30363d] text-[#8b949e] hover:text-[#00f719] hover:border-[#00f719] font-bold text-xs py-4 tracking-wider transition-colors uppercase">
                    RETURN_TO_BASE
                </a>
            </div>
        </form>
    </div>
</body>
</html>