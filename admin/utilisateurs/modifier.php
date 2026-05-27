<?php
// admin/utilisateurs/modifier.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../config/connexion.php'); 
require_once('../../fonctions.php');

verifierAuthentification();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit();
}

$erreur = "";
$succes = "";

try {
    // CORRECTION : Sélection depuis la table 'administrateurs'
    $stmt = $pdo->prepare("SELECT nom, prenom, email FROM administrateurs WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch();

    if (!$user) {
        header('Location: index.php');
        exit();
    }
} catch (PDOException $e) {
    error_log("Erreur fetch user: " . $e->getMessage());
    die("LOG_ERROR // USER_NOT_FOUND");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($nom) || empty($prenom) || empty($email)) {
        $erreur = "Le nom, le prénom et l'adresse e-mail sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Format d'adresse e-mail invalide.";
    } else {
        try {
            // CORRECTION : Vérification unicité dans la table 'administrateurs'
            $check = $pdo->prepare("SELECT id FROM administrateurs WHERE email = :email AND id != :id");
            $check->execute(['email' => $email, 'id' => $id]);
            
            if ($check->fetch()) {
                $erreur = "Cette adresse e-mail est déjà assignée à un autre compte.";
            } else {
                
                if (!empty($password)) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    // CORRECTION : Table 'administrateurs'
                    $sql = "UPDATE administrateurs SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mdp WHERE id = :id";
                    $params = [
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'email' => $email,
                        'mdp' => $passwordHash,
                        'id' => $id
                    ];
                } else {
                    // CORRECTION : Table 'administrateurs'
                    $sql = "UPDATE administrateurs SET nom = :nom, prenom = :prenom, email = :email WHERE id = :id";
                    $params = [
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'email' => $email,
                        'id' => $id
                    ];
                }

                $updateStmt = $pdo->prepare($sql);
                $updateStmt->execute($params);

                $succes = "Données d'accès mises à jour de façon sécurisée.";
                
                $user['nom'] = $nom;
                $user['prenom'] = $prenom;
                $user['email'] = $email;
            }
        } catch (PDOException $e) {
            error_log("Erreur Modification Utilisateur: " . $e->getMessage());
            $erreur = "Erreur lors de la mise à jour des accès.";
        }
    }
}
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CORE_SYSTEM // EDIT_OPERATOR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <style>
        body { background-color: #0d1117; color: #e2e2e2; }
        .font-headline { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', sans-serif; }
        input { background-color: #070a0e !important; border: 1px solid #30363d !important; color: #e2e2e2 !important; font-family: 'IBM Plex Mono', monospace; font-size: 12px; }
        input:focus { border-color: #00f719 !important; outline: none !important; }
    </style>
</head>
<body class="font-sans antialiased">

    <main class="max-w-2xl mx-auto px-8 py-12 flex flex-col gap-8">
        
        <header class="border-b border-[#30363d] pb-6">
            <a href="index.php" class="font-mono text-xs text-[#baccb0] hover:text-[#00f719] transition-colors">< BACK_TO_DIRECTORY</a>
            <h1 class="font-headline text-3xl font-bold tracking-tight text-[#e2e2e2] mt-4 uppercase">MODIFIER L'OPÉRATEUR #<?= sprintf("%02d", $id) ?></h1>
        </header>

        <?php if(!empty($erreur)): ?>
            <div class="border border-red-500/30 bg-red-500/10 p-4 font-mono text-xs text-red-400 uppercase tracking-wide">
                [!] ERROR // <?= e($erreur) ?>
            </div>
        <?php endif; ?>

        <?php if(!empty($succes)): ?>
            <div class="border border-[#00f719]/30 bg-[#00f719]/10 p-4 font-mono text-xs text-[#00f719] uppercase tracking-wide">
                [✓] SUCCESS // <?= e($succes) ?>
            </div>
        <?php endif; ?>

        <form action="modifier.php?id=<?= $id ?>" method="POST" class="flex flex-col gap-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-2">
                    <label class="font-mono text-xs text-[#baccb0] uppercase">Prénom :</label>
                    <input type="text" name="prenom" value="<?= e($user['prenom']) ?>" required class="p-3" />
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-mono text-xs text-[#baccb0] uppercase">Nom :</label>
                    <input type="text" name="nom" value="<?= e($user['nom']) ?>" required class="p-3" />
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-mono text-xs text-[#baccb0] uppercase">Adresse E-mail (Identifiant) :</label>
                <input type="email" name="email" value="<?= e($user['email']) ?>" required class="p-3 w-full" />
            </div>

            <div class="flex flex-col gap-2">
                <label class="font-mono text-xs text-[#baccb0] uppercase">Changer la clé d'accès (Mot de passe) :</label>
                <input type="password" name="password" class="p-3 w-full" placeholder="Laisser vide si inchangé" />
                <span class="font-mono text-[10px] text-[#baccb0]/50 italic">Laissez ce champ entièrement vide si vous ne souhaitez pas remplacer le mot de passe existant de cet utilisateur.</span>
            </div>

            <button type="submit" class="bg-[#00f719] text-[#0d1117] font-mono font-bold text-xs px-6 py-3.5 tracking-wider hover:bg-[#00f719]/80 transition-colors uppercase text-center mt-2">
                UPDATE_OPERATOR_DATA
            </button>
        </form>

    </main>

</body>
</html>