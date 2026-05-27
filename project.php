<?php 
// 1. On charge la connexion à la base de données et les fonctions de sécurité en premier
require_once('config/connexion.php'); 
require_once('fonctions.php'); 

// 2. EXIGENCE PROF : Journalisation automatique de la visite sur cette page
enregistrerVisite($pdo, 'Projets (project.php)');

// 3. Logique de filtrage et recherche par mot-clé sur MySQL via Requête Préparée
$mot_cle = isset($_GET['q']) ? trim($_GET['q']) : '';
$resultats = [];

try {
    if ($mot_cle !== '') {
        $sql = "SELECT * FROM projets WHERE titre LIKE :mot_cle OR description LIKE :mot_cle ORDER BY date_creation DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['mot_cle' => '%' . $mot_cle . '%']);
        $resultats = $stmt->fetchAll();
    } else {
        $requeteAll = $pdo->query("SELECT * FROM projets ORDER BY date_creation DESC");
        $resultats = $requeteAll->fetchAll();
    }
} catch (PDOException $e) {
    echo "<div style='background:#ff0000; color:#fff; padding:20px; font-family:monospace; position:fixed; top:0; left:0; width:100%; z-index:9999;'>";
    echo "<strong>Erreur SQL détectée :</strong> " . $e->getMessage();
    echo "</div>";
    $resultats = []; 
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
    <style>
        .project-section-wrapper, .stats-banner-wrapper {
            transition: opacity 1.2s ease, transform 1s ease;
            opacity: 0;
            transform: translateY(40px);
        }
        .project-section-wrapper.visible, .stats-banner-wrapper.visible { opacity: 1; transform: translateY(0); }
        
        .project-card, .stat-box {
            transition: transform 0.6s ease, box-shadow 0.6s ease, opacity 0.8s ease;
            opacity: 0;
            transform: translateY(20px);
            border: 1px solid #30363d;
            background: rgba(22, 27, 34, 0.4);
        }
        .project-section-wrapper.visible .project-card, .stats-banner-wrapper.visible .stat-box { opacity: 1; transform: translateY(0); }
        
        .project-card:hover, .stat-box:hover { 
            border-color: #00f719; 
            box-shadow: 0 10px 40px -10px rgba(0, 247, 25, 0.3); 
            transform: translateY(-5px); 
        }

        .project-section-wrapper.visible .project-card:nth-child(3n+1) { transition-delay: 0.1s; }
        .project-section-wrapper.visible .project-card:nth-child(3n+2) { transition-delay: 0.2s; }
        .project-section-wrapper.visible .project-card:nth-child(3n+3) { transition-delay: 0.3s; }
    </style>
</head>

<body class="custom-body selection:bg-[#00f719] selection:text-[#003a01]">
    
<?php require('composants/navigation.php'); ?>
    <main class="pt-32 pb-24 px-6 md:px-12 max-w-7xl mx-auto">
        <section class="mb-20 pt-10">
            <div class="flex flex-col gap-6 max-w-2xl">
                <span class="font-headline text-[#00f719] text-xs tracking-[0.2em] uppercase">REPOSITORY_ARCHIVE</span>
                <h1 class="font-headline text-5xl md:text-7xl font-bold tracking-tighter text-[#e2e2e2] leading-none">
                    SYSTEMES <br />
                    <span class="text-[#00f719]">APPLICATIONS.</span>
                </h1>
                
                <div class="relative mt-8 group">
                    <div class="search-glow"></div>
                    <form action="project.php" method="GET" class="search-container">
                        <span class="material-symbols-outlined ml-4 text-[#baccb0]">search</span>
                        <input name="q" class="search-input" placeholder="QUERY_BY_KEYWORD..." type="text" value="<?= e($mot_cle) ?>" />
                        <button type="submit" class="search-btn">EXECUTE</button>
                    </form>
                </div>
            </div>
        </section>

        <section id="project-section" class="space-y-12 project-section-wrapper pt-10">
            <div class="flex justify-between items-end px-2">
                <div class="space-y-2">
                    <span class="badge-label">Engineering</span>
                </div>
                <span class="version-tag">Archive_v2.0</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-2">
                <?php if (!empty($resultats)): ?>
                    <?php foreach ($resultats as $projet): ?>
                        <div class="project-card guinea-glow flex flex-col h-full p-6">
                            <div class="project-header flex items-center justify-between mb-4">
                                <span class="material-symbols-outlined project-icon text-[#00f719]">developer_board</span>
                                <span class="tag-iot bg-[#00f719]/10 text-[#00f719] px-2 py-1 rounded text-[10px]"><?= e($projet['technologies']) ?></span>
                            </div>
                            <h4 class="project-title text-xl font-bold text-[#e2e2e2] mb-2"><?= e($projet['titre']) ?></h4>
                            <p class="project-desc text-[#baccb0] text-sm mb-4 leading-relaxed flex-grow"><?= e($projet['description']) ?></p>
                            
                            <?php if (!empty($projet['image'])): ?>
                                <div class="my-3 overflow-hidden rounded border border-[#30363d]">
                                    <img src="<?= e('./images/projets/' . $projet['image']) ?>" alt="<?= e($projet['titre']) ?>" class="w-full h-64 object-cover transition-transform duration-500 hover:scale-105">
                                </div>
                            <?php endif; ?>

                            <div class="project-footer mt-auto pt-4">
                                <?php if (!empty($projet['lien'])): ?>
                                    <a href="<?= e($projet['lien']) ?>" target="_blank" class="text-[#00f719] hover:underline flex items-center gap-1 font-bold text-xs">
                                        <span class="material-symbols-outlined text-sm">link</span> Voir le projet
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-500 text-xs italic">En attente de déploiement</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full p-8 bg-[#161b22] text-center font-mono text-xs text-gray-500 border border-dashed border-[#30363d]">
                        <?php if ($mot_cle !== ''): ?>
                            ERR_SEARCH: AUCUN_PROJET_NE_CORRESPOND_A_VOTRE_RECHERCHE "<?= e($mot_cle) ?>"
                        <?php else: ?>
                            ERR_NO_DATA: AUCUN_PROJET_ENREGISTRE_DANS_LE_SYSTEME
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section id="stats-section" class="mt-40 grid grid-cols-1 md:grid-cols-2 gap-12 stats-banner relative overflow-hidden px-2 stats-banner-wrapper">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const projectSection = document.getElementById('project-section');
            const statsSection = document.getElementById('stats-section');
            const observerOptions = { threshold: 0.15 };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('visible');
                });
            }, observerOptions);

            if (projectSection) observer.observe(projectSection);
            if (statsSection) observer.observe(statsSection);
        });
    </script>
</body>
</html>