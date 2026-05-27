<?php
// admin/lire_contact.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/connexion.php'); 
require_once('../fonctions.php');

// Protection d'accès
verifierAuthentification();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: contacts.php');
    exit();
}

try {
    // 1. Récupération du message de contact par son ID
    $stmt = $pdo->prepare("SELECT * FROM messages_contact WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $msg = $stmt->fetch();

    if (!$msg) {
        header('Location: contacts.php');
        exit();
    }

    // 2. EXIGENCE PROF : Passer le statut 'lu' à 1 si ce n'est pas déjà fait
    if ($msg['lu'] == 0) {
        $update_stmt = $pdo->prepare("UPDATE messages_contact SET lu = 1 WHERE id = :id");
        $update_stmt->execute(['id' => $id]);
        
        $msg['lu'] = 1;
    }

} catch (PDOException $e) {
    error_log("Erreur Lecture Contact: " . $e->getMessage());
    die("LOG_ERROR // CRITICAL_READ_FAILURE");
}
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CORE_SYSTEM // READ_CONTACT_NODE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" rel="stylesheet" />
    <style>
        body { 
            background-color: #050505; 
            color: #FFFFFF; 
            overflow-x: hidden; 
        }
        .font-headline { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased selection:bg-[#00f719]/40">

    <nav class="border-b border-[#00f719]/20 bg-black/80 backdrop-blur-md sticky top-0 z-50 px-8 py-4 flex justify-between items-center w-full">
        <div class="flex items-center gap-3">
            <a href="contacts.php" class="flex items-center gap-2 text-[#A3A3A3] hover:text-[#00f719] font-mono text-xs transition-colors">
                <span class="material-symbols-outlined text-sm">arrow_back</span> BACK_TO_LIST
            </a>
        </div>
        <div class="flex items-center gap-6 font-mono text-xs">
            <span class="text-[#A3A3A3]">NODE_ID: <span class="text-[#00f719]">#<?= (int)$msg['id'] ?></span></span>
        </div>
    </nav>

    <main class="w-full max-w-3xl mx-auto px-8 py-12 flex flex-col gap-8">
        
        <header class="border-b border-[#00f719]/20 pb-6">
            <span class="font-mono text-[#00f719] text-xs tracking-[0.3em] uppercase">TRANSMISSION_DATA</span>
            <h1 class="font-headline text-3xl font-black tracking-tight text-[#e2e2e2] uppercase">MESSAGE DE CONTACT</h1>
        </header>

        <div class="border border-[#00f719]/20 bg-[#0A0A0A] p-6 font-mono text-xs space-y-4">
            <div class="flex flex-col sm:grid sm:grid-cols-3 border-b border-white/5 pb-3 gap-1">
                <span class="text-[#A3A3A3] uppercase">Nom :</span>
                <span class="col-span-2 text-[#F2F2F2] font-bold"><?= e($msg['nom']) ?></span>
            </div>
            <div class="flex flex-col sm:grid sm:grid-cols-3 border-b border-white/5 pb-3 gap-1">
                <span class="text-[#A3A3A3] uppercase">Email :</span>
                <a href="mailto:<?= e($msg['email']) ?>" class="col-span-2 text-[#00f719] hover:underline font-bold break-all"><?= e($msg['email']) ?></a>
            </div>
            <div class="flex flex-col sm:grid sm:grid-cols-3 border-b border-white/5 pb-3 gap-1">
                <span class="text-[#A3A3A3] uppercase">Sujet :</span>
                <span class="col-span-2 text-[#F2F2F2] font-bold"><?= e($msg['sujet'] ?? 'Sans objet') ?></span>
            </div>
            <div class="flex flex-col sm:grid sm:grid-cols-3 border-b border-white/5 pb-3 gap-1">
                <span class="text-[#A3A3A3] uppercase">Date :</span>
                <span class="col-span-2 text-[#A3A3A3]"><?= e($msg['date_envoi'] ?? 'Inconnue') ?></span>
            </div>
            <div class="flex flex-col sm:grid sm:grid-cols-3 gap-1">
                <span class="text-[#A3A3A3] uppercase">Statut :</span>
                <span class="col-span-2 text-[#00f719] font-bold uppercase">[✓] MARQUÉ COMME LU</span>
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <span class="font-mono text-[#A3A3A3] text-[11px] uppercase tracking-wider">📦 PAYLOAD / MESSAGE_CONTENT :</span>
            <div class="border border-white/10 bg-black p-6 font-mono text-xs text-[#F2F2F2] leading-relaxed whitespace-pre-wrap break-words select-text">
                <?= e($msg['message'] ?? 'Corps de message vide.') ?>
            </div>
        </div>

        <div class="flex justify-start pt-4">
            <a href="contacts.php" class="bg-white/5 border border-white/10 hover:border-[#00f719] hover:text-[#00f719] text-[#F2F2F2] font-mono text-xs font-bold px-6 py-3 transition-colors uppercase tracking-wider">
                ➔ RETOURNER À LA LISTE
            </a>
        </div>

    </main>

</body>
</html>