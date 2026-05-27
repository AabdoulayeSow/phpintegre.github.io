<?php
// admin/utilisateurs/index.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../../config/connexion.php');
require_once(__DIR__ . '/../../fonctions.php');

verifierAuthentification();

// Gestion des notifications reçues par URL
$notification = "";
$type_notification = "";

if (isset($_GET['statut']) && $_GET['statut'] === 'DELETED') {
    $notification = "[✓] SUCCESS // L'OPÉRATEUR A ÉTÉ RETIRÉ DE LA BASE DE DONNÉES.";
    $type_notification = "succes";
}

if (isset($_GET['erreur'])) {
    $type_notification = "erreur";
    if ($_GET['erreur'] === 'AUTO_DESTRUCTION_DENIED') {
        $notification = "[!] ALERT // ACTION IMPOSSIBLE : VOUZ NE POUVEZ PAS SUPPRIMER VOTRE PROPRE COMPTE EN COURS D'UTILISATION.";
    } else {
        $notification = "[!] ERROR // ÉCHEC DE LA COMMANDE DE SUPPRESSION SYSTÈME.";
    }
}

try {
    $stmt = $pdo->query("SELECT id, nom, prenom, email, date_creation FROM administrateurs ORDER BY id ASC");
    $utilisateurs = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Erreur Listing Users: " . $e->getMessage());
    die("LOG_ERROR // CRITICAL_USER_FETCH_FAILURE");
}
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CORE_SYSTEM // OPERATOR_DIRECTORY</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" rel="stylesheet" />
    <style>
        body { 
            background-color: #0d1117; 
            color: #e2e2e2; 
            overflow-x: hidden; /* Empêche le scroll horizontal sur toute la page */
        }
        .font-headline { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased selection:bg-[#00f719] selection:text-[#003a01]">

    <nav class="border-b border-[#30363d] bg-[#161b22]/80 backdrop-blur-md sticky top-0 z-50 px-8 py-4 flex justify-between items-center w-full">
        <div class="flex items-center gap-3">
            <a href="../dashboard.php" class="flex items-center gap-2 text-[#baccb0] hover:text-[#00f719] font-mono text-xs transition-colors">
                <span class="material-symbols-outlined text-sm">matrix</span> RETURN_TO_CORE
            </a>
        </div>
        <div class="flex items-center gap-6 font-mono text-xs">
            <span class="text-[#baccb0]">SYS_OPERATOR: <span class="text-[#00f719]"><?= isset($_SESSION['admin_prenom']) ? e($_SESSION['admin_prenom']) : 'UNKNOWN' ?></span></span>
        </div>
    </nav>

    <main class="w-full max-w-6xl mx-auto px-8 py-12 flex flex-col gap-8">
        
        <header class="border-b border-[#30363d] pb-6 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <span class="font-mono text-[#00f719] text-xs tracking-[0.3em] uppercase">ACCESS_CONTROL_NODE</span>
                <h1 class="font-headline text-4xl font-bold tracking-tight text-[#e2e2e2]">GESTION DES UTILISATEURS</h1>
            </div>
            <a href="ajouter.php" class="bg-[#00f719] text-[#0d1117] font-mono font-bold text-xs px-4 py-2.5 tracking-wider hover:bg-[#00f719]/80 transition-colors uppercase flex items-center gap-2">
                <span class="material-symbols-outlined text-sm font-black">add</span> NEW_OPERATOR
            </a>
        </header>

        <?php if (!empty($notification)): ?>
            <?php if ($type_notification === 'succes'): ?>
                <div class="border border-[#00f719]/30 bg-[#00f719]/10 p-4 font-mono text-xs text-[#00f719] uppercase tracking-wide">
                    <?= $notification ?>
                </div>
            <?php else: ?>
                <div class="border border-red-500/30 bg-red-500/10 p-4 font-mono text-xs text-red-400 uppercase tracking-wide">
                    <?= $notification ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="w-full max-w-full border border-[#30363d] bg-[#161b22]/40 overflow-x-auto">
            <table class="w-full text-left font-mono text-xs border-collapse min-w-[700px]">
                <thead>
                    <tr class="border-b border-[#30363d] bg-black/20 text-[#baccb0] uppercase tracking-wider">
                        <th class="p-4 w-16">ID</th>
                        <th class="p-4">Identité</th>
                        <th class="p-4">Email / Identifiant</th>
                        <th class="p-4 w-44">Date Enregistrement</th>
                        <th class="p-4 w-56 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#30363d]/40">
                    <?php if (empty($utilisateurs)): ?>
                        <tr>
                            <td colspan="5" class="p-12 text-center text-[#baccb0]/40 uppercase tracking-widest italic">
                                [// CRITICAL_ALERT: AUCUN OPÉRATEUR ENREGISTRÉ DANS LE SYSTÈME]
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($utilisateurs as $user): ?>
                            <tr class="hover:bg-white/[0.01] transition-colors">
                                <td class="p-4 text-[#00f719] font-bold">#<?= sprintf("%02d", $user['id']) ?></td>
                                <td class="p-4 font-bold text-[#e2e2e2]">
                                    <?= e($user['prenom']) ?> <?= e($user['nom']) ?>
                                </td>
                                <td class="p-4 text-[#baccb0]"><?= e($user['email']) ?></td>
                                <td class="p-4 text-[#baccb0]/70"><?= e($user['date_creation']) ?></td>
                                <td class="p-4 text-right flex items-center justify-end gap-2 h-full">
                                    <a href="modifier.php?id=<?= (int)$user['id'] ?>" class="inline-block border border-[#30363d] text-[#e2e2e2] hover:border-[#00f719] hover:text-[#00f719] px-2.5 py-1.5 transition-colors uppercase text-[10px] font-bold">
                                        EDIT
                                    </a>
                                    <form action="supprimer.php" method="POST" onsubmit="return confirm('⚠️ ALERTE SYSTÈME : Confirmez-vous la révocation définitive des accès de cet opérateur ?');" class="inline-block m-0">
                                        <input type="hidden" name="id" value="<?= (int)$user['id'] ?>" />
                                        <button type="submit" class="border border-[#30363d] text-red-400 hover:border-red-500 hover:bg-red-500/10 px-2.5 py-1.5 transition-colors uppercase text-[10px] font-bold">
                                            DELETE
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>