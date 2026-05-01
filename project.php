<?php 
// 1. Initialisation
require_once('fonctions.php'); 

// 2. Définition du tableau de projets 
$projets = [
    [
        'id'           => '01_',
        'titre'        => 'SMART_BIN_v1.0',
        'description'  => 'Système de gestion intelligente des déchets basé sur l\'IoT. Utilisation d\'un microcontrôleur ESP32 pour la détection de niveau en temps réel.',
        'image'        => './img/Esp32.jpeg',
        'liens'        => [
            ['label' => 'Consulter le code', 'url' => './arduino.php#hero'],
            ['label' => 'Schéma de conception', 'url' => './arduino.php#process'],
            ['label' => 'Voir la Démo', 'url' => './arduino.php#result']
        ],
        'status'       => 'ACTIVE_DEPLOYMENT'
    ],
    [
        'id'           => '02_',
        'titre'        => 'LOCASÉNÉGAL_APP',
        'description'  => 'Plateforme de mise en relation immobilière dédiée au marché sénégalais. Conception d\'une interface intuitive pour la recherche de logements.',
        'image'        => './img/LocaSénégal.jpeg',
        'liens'        => [
            ['label' => 'Explorez', 'url' => './LocaSénégal.php#explorer'],
            ['label' => 'Inventaire', 'url' => './LocaSénégal.php#inventaire']
        ],
        'status'       => ''
    ],
    [
        'id'           => '03_',
        'titre'        => 'CONTACT_MANAGER_PRO',
        'description'  => 'Application de gestion de répertoire téléphonique optimisée. Implémentation de fonctionnalités de recherche avancée et de synchronisation locale.',
        'image'        => './img/Contact.jpeg',
        'liens'        => [
            ['label' => 'Fonctionnalités', 'url' => './contactpro.php#foctionalité'],
            ['label' => 'Algorithme', 'url' => './contactpro.php#technique'],
            ['label' => 'Base SQL', 'url' => './contactpro.php#sql']
        ],
        'status'       => 'ARCHIVED'
    ]
];

// 3. Logique de filtrage 
$mot_cle   = nettoyer($_GET['q'] ?? '');
$resultats = [];

if ($mot_cle !== '') {
    foreach ($projets as $projet) {
        // Recherche dans le titre OU la description (insensible à la casse)
        if (stripos($projet['titre'], $mot_cle) !== false || 
            stripos($projet['description'], $mot_cle) !== false) {
            $resultats[] = $projet;
        }
    }
} else {
    $resultats = $projets; // Pas de recherche, on affiche tout
}
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>KINETIC_LOGIC // PROJECT_ARCHIVE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style-project.css">
</head>

<body class="custom-body selection:bg-[#00f719] selection:text-[#003a01]">
    
    <?php require('composants/navigation.php'); ?>

    <main class="pt-32 pb-24 px-6 max-w-7xl mx-auto">
        <section class="mb-20">
            <div class="flex flex-col gap-6 max-w-2xl">
                <span class="font-headline text-[#00f719] text-xs tracking-[0.2em] uppercase">REPOSITORY_ARCHIVE</span>
                <h1 class="font-headline text-5xl md:text-7xl font-bold tracking-tighter text-[#e2e2e2] leading-none">
                    SYSTEMES <br />
                    <span class="text-[#00f719]">APPLICATIONS.</span>
                </h1>
                
                <!-- Formulaire de recherche (Exigence 5.3) -->
                <div class="relative mt-8 group">
                    <div class="search-glow"></div>
                    <form action="project.php" method="GET" class="search-container">
                        <span class="material-symbols-outlined ml-4 text-[#baccb0]">search</span>
                        <input name="q" class="search-input" placeholder="QUERY_BY_KEYWORD..." type="text" value="<?= htmlspecialchars($mot_cle) ?>" />
                        <button type="submit" class="search-btn">EXECUTE</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Liste des Projets Dynamique (Exigence 6) -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 md:gap-x-16 md:gap-y-24">
            
            <?php if (!empty($resultats)): ?>
                <?php foreach ($resultats as $index => $projet) : ?>
                    <article class="group relative flex flex-col gap-6 <?= ($index % 2 != 0) ? 'md:mt-12' : '' ?>">
                        <div class="project-card-img">
                            <img alt="<?= htmlspecialchars($projet['titre']) ?>" class="img-zoom grayscale group-hover:grayscale-0" src="<?= htmlspecialchars($projet['image']) ?>" />
                            <div class="img-overlay"></div>
                            
                            <?php if ($projet['status'] === 'ACTIVE_DEPLOYMENT'): ?>
                                <div class="badge-active">ACTIVE_DEPLOYMENT</div>
                            <?php elseif ($projet['status'] === 'ARCHIVED'): ?>
                                <div class="badge-archived">ARCHIVED</div>
                            <?php endif; ?>
                        </div>

                        <div class="flex flex-col gap-3">
                            <div class="flex items-center gap-4">
                                <span class="font-headline text-[#00f719] text-[10px] font-bold tracking-widest"><?= $projet['id'] ?></span>
                                <h3 class="font-headline text-2xl font-bold tracking-tight text-[#e2e2e2] group-hover:text-[#00f719] transition-colors">
                                    <?= htmlspecialchars($projet['titre']) ?>
                                </h3>
                            </div>
                            <p class="text-[#baccb0] text-sm leading-relaxed max-w-[90%]">
                                <?= htmlspecialchars($projet['description']) ?>
                            </p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <?php foreach ($projet['liens'] as $lien): ?>
                                    <a href="<?= $lien['url'] ?>" class="tech-tag"><?= htmlspecialchars($lien['label']) ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Message si aucun résultat -->
                <div class="col-span-full py-20 border border-dashed border-[#00f719]/30 text-center">
                    <p class="font-mono text-[#00f719]">NO_PROJECTS_FOUND_FOR_QUERY: "<?= htmlspecialchars($mot_cle) ?>"</p>
                    <a href="project.php" class="text-[#baccb0] text-xs underline mt-4 block">Reset search parameters</a>
                </div>
            <?php endif; ?>

        </section>

        <!-- Stats Section (statique car non demandée en dynamique) -->
        <section class="mt-40 grid grid-cols-1 md:grid-cols-2 gap-12 stats-banner relative overflow-hidden">
            <div class="stats-glow-circle"></div>
            <div class="relative z-10 flex flex-col gap-8">
                <span class="font-headline text-[#00f719] text-[10px] tracking-[0.4em] uppercase">System Performance</span>
                <h2 class="font-headline text-4xl font-bold tracking-tight text-[#e2e2e2]">BUILT_FOR_STABILITY</h2>
                <p class="text-[#baccb0] leading-relaxed font-body">
                    Mes processus de conception privilégient la fiabilité des systèmes et l'optimisation des performances.
                </p>
                <div class="flex gap-4">
                    <button class="github-btn">VIEW_GITHUB_REPOSITORY</button>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="stat-box"><span class="stat-value">99.9%</span><span class="stat-label">AVAILABILITY</span></div>
                <div class="stat-box"><span class="stat-value">20ms</span><span class="stat-label">LATENCY</span></div>
                <div class="stat-box"><span class="stat-value">50+</span><span class="stat-label">REPOS</span></div>
                <div class="stat-box"><span class="stat-value">100%</span><span class="stat-label">SECURE</span></div>
            </div>
        </section>
    </main>

    <?php require('composants/pied_page.php'); ?>
</body>
</html>