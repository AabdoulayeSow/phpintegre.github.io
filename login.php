<?php
// 1. Initialisation de la session et inclusion des dépendances
require_once('config/connexion.php');
require_once('fonctions.php');

// EXIGENCE : Démarrer la session avant tout affichage ou traitement
session_start();

// Redirection si déjà connecté
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

$erreur = '';

// 2. Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation CSRF (Exigence 3.2)
    if (!isset($_POST['csrf_token']) || !verifier_csrf($_POST['csrf_token'])) {
        die("ERREUR_CRITIQUE // Échec de la validation de sécurité (CSRF).");
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['mot_de_passe'] ?? '';

    if ($email !== '' && $password !== '') {
        try {
            // Requête préparée (Exigence 3.2 - Pas de concaténation)
            $stmt = $pdo->prepare("SELECT * FROM administrateurs WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $admin = $stmt->fetch();

            // Vérification du mot de passe avec password_verify (Exigence 3.2)
            // Assure-toi que les mots de passe en BDD sont hachés via password_hash()
            if ($admin && password_verify($password, $admin['mot_de_passe'])) {
                
                // Régénération de l'ID de session pour prévenir la fixation (Exigence 3.2)
                session_regenerate_id(true);

                // Stockage strict : ID et prénom uniquement
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_prenom'] = $admin['prénom']; 

                header('Location: dashboard.php');
                exit();
            } else {
                // Message d'erreur générique (Exigence 5.1)
                $erreur = "Identifiants système incorrects.";
            }
        } catch (PDOException $e) {
            // Log de l'erreur côté serveur
            error_log("Erreur BDD login : " . $e->getMessage());
            $erreur = "Erreur de communication avec le serveur d'authentification.";
        }
    } else {
        $erreur = "Veuillez remplir tous les champs requis.";
    }
}

// Génération du token pour le formulaire
$csrf_token = genererTokenCSRF();
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SECURE_AUTH // ACCESS_GATE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <style>
        body { background-color: #0d1117; font-family: 'Inter', sans-serif; }
        .font-headline { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#00f719]/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-md bg-[#161b22]/80 backdrop-blur-md border border-[#30363d] p-8 rounded-none relative z-10">
        <div class="mb-8 flex flex-col gap-2">
            <span class="font-mono text-[#00f719] text-xs tracking-widest uppercase">SECURE_INTERFACE v2.0</span>
            <h1 class="font-headline text-3xl font-bold text-[#e2e2e2] tracking-tight">CONNEXION <span class="text-[#00f719]">ADMIN.</span></h1>
        </div>

        <?php if ($erreur !== ''): ?>
            <div class="mb-6 p-4 bg-red-900/20 border border-red-500/40 text-red-400 font-mono text-xs flex items-center gap-2 rounded-none">
                <span class="w-2 h-2 bg-red-500 animate-pulse"></span>
                <?= e($erreur) ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="flex flex-col gap-6">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>" />

            <div class="flex flex-col gap-2">
                <label class="font-mono text-xs text-[#baccb0] uppercase tracking-wider">EMAIL_ADDRESS</label>
                <input type="email" name="email" required autocomplete="off" class="w-full bg-[#0d1117] border border-[#30363d] focus:border-[#00f719] text-[#e2e2e2] font-mono px-4 py-3 text-sm rounded-none outline-none transition-colors" placeholder="admin@domain.local" />
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-mono text-xs text-[#baccb0] uppercase tracking-wider">PASSWORD</label>
                <input type="password" name="mot_de_passe" required class="w-full bg-[#0d1117] border border-[#30363d] focus:border-[#00f719] text-[#e2e2e2] font-mono px-4 py-3 text-sm rounded-none outline-none transition-colors" placeholder="••••••••••••" />
            </div>

            <button type="submit" class="w-full mt-2 bg-[#00f719]/10 border border-[#00f719] hover:bg-[#00f719]/20 text-[#00f719] font-mono font-bold text-xs py-4 tracking-widest transition-all uppercase">
                INITIALIZE_SESSION
            </button>
        </form>
    </div>
</body>
</html>