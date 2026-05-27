<?php 
// 1. Inclusion des fichiers de configuration et fonctions
require_once('config/connexion.php'); 
require_once('fonctions.php'); 

// 2. EXIGENCE PROF (Section 4.1) : Enregistrement automatique de la visite
enregistrerVisite($pdo, 'Parcours (parcours.php)');

try {
    // 3. EXIGENCE PROF (Section 5.3) : Récupération des projets depuis la base de données
    // On trie par date de création décroissante comme demandé
    $stmt = $pdo->prepare("SELECT * FROM projets ORDER BY date_creation DESC");
    $stmt->execute();
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erreur de récupération des projets : " . $e->getMessage());
    $projets = []; // En cas d'erreur, on initialise un tableau vide pour ne pas faire crash la page
}
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Profil | Precision Engineer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style-parcours.css">
</head>
<body class="bg-surface text-on-surface font-body selection:bg-primary-container selection:text-on-primary">

    <?php require('composants/navigation.php'); ?>

    <main class="main-content">
        <section class="space-y-12">
            <div class="space-y-4">
                <span class="badge-label">Genèse & Leadership</span>
                <h2 class="hero-title">Mon Parcours.</h2>
            </div>
            <div class="grid-bio">
                <div class="bio-text-container">
                    <p class="hero-intro">
                        Enraciné dans la terre de Guinée, mon parcours est une quête de <span class="text-highlight italic">précision et d'impact</span>.
                    </p>
                    <div class="bio-details">
                        <p>
                            De l'effervescence de la Guinée aux amphithéâtres académiques, mon engagement a toujours été marqué par le leadership. En tant que <span class="text-primary-neon">Président des bacheliers scientifiques</span>, j'ai appris à orchestrer des visions collectives.
                        </p>
                        <p>
                            Aujourd'hui, en tant que <span class="text-primary-neon">Vice-Président de la Faculté</span>, je fusionne cette fibre politique avec une rigueur technique, transformant la gouvernance étudiante en un laboratoire d'excellence opérationnelle.
                        </p>
                    </div>
                </div>
                <div class="portrait-container group">
                    <img alt="Portrait professionnel" class="portrait-img" src="<?= e('./image/leader.jpg') ?>" />
                </div>
            </div>
        </section>

        <section class="space-y-12">
            <div class="flex justify-between items-end">
                <div class="space-y-2">
                    <span class="badge-label">Engineering</span>
                    <h3 class="section-heading">Réalisations Techniques</h3>
                </div>
                <span class="version-tag">Archive_v2.0</span>
            </div>
            
            <div class="grid-projects">
                <?php if (!empty($projets)): ?>
                    <?php foreach ($projets as $projet): ?>
                        <div class="project-card guinea-glow">
                            <div class="project-header">
                                <span class="material-symbols-outlined project-icon">developer_board</span>
                                <span class="tag-iot"><?= e($projet['technologies']) ?></span>
                            </div>
                            <h4 class="project-title"><?= e($projet['titre']) ?></h4>
                            <p class="project-desc"><?= e($projet['description']) ?></p>
                            
                            <?php if (!empty($projet['image'])): ?>
                                <div class="my-3 overflow-hidden rounded">
                                    <img src="<?= e('./images/projets/' . $projet['image']) ?>" alt="<?= e($projet['titre']) ?>" class="w-full h-32 object-cover">
                                </div>
                            <?php endif; ?>

                            <div class="project-footer">
                                <?php if (!empty($projet['lien'])): ?>
                                    <a href="<?= e($projet['lien']) ?>" target="_blank" class="text-primary-neon hover:underline flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">link</span> Voir le projet
                                    </a>
                                <?php else: ?>
                                    <span>Production</span>
                                    <span>Active</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-full p-8 bg-[#1b1b1b] text-center font-mono text-xs text-gray-500 border border-dashed border-gray-800">
                        ERR_NO_DATA: AUCUN_PROJET_ENREGISTRE_DANS_LE_SYSTEME
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="grid-skills">
            <div>
                <div class="skills-header">
                    <h2 class="skills-title">Core Systems</h2>
                    <div class="divider"></div>
                </div>
                <div class="space-y-8">
                    <div class="skill-item">
                        <div class="skill-info">
                            <span class="skill-name">C / C++ Infrastructure</span>
                            <span class="skill-value">90%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill" style="width: 90%;">
                                <div class="progress-glow"></div>
                            </div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <div class="skill-info">
                            <span class="skill-name">Java & JS Development</span>
                            <span class="skill-value">85%</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill" style="width: 85%;"></div>
                        </div>
                    </div>
                    <div class="pill-container">
                        <span class="skill-pill">Word & Excel (Expert)</span>
                        <span class="skill-pill">Canva Design</span>
                        <span class="skill-pill">SQL Management</span>
                    </div>
                </div>
            </div>

            <div>
                <div class="skills-header">
                    <h2 class="skills-title">Language Protocols</h2>
                    <div class="divider"></div>
                </div>
                <div class="grid-langs">
                    <div class="lang-card border-primary">
                        <h4 class="lang-tag text-primary">Native</h4>
                        <p class="lang-name">Français</p>
                    </div>
                    <div class="lang-card border-secondary">
                        <h4 class="lang-tag text-secondary">Fluid</h4>
                        <p class="lang-name">Anglais</p>
                    </div>
                    <div class="lang-card border-accent">
                        <h4 class="lang-tag text-accent">Courant</h4>
                        <p class="lang-name">Arabe</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <h3 class="cta-heading">Prêt pour l'excellence.</h3>
            <div class="flex justify-center">
                <a class="btn-cv group" href="<?= e('./ingredient/CV.pdf') ?>">
                    <span class="material-symbols-outlined">description</span>
                    Télécharger mon CV (PDF)
                    <div class="btn-overlay"></div>
                </a>
            </div>
        </section>
    </main>

    <?php require('composants/pied_page.php'); ?>
</body> 
</html>