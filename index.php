<?php 
// 1. On charge les fonctions en tout premier
require_once('fonctions.php'); 
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>KINETIC_LOGIC // DEVELOPER_PORTFOLIO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style-index.css">
</head>

<body class="selection:bg-primary-container selection:text-on-primary min-h-screen flex flex-col custom-body">
    
<?php require('composants/navigation.php'); ?>

    <main class="flex-grow pt-24">
        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-6 py-20 relative overflow-hidden">
            <div class="glow-overlay absolute inset-0 pointer-events-none"></div>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-end">
                <div class="lg:col-span-8">
                    <span class="font-mono text-[#00f719] text-sm tracking-[0.3em] uppercase mb-4 block">ROOT@NETWORK:~#DEPLOY_SYSTEM()</span>
                    <h1 class="font-headline text-6xl md:text-8xl font-bold tracking-tighter leading-none mb-8 text-[#f1f1f1]">
                        INGÉNIERIE <span class="text-[#00f719]">LOGICIELLE</span> & ARCHITECTURE RÉSEAU.
                    </h1>
                    <p class="font-body text-xl text-[#baccb0] max-w-2xl leading-relaxed">
                        Développeur Full-Stack & Administrateur Réseau passionné par la création d'applications mobiles fluides et d'architectures serveurs robustes.
                    </p>
                </div>
                <div class="lg:col-span-4 flex justify-end">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-[#00f719]/20 blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                        <img alt="Professional Developer Portrait" class="profile-img" src="./img/Sow_site.jpeg" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Technical Stack -->
        <section class="bg-[#1b1b1b] py-32 mt-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-baseline mb-16 gap-4">
                    <h2 class="font-headline text-4xl font-bold tracking-tight text-[#f1f1f1] uppercase">Technical_Stack</h2>
                    <span class="font-mono text-xs text-[#00f719]/60 tracking-widest uppercase">Level: Senior_Architect</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-px bg-[#3b4b36]/10">
                    <div class="card-tech">
                        <span class="material-symbols-outlined text-[#00f719] mb-6 text-3xl">terminal</span>
                        <h3 class="font-headline text-xl font-bold mb-4 text-[#f1f1f1] uppercase">Backend_Systems</h3>
                        <p class="font-body text-[#baccb0] text-sm mb-8 leading-relaxed">Architecture de serveurs robustes et performants. Conception d'APIs sécurisées avec Node.js ou PHP, optimisées pour la gestion de flux de données massifs.</p>
                        <div class="flex gap-1">
                            <div class="bar full"></div><div class="bar full"></div><div class="bar full"></div><div class="bar full"></div><div class="bar empty"></div>
                        </div>
                    </div>
                    <div class="card-tech">
                        <span class="material-symbols-outlined text-[#00f719] mb-6 text-3xl">layers</span>
                        <h3 class="font-headline text-xl font-bold mb-4 text-[#f1f1f1] uppercase">Frontend_Logic</h3>
                        <p class="font-body text-[#baccb0] text-sm mb-8 leading-relaxed">Développement d'interfaces modernes et réactives. Création d'applications Web (React/Vue) et Mobiles natives ou hybrides.</p>
                        <div class="flex gap-1">
                            <div class="bar full"></div><div class="bar full"></div><div class="bar full"></div><div class="bar full"></div><div class="bar full"></div>
                        </div>
                    </div>
                    <div class="card-tech">
                        <span class="material-symbols-outlined text-[#00f719] mb-6 text-3xl">database</span>
                        <h3 class="font-headline text-xl font-bold mb-4 text-[#f1f1f1] uppercase">Data_Modeling</h3>
                        <p class="font-body text-[#baccb0] text-sm mb-8 leading-relaxed">Modélisation de bases de données relationnelles (MySQL, PostgreSQL) et NoSQL. Optimisation des requêtes pour garantir l'intégrité.</p>
                        <div class="flex gap-1">
                            <div class="bar full"></div><div class="bar full"></div><div class="bar full"></div><div class="bar empty"></div><div class="bar empty"></div>
                        </div>
                    </div>
                    <div class="card-tech">
                        <span class="material-symbols-outlined text-[#00f719] mb-6 text-3xl">cloud</span>
                        <h3 class="font-headline text-xl font-bold mb-4 text-[#f1f1f1] uppercase">Cloud_Infra</h3>
                        <p class="font-body text-[#baccb0] text-sm mb-8 leading-relaxed">Configuration d'infrastructures réseaux. Déploiement continu via Docker et gestion de serveurs Linux.</p>
                        <div class="flex gap-1">
                            <div class="bar full"></div><div class="bar full"></div><div class="bar full"></div><div class="bar full"></div><div class="bar empty"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Timeline -->
        <section class="max-w-7xl mx-auto px-6 py-32">
            <h2 class="font-headline text-4xl font-bold tracking-tight text-[#f1f1f1] uppercase mb-20">Exp_Timeline</h2>
            <div class="relative">
                <div class="absolute left-4 top-0 bottom-0 w-px bg-[#3b4b36]/20"></div>
                <div class="space-y-24">
                    <div class="relative pl-12 group">
                        <div class="timeline-dot"></div>
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <div class="md:col-span-4">
                                <span class="font-mono text-[#00f719] text-sm">2026 — PRESENT</span>
                                <h3 class="font-headline text-2xl font-bold text-[#f1f1f1] mt-2">Vice-Président & Student Leader</h3>
                                <p class="font-body text-[#c8c6c5] text-sm uppercase tracking-widest mt-1">AMICALE DES ETUDIANTS - ESTM</p>
                            </div>
                            <div class="md:col-span-8">
                                <p class="font-body text-[#baccb0] leading-relaxed text-lg">
                                    Direction stratégique de l'association étudiante. Gestion de projets événementiels et académiques, coordination d'équipes et médiation.
                                </p>
                                <div class="mt-6">
                                    <a href="./parcours.php" class="parcours-badge">Mon parcours</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="max-w-7xl mx-auto px-6 py-20 mb-20">
            <div class="cta-banner group">
                <div class="relative z-10">
                    <h2 class="font-headline text-4xl md:text-6xl font-black text-[#003a01] tracking-tighter leading-none mb-4 uppercase">DEPLOYONS VOTRE VISION.</h2>
                    <p class="font-body text-[#003a01]/80 text-xl max-w-md">Besoin d'une application mobile performante ou d'une infrastructure réseau sécurisée ? Discutons de votre projet.</p>
                </div>
                <div class="relative z-10 w-full md:w-auto">
                    <a href="./contact.php" class="cta-button">INIT_CONNECTION</a>
                </div>
                <div class="cta-vision-text">VISION</div>
            </div>
        </section>
    </main>

 <?php require('composants/pied_page.php'); ?>

    <!-- Navigation Mobile Automatisée -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full flex justify-around items-center h-16 px-4 mobile-nav-bg z-50">
        <?php
            // On récupère le nom de la page pour la classe "active"
            $current = basename($_SERVER['PHP_SELF']);
        ?>
        <a class="mobile-nav-item <?php if($current == 'index.php') echo 'active'; ?>" href="./index.php">
            <span class="material-symbols-outlined">home</span>
            <span class="font-headline text-[10px] uppercase">Home</span>
        </a>
        <a class="mobile-nav-item <?php if($current == 'project.php') echo 'active'; ?>" href="./project.php">
            <span class="material-symbols-outlined">reorder</span>
            <span class="font-headline text-[10px] uppercase">Projects</span>
        </a>
        <a class="mobile-nav-item <?php if($current == 'contact.php') echo 'active'; ?>" href="./contact.php">
            <span class="material-symbols-outlined">mail</span>
            <span class="font-headline text-[10px] uppercase">Contact</span>
        </a>
    </nav>
</body>
</html>