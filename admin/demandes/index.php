<?php
// admin/demandes/index.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../config/connexion.php'); 
require_once('../../fonctions.php');

verifierAuthentification();

try {
    $stmt = $pdo->query("SELECT * FROM demandes_projet ORDER BY id DESC");
    $demandes = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Erreur Listing Demandes: " . $e->getMessage());
    die("LOG_ERROR // CRITICAL_FETCH_FAILURE");
}
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>CORE_SYSTEM // INCOMING_PROPOSALS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" rel="stylesheet" />
    <style>
        body { 
            background-color: #050505; 
            color: #FFFFFF; 
            /* Fixes radicaux pour empêcher tout mouvement latéral */
            overflow-x: hidden; 
            width: 100vw;
            margin: 0;
            padding: 0;
        }
        .font-headline { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased selection:bg-[#00f719]/40">

    <nav class="border-b border-[#00f719]/20 bg-black/80 backdrop-blur-md sticky top-0 z-50 px-8 py-4 flex justify-between items-center w-full">
        <div class="flex items-center gap-3">
            <a href="../dashboard.php" class="flex items-center gap-2 text-[#A3A3A3] hover:text-[#00f719] font-mono text-xs transition-colors">
                <span class="material-symbols-outlined text-sm">matrix</span> RETURN_TO_CORE
            </a>
        </div>
        <div class="flex items-center gap-6 font-mono text-xs">
            <span class="text-[#A3A3A3]">SYS_OPERATOR: <span class="text-[#00f719]">Systeme</span></span>
        </div>
    </nav>

    <main class="w-full max-w-6xl mx-auto px-4 py-12 flex flex-col gap-8">
        
        <header class="border-b border-[#00f719]/20 pb-6 flex justify-between items-end">
            <div>
                <span class="font-mono text-[#00f719] text-xs tracking-[0.3em] uppercase">GATEWAY_DECRYPT</span>
                <h1 class="font-headline text-4xl font-black tracking-tighter uppercase italic text-[#F2F2F2]">DEMANDES DE PROJETS</h1>
            </div>
            <div class="font-mono text-xs text-[#A3A3A3]">
                TOTAL_NODES: <span class="text-[#00f719] font-bold"><?= count($demandes) ?></span>
            </div>
        </header>

        <div class="w-full border border-[#00f719]/20 bg-[#0A0A0A] overflow-x-auto">
            <table class="w-full text-left font-mono text-xs border-collapse min-w-[700px]">
                <thead>
                    <tr class="border-b border-[#00f719]/20 bg-black/50 text-[#A3A3A3] uppercase tracking-wider">
                        <th class="p-4 w-24">Status</th>
                        <th class="p-4">Client / Contact</th>
                        <th class="p-4">Type de Projet</th>
                        <th class="p-4 w-44">Date Réception</th>
                        <th class="p-4 w-24 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php if (empty($demandes)): ?>
                        <tr>
                            <td colspan="5" class="p-12 text-center text-[#A3A3A3] uppercase tracking-widest italic">
                                [// AUCUNE DEMANDE INDEXÉE]
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($demandes as $demande): ?>
                            <tr class="hover:bg-white/[0.02] transition-colors <?= $demande['lu'] == 0 ? 'bg-[#00f719]/5' : '' ?>">
                                <td class="p-4 font-bold">
                                    <?php if ($demande['lu'] == 0): ?>
                                        <span class="text-black bg-[#00f719] px-2 py-0.5 rounded text-[10px] font-black tracking-wide uppercase animate-pulse">NEW</span>
                                    <?php else: ?>
                                        <span class="text-[#A3A3A3]/40 border border-white/10 px-2 py-0.5 rounded text-[10px] uppercase">READ</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4">
                                    <div class="text-[#F2F2F2] font-bold"><?= e($demande['nom']) ?></div>
                                    <div class="text-[#A3A3A3] text-[11px]"><?= e($demande['email']) ?></div>
                                </td>
                                <td class="p-4 text-[#00f719] font-medium">
                                    <?= e($demande['type_projet'] ?? 'Non spécifié') ?>
                                </td>
                                <td class="p-4 text-[#A3A3A3]">
                                    <?= date('Y-m-d H:i:s', strtotime($demande['date_demande'] ?? 'now')) ?>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="lire.php?id=<?= (int)$demande['id'] ?>" class="inline-block bg-white/5 border border-white/10 text-[#F2F2F2] hover:border-[#00f719] hover:text-[#00f719] px-3 py-1.5 transition-all uppercase tracking-wider text-[11px] font-bold">
                                        OPEN
                                    </a>
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