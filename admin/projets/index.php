<?php
// admin/projets/index.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../config/connexion.php'); 
require_once('../../fonctions.php');

verifierAuthentification();

try {
    // REQUÊTE ALIGNÉE SUR LA STRUCTURE DE TON PROF : id, titre, image, lien, date_creation
    $stmt = $pdo->query("SELECT id, titre, image, lien, date_creation FROM projets ORDER BY id DESC");
    $projets = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Erreur Listing Projets: " . $e->getMessage());
    die("LOG_ERROR // SYSTEM_FAILURE // Impossible de charger le répertoire des projets.");
}
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CORE_SYSTEM // PROJECTS_DIRECTORY</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" rel="stylesheet" />
    <style>
        body { background-color: #0d1117; color: #e2e2e2; }
        .font-headline { font-family: 'Space Grotesk', sans-serif; }
        .font-mono { font-family: 'IBM Plex Mono', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased selection:bg-[#00f719] selection:text-[#003a01]">

    <nav class="border-b border-[#30363d] bg-[#161b22]/80 backdrop-blur-md sticky top-0 z-50 px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <a href="../dashboard.php" class="flex items-center gap-2 text-[#baccb0] hover:text-[#00f719] font-mono text-xs transition-colors">
                <span class="material-symbols-outlined text-sm">arrow_back</span> RETURN_TO_CORE
            </a>
        </div>
        <div class="flex items-center gap-6 font-mono text-xs">
            <span class="text-[#baccb0]">SYS_OPERATOR: <span class="text-[#00f719]"><?= isset($_SESSION['admin_prenom']) ? e($_SESSION['admin_prenom']) : 'UNKNOWN' ?></span></span>
            <a href="../deconnexion.php" class="text-red-400 hover:underline flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">power_settings_new</span> DISCONNECT
            </a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-8 py-12 flex flex-col gap-8">
        
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-[#30363d] pb-6">
            <div class="flex flex-col gap-2">
                <span class="font-mono text-[#00f719] text-xs tracking-[0.3em] uppercase">ARCHIVE_MANAGEMENT</span>
                <h1 class="font-headline text-4xl font-bold tracking-tight text-[#e2e2e2]">RÉPERTOIRE DES PROJETS</h1>
            </div>
            <a href="ajouter.php" class="bg-[#00f719] text-[#0d1117] font-mono font-bold text-xs px-6 py-3 tracking-wider hover:bg-[#00f719]/80 transition-colors uppercase flex items-center gap-2">
                <span class="material-symbols-outlined text-sm font-bold">add</span> NEW_PROJECT
            </a>
        </header>

        <div class="bg-[#161b22]/40 border border-[#30363d] p-6 relative">
            <div class="overflow-x-auto">
                <table class="w-full font-mono text-xs text-left">
                    <thead>
                        <tr class="border-b border-[#30363d] text-[#baccb0]">
                            <th class="pb-4 w-20">PREVIEW</th>
                            <th class="pb-4">PROJECT_TITLE</th>
                            <th class="pb-4">PROJECT_LINK</th>
                            <th class="pb-4">TIMESTAMP</th>
                            <th class="pb-4 text-right">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#30363d]/40">
                        <?php if(!empty($projets)): foreach($projets as $projet): ?>
                            <tr class="hover:bg-[#161b22]/30 transition-colors">
                                <td class="py-4">
                                    <?php if(!empty($projet['image'])): ?>
                                        <img src="../../images/projets/<?= e($projet['image']) ?>" alt="Aperçu" class="w-12 h-12 object-cover border border-[#30363d]">
                                    <?php else: ?>
                                        <div class="w-12 h-12 bg-[#0d1117] border border-[#30363d] flex items-center justify-center text-[#baccb0]/30">
                                            <span class="material-symbols-outlined text-lg">image</span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 font-bold text-[#e2e2e2] text-sm"><?= e($projet['titre']) ?></td>
                                <td class="py-4 text-[#baccb0]">
                                    <?php if(!empty($projet['lien'])): ?>
                                        <a href="<?= e($projet['lien']) ?>" target="_blank" class="text-[#00f719] hover:underline flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">link</span> External_Link
                                        </a>
                                    <?php else: ?>
                                        <span class="text-[#baccb0]/40">// NULL</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 text-[#baccb0]"><?= e($projet['date_creation']) ?></td>
                                <td class="py-4 text-right">
                                    <div class="flex justify-end gap-3">
                                        <a href="modifier.php?id=<?= (int)$projet['id'] ?>" class="border border-[#30363d] text-[#e2e2e2] hover:border-[#00f719] hover:text-[#00f719] px-3 py-1.5 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-xs">edit</span> EDIT
                                        </a>
                                        <a href="supprimer.php?id=<?= (int)$projet['id'] ?>" onclick="return confirm('Confirmer la destruction définitive de ce projet ?');" class="border border-red-950 text-red-400 hover:bg-red-950/30 px-3 py-1.5 transition-colors flex items-center gap-1">
                                            <span class="material-symbols-outlined text-xs">delete</span> DELETE
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr>
                                <td colspan="5" class="py-8 text-[#baccb0]/40 text-center uppercase tracking-wider">
                                    Aucun projet indexé dans la base de données.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>