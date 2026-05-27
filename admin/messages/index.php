<?php
// admin/messages/index.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../config/connexion.php'); 
require_once('../../fonctions.php');

verifierAuthentification();

try {
    // Récupération des messages, triés par date décroissante
    $stmt = $pdo->query("SELECT * FROM messages_contact ORDER BY date_envoi DESC");
    $messages = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Erreur Lecture Messages: " . $e->getMessage());
    die("LOG_ERROR // CRITICAL_MAIL_FETCH_FAILURE");
}
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CORE_SYSTEM // INBOX_TERMINAL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" rel="stylesheet" />
    <style>
        body { 
            background-color: #0d1117; 
            color: #e2e2e2;
            overflow-x: hidden; /* Empêche le défilement horizontal de toute la page */
        }
        .font-headline { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', sans-serif; }
        dialog::backdrop { background: rgba(0, 0, 0, 0.8); }
    </style>
</head>
<body class="font-sans antialiased">

    <nav class="border-b border-[#30363d] bg-[#161b22]/80 backdrop-blur-md sticky top-0 z-50 px-8 py-4">
        <a href="../dashboard.php" class="text-[#baccb0] hover:text-[#00f719] font-mono text-xs flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">matrix</span> RETURN_TO_CORE
        </a>
    </nav>

    <main class="w-full max-w-6xl mx-auto px-8 py-12">
        <header class="mb-8">
            <span class="font-mono text-[#00f719] text-xs tracking-[0.3em] uppercase">COMMUNICATIONS_NODE</span>
            <h1 class="font-headline text-4xl font-bold text-[#e2e2e2]">INBOX_MESSAGES</h1>
        </header>

        <div class="w-full max-w-full border border-[#30363d] bg-[#161b22]/40 overflow-x-auto">
            <table class="w-full text-left font-mono text-xs min-w-[700px]">
                <thead>
                    <tr class="border-b border-[#30363d] bg-black/20 text-[#baccb0] uppercase">
                        <th class="p-4">Statut</th>
                        <th class="p-4">Expéditeur</th>
                        <th class="p-4">Date</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#30363d]/40">
                    <?php foreach ($messages as $msg): ?>
                        <tr class="<?= $msg['lu'] == 0 ? 'bg-[#00f719]/5' : '' ?> hover:bg-white/[0.02]">
                            <td class="p-4">
                                <?php if($msg['lu'] == 0): ?>
                                    <span class="text-[#00f719] font-bold">[UNREAD]</span>
                                <?php else: ?>
                                    <span class="text-[#baccb0]/50">[READ]</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 font-bold">
                                <?= htmlspecialchars($msg['nom'], ENT_QUOTES, 'UTF-8') ?><br>
                                <span class="text-[#baccb0] font-normal"><?= htmlspecialchars($msg['email'], ENT_QUOTES, 'UTF-8') ?></span>
                            </td>
                            <td class="p-4 text-[#baccb0]"><?= htmlspecialchars($msg['date_envoi'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="p-4 text-right">
                                <button 
                                    onclick="document.getElementById('modal-<?= $msg['id'] ?>').showModal()" 
                                    class="border border-[#30363d] px-3 py-1 hover:border-[#00f719] transition-colors">
                                    VIEW_RAW
                                </button>

                                <dialog id="modal-<?= $msg['id'] ?>" class="bg-[#0d1117] border border-[#30363d] text-[#e2e2e2] p-6 max-w-lg w-full rounded-lg shadow-2xl">
                                    <h2 class="font-headline text-xl mb-4 text-[#00f719]">MESSAGE_DATA</h2>
                                    <div class="font-mono text-sm mb-6 p-4 bg-black/30 border border-[#30363d] whitespace-pre-line">
                                        <?= htmlspecialchars($msg['message'], ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                    <button onclick="this.closest('dialog').close()" class="border border-[#30363d] px-4 py-2 hover:bg-[#00f719] hover:text-black transition-colors">
                                        CLOSE_TERMINAL
                                    </button>
                                </dialog>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>