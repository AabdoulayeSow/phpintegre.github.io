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

    <header class="header-main">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary-neon">precision_manufacturing</span>
            <h1 class="logo-text">ROBOTIQUE ET EXCELLENCE</h1>
        </div>
        <button class="nav-toggle">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </header>

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
                    <img alt="Portrait professionnel" class="portrait-img" src="./img/leader.jpg" />
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
                <div class="project-card guinea-glow">
                    <div class="project-header">
                        <span class="material-symbols-outlined project-icon">delete_sweep</span>
                        <span class="tag-iot">IOT / ESP32</span>
                    </div>
                    <h4 class="project-title">Smart Bin Architecture</h4>
                    <p class="project-desc">Conception d'une poubelle intelligente basée sur ESP32. Focus sur l'optimisation des réseaux et l'innovation urbaine.</p>
                    <div class="project-footer">
                        <span>Networking</span>
                        <span>Real-time</span>
                    </div>
                </div>
                <div class="project-card guinea-glow">
                    <div class="project-header">
                        <span class="material-symbols-outlined project-icon">database</span>
                        <span class="tag-iot">C / SQL</span>
                    </div>
                    <h4 class="project-title">Gestionnaire de Contacts</h4>
                    <p class="project-desc">Système robuste de gestion de données. Maîtrise critique de l'allocation mémoire dynamique et des structures complexes.</p>
                    <div class="project-footer">
                        <span>Low-level</span>
                        <span>Memory Mgmt</span>
                    </div>
                </div>
                <div class="project-card-full guinea-glow group">
                    <div class="flex-project">
                        <div class="project-info">
                            <div class="project-header">
                                <span class="material-symbols-outlined project-icon">apartment</span>
                                <span class="tag-iot">Web Platform</span>
                            </div>
                            <h4 class="project-title">LocaSénégal</h4>
                            <p class="project-desc">Plateforme immobilière disruptive. Application du "product sense" pour répondre aux défis du marché locatif régional.</p>
                        </div>
                        <div class="project-preview">
                            <img alt="LocaSénégal" src="./img/pc.jpeg" class="preview-img" />
                        </div>
                    </div>
                </div>
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
                <a class="btn-cv group" href="./ingredient/CV.pdf">
                    <span class="material-symbols-outlined">description</span>
                    Télécharger mon CV (PDF)
                    <div class="btn-overlay"></div>
                </a>
            </div>
        </section>
    </main>

    <footer class="footer-main">
        <div class="footer-logo">PRECISION ENGINEER</div>
        <div class="footer-links">
            <a href="https://linkedin.com/in/...">LinkedIn</a>
            <a href="https://t.me/...">Télégramme</a>
            <a href="https://github.com/...">Github</a>
        </div>
        <div class="footer-copy">© 2024 PRECISION ENGINEER.</div>
    </footer>
</body>
</html>