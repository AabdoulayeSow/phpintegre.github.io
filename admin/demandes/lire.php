<?php
// admin/demandes/lire.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../config/connexion.php'); 
require_once('../../fonctions.php');

// Protection d'accès stricte
verifierAuthentification();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit();
}

try {
    // 1. Récupération de la demande par son ID via requête préparée
    $stmt = $pdo->prepare("SELECT * FROM demandes_projet WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $demande = $stmt->fetch();

    if (!$demande) {
        header('Location: index.php');
        exit();
    }

    // 2. EXIGENCE PROF : Passer le statut 'lu' à 1 si ce n'est pas déjà fait
    if ($demande['lu'] == 0) {
        $update_stmt = $pdo->prepare("UPDATE demandes_projet SET lu = 1 WHERE id = :id");
        $update_stmt->execute(['id' => $id]);
        
        // On force le rafraîchissement de la variable locale pour l'affichage immédiat du badge
        $demande['lu'] = 1;
    }

} catch (PDOException $e) {
    error_log("Erreur Lecture Demande: " . $e->getMessage());
    die("LOG_ERROR // CRITICAL_READ_FAILURE");
}
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CORE_SYSTEM // READ_DECRYPTED_NODE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" rel="stylesheet" />
    <style>
        body { background-color: #050505; color: #FFFFFF; }
        .font-headline { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased selection:bg-[#00f719]/40">

    <nav class="border-b border-[#00f719]/20 bg-black/80 backdrop-blur-md sticky top-0 z-50 px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <a href="index.php" class="flex items-center gap-2 text-[#A3A3A3] hover:text-[#00f719] font-mono text-xs transition-colors">
                <span class="material-symbols-outlined text-sm">arrow_back</span> BACK_TO_LIST
            </a>
        </div>
        <div class="flex items-center gap-6 font-mono text-xs">
            <span class="text-[#A3A3A3]">NODE_ID: <span class="text-[#00f719]">#<?= (int)$demande['id'] ?></span></span>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-8 py-12 flex flex-col gap-8">
        
        <header class="border-b border-[#00f719]/20 pb-6">
            <span class="font-mono text-[#00f719] text-xs tracking-[0.3em] uppercase">TRANSMISSION_DATA</span>
            <h1 class="font-headline text-3xl font-black tracking-tight text-[#e2e2e2] uppercase">CONTENU DE LA DEMANDE</h1>
        </header>

        <div class="border border-[#00f719]/20 bg-[#0A0A0A] p-6 font-mono text-xs space-y-4">
            <div class="grid grid-cols-3 border-b border-white/5 pb-3">
                <span class="text-[#A3A3A3] uppercase">Expéditeur :</span>
                <span class="col-span-2 text-[#F2F2F2] font-bold"><?= e($demande['nom']) ?></span>
            </div>
            <div class="grid grid-cols-3 border-b border-white/5 pb-3">
                <span class="text-[#A3A3A3] uppercase">Canal de secours (Email) :</span>
                <a href="mailto:<?= e($demande['email']) ?>" class="col-span-2 text-[#00f719] hover:underline font-bold"><?= e($demande['email']) ?></a>
            </div>
            <div class="grid grid-cols-3 border-b border-white/5 pb-3">
                <span class="text-[#A3A3A3] uppercase">Type de Projet demandé :</span>
                <span class="col-span-2 text-[#F2F2F2] font-bold"><?= e($demande['type_projet'] ?? 'Non spécifié') ?></span>
            </div>
            <div class="grid grid-cols-3 border-b border-white/5 pb-3">
                <span class="text-[#A3A3A3] uppercase">Horodatage d'arrivée :</span>
                <span class="col-span-2 text-[#A3A3A3]"><?= e($demande['date_demande'] ?? 'Inconnue') ?></span>
            </div>
            <div class="grid grid-cols-3">
                <span class="text-[#A3A3A3] uppercase">Statut Système :</span>
                <span class="col-span-2 text-[#00f719] font-bold uppercase">[✓] MARQUÉ COMME LU</span>
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <span class="font-mono text-[#A3A3A3] text-[11px] uppercase tracking-wider">📦 PAYLOAD / MESSAGE_BODY :</span>
            <div class="border border-white/10 bg-black p-6 font-mono text-xs text-[#F2F2F2] leading-relaxed whitespace-pre-wrap select-text selection:bg-[#00f719]/30">
                <?= e($demande['message'] ?? 'Aucun message textuel fourni.') ?>
            </div>
        </div>

        <div class="flex justify-start pt-4">
            <a href="index.php" class="bg-white/5 border border-white/10 hover:border-[#00f719] hover:text-[#00f719] text-[#F2F2F2] font-mono text-xs font-bold px-6 py-3 transition-colors uppercase tracking-wider">
                ➔ RETOURNER AU REPERTOIRE
            </a>
        </div>

    </main>

</body>
</html>