<?php
// admin/dashboard.php
require_once('../config/connexion.php'); 
require_once('../fonctions.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

verifierAuthentification();

try {
    $totalProjets = $pdo->query("SELECT COUNT(*) FROM projets")->fetchColumn();
    $totalContacts = $pdo->query("SELECT COUNT(*) FROM messages_contact WHERE lu = 0")->fetchColumn();
    $totalDemandes = $pdo->query("SELECT COUNT(*) FROM demandes_projet WHERE lu = 0")->fetchColumn();

    $dernieresVisites = $pdo->query("SELECT adresse_ip, page, date_visite FROM visites ORDER BY date_visite DESC LIMIT 5")->fetchAll();
    $dernieresDemandes = $pdo->query("SELECT id, type_projet, date_demande FROM demandes_projet ORDER BY date_demande DESC LIMIT 5")->fetchAll();

} catch (PDOException $e) {
    error_log("Erreur critique Dashboard: " . $e->getMessage());
    die("LOG_ERROR // SYSTEM_FAILURE");
}
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>CORE_SYSTEM // CONTROL_PANEL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" rel="stylesheet" />
    <style>
        body { 
            background-color: #0d1117; 
            color: #e2e2e2; 
            overflow-x: hidden;
            width: 100vw;
        }
        .font-headline { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', sans-serif; }
        .stat-box { background: rgba(22, 27, 34, 0.7); border: 1px solid #30363d; padding: 24px; position: relative; transition: all 0.2s ease-in-out; }
        .stat-box:hover { border-color: #00f719; background: rgba(22, 27, 34, 0.9); }
    </style>
</head>
<body class="font-sans antialiased selection:bg-[#00f719] selection:text-[#003a01]">

    <nav class="border-b border-[#30363d] bg-[#161b22]/80 backdrop-blur-md sticky top-0 z-50 px-4 md:px-8 py-4 flex justify-between items-center w-full">
        <div class="flex items-center gap-3">
            <div class="w-2.5 h-2.5 bg-[#00f719] rounded-full animate-ping"></div>
            <span class="font-headline font-bold text-lg tracking-tight hidden md:block">KINETIC_LOGIC <span class="text-[#00f719]">_CORE</span></span>
        </div>
        <div class="flex items-center gap-3 md:gap-6 font-mono text-[10px] md:text-xs">
            <span class="text-[#baccb0] truncate max-w-[100px]">OP: <span class="text-[#00f719]"><?= isset($_SESSION['admin_prenom']) ? e($_SESSION['admin_prenom']) : 'UNKNOWN' ?></span></span>
            <a href="deconnexion.php" class="text-red-400 hover:underline flex items-center gap-1 shrink-0">
                <span class="material-symbols-outlined text-sm">power_settings_new</span> DISCONNECT
            </a>
        </div>
    </nav>

    <main class="w-full max-w-7xl mx-auto px-4 md:px-8 py-12 flex flex-col gap-12">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-[#30363d]/40 pb-6 gap-4">
            <div class="flex flex-col gap-2">
                <span class="font-mono text-[#00f719] text-xs tracking-[0.3em] uppercase">SYSTEM_OVERVIEW</span>
                <h1 class="font-headline text-3xl md:text-4xl font-bold tracking-tight text-[#e2e2e2]">TABLEAU DE BORD</h1>
            </div>
            <div class="flex gap-2">
                <a href="messages/index.php" class="border border-[#00f719]/40 text-[#00f719] hover:bg-[#00f719]/10 font-mono font-bold px-3 py-2 transition-colors uppercase flex items-center gap-2 text-[10px] md:text-xs tracking-wider">
                    <span class="material-symbols-outlined text-sm">mail</span> INBOX
                </a>
                <a href="utilisateurs/index.php" class="border border-[#00f719]/40 text-[#00f719] hover:bg-[#00f719]/10 font-mono font-bold px-3 py-2 transition-colors uppercase flex items-center gap-2 text-[10px] md:text-xs tracking-wider">
                    <span class="material-symbols-outlined text-sm">manage_accounts</span> USERS
                </a>
            </div>
        </header>

        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="projets/index.php" class="block">
                <div class="stat-box h-full">
                    <p class="font-mono text-xs text-[#baccb0] tracking-wider uppercase">PUBLISHED_PROJECTS</p>
                    <p class="font-headline text-5xl font-bold text-[#e2e2e2] mt-4"><?= (int)$totalProjets ?></p>
                </div>
            </a>
            <a href="contacts.php" class="block">
                <div class="stat-box h-full">
                    <p class="font-mono text-xs text-[#baccb0] tracking-wider uppercase">TOTAL_CONTACTS</p>
                    <p class="font-headline text-5xl font-bold <?= $totalContacts > 0 ? 'text-[#00f719]' : 'text-[#e2e2e2]' ?> mt-4"><?= (int)$totalContacts ?></p>
                </div>
            </a>
            <a href="demandes/index.php" class="block">
                <div class="stat-box h-full">
                    <p class="font-mono text-xs text-[#baccb0] tracking-wider uppercase">TOTAL_PROPOSALS</p>
                    <p class="font-headline text-5xl font-bold <?= $totalDemandes > 0 ? 'text-[#00f719]' : 'text-[#e2e2e2]' ?> mt-4"><?= (int)$totalDemandes ?></p>
                </div>
            </a>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-[#161b22]/40 border border-[#30363d] p-6 overflow-hidden">
                <h3 class="font-headline text-lg font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#00f719]">history</span> LOGS_SYSTEM_TRAFFIC
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full font-mono text-xs text-left min-w-[400px]">
                        <thead>
                            <tr class="border-b border-[#30363d] text-[#baccb0]">
                                <th class="pb-3">IP</th>
                                <th class="pb-3">PAGE</th>
                                <th class="pb-3 text-right">DATE</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#30363d]/40">
                            <?php if(!empty($dernieresVisites)): foreach($dernieresVisites as $visite): ?>
                                <tr>
                                    <td class="py-3 text-[#00f719] truncate"><?= e($visite['adresse_ip']) ?></td>
                                    <td class="py-3 text-[#e2e2e2] truncate"><?= e($visite['page']) ?></td>
                                    <td class="py-3 text-right text-[#baccb0]"><?= e($visite['date_visite']) ?></td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="3" class="py-4 text-center">Aucun log.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-[#161b22]/40 border border-[#30363d] p-6 overflow-hidden">
                <h3 class="font-headline text-lg font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#00f719]">assignment</span> PROPOSALS
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full font-mono text-xs text-left min-w-[400px]">
                        <thead>
                            <tr class="border-b border-[#30363d] text-[#baccb0]">
                                <th class="pb-3">ID</th>
                                <th class="pb-3">TYPE</th>
                                <th class="pb-3 text-right">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#30363d]/40">
                            <?php if(!empty($dernieresDemandes)): foreach($dernieresDemandes as $demande): ?>
                                <tr>
                                    <td class="py-3 text-[#00f719]">#<?= sprintf("%02d", $demande['id']) ?></td>
                                    <td class="py-3 text-[#e2e2e2] truncate"><?= e($demande['type_projet']) ?></td>
                                    <td class="py-3 text-right">
                                        <a href="demandes/lire.php?id=<?= (int)$demande['id'] ?>" class="border border-[#30363d] px-2 py-1 hover:border-[#00f719]">OPEN</a>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="3" class="py-4 text-center">Aucune demande.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="mt-4 p-6 border border-dashed border-[#00f719]/30 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h4 class="font-headline font-bold text-lg text-[#e2e2e2]">ACCÈS AUX ARCHIVES DU RÉPERTOIRE</h4>
                <p class="font-mono text-xs text-[#baccb0] mt-1">Éditez, ajoutez ou archivez les projets apparaissant sur la vitrine publique.</p>
            </div>
            <a href="projets/index.php" class="bg-[#00f719] text-[#0d1117] font-mono font-bold text-xs px-6 py-3 tracking-wider hover:bg-[#00f719]/80 transition-colors uppercase shrink-0">
                GÉRER_LES_PROJETS
            </a>
        </section>
    </main>
</body>
</html>