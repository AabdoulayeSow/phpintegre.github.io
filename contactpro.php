<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>ContactC-SQL | Système de Gestion de Contacts</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style-contactpro.css" />
</head>
<body class="selection-custom">
    
    <nav class="navbar">
        <div class="nav-logo">ContactC-SQL</div>
        <div class="nav-links">
            <a class="nav-link active" href="#hero">Projet</a>
            <a class="nav-link" href="#features">Fonctionnalités</a>
            <a class="nav-link" href="#code">Algorithmes</a>
            <a class="nav-link" href="#database">Schéma SQL</a>
        </div>
        <div class="nav-actions">
            <button class="material-symbols-outlined icon-btn">terminal</button>
            <a href="./index.php">
                <button class="btn-primary">Révenir à l'accueil</button>
            </a>
        </div>
    </nav>

    <section class="hero" id="hero">
        <div class="hero-grid-bg"></div>
        <div class="container hero-content">
            <div class="hero-text">
                <div class="status-bar">
                    <div class="data-pulse"></div>
                    <span class="status-label">Status: Système Opérationnel</span>
                </div>
                <h1 class="hero-title"> Gestionnaire de <span class="neon-glow">Contacts</span> </h1>
                <p class="hero-description">
                    Une application robuste développée en C avec persistance SQL. Gérez vos données avec la rapidité du langage système et la fiabilité des bases de données relationnelles.
                </p>
                <div class="hero-btns">
                    <a href="./ingredient/repertoire_formatte.pdf" class="btn-primary btn-large">
                        <span class="material-symbols-outlined">code</span> Voir les Sources
                    </a>
                    <button class="btn-outline"> Analyse CRUD </button>
                    <a href="./ingredient/captures.pdf" class="btn-outline"> Captures </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="image-card">
                    <img class="hero-img" alt="code C sur terminal" src="./img/projet.jpeg" />
                    <div class="image-overlay"></div>
                    <div class="console-box">
                        <p class="console-header">Console Log</p>
                        <div class="console-text">
                            <p>> Connexion sqlite3_open...</p>
                            <p>> Table 'contacts' chargée avec succès.</p>
                            <p>> Allocation mémoire pour struct Contact...</p>
                            <p>> Application prête à l'exécution.</p>
                        </div>
                    </div>
                </div>
                <div class="hero-blur-decoration"></div>
            </div>
        </div>
    </section>

    <section class="engineering-section">
        <div class="container">
            <div class="flex-row">
                <div class="col-33">
                    <h2 class="section-label">Ingénierie</h2>
                    <h3 class="section-h3">L'alliance de la Performance C et de la Structure SQL</h3>
                </div>
                <div class="col-66">
                    <p class="body-text">
                        Contrairement aux fichiers texte classiques, notre architecture utilise des structures C pour le traitement en mémoire vive et <strong>SQLite</strong> pour le stockage permanent. En exploitant la directive <code>PRIMARY KEY</code> et l'indexation SQL, ce système garantit une recherche quasi-instantanée même sur de larges volumes de contacts.
                    </p>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-value">Fast-IO</span>
                            <p class="stat-label">Vitesse d'exécution</p>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">ACID</span>
                            <p class="stat-label">Fiabilité des données</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features-section" id="features">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Capacités du <span class="text-primary">Système</span></h2>
                <div class="title-underline"></div>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <span class="material-symbols-outlined feature-icon">person_add</span>
                    <h4 class="feature-name">Ajout de Contact</h4>
                    <p class="feature-desc">Saisie sécurisée via struct Contact avec validation des formats de noms et numéros.</p>
                    <span class="feature-tech">C: malloc() + SQL INSERT</span>
                </div>
                <div class="feature-card">
                    <span class="material-symbols-outlined feature-icon">person_remove</span>
                    <h4 class="feature-name">Suppression Ciblée</h4>
                    <p class="feature-desc">Retrait définitif de records via leur ID unique, avec mise à jour immédiate de la base.</p>
                    <span class="feature-tech">SQL: DELETE WHERE id = ?</span>
                </div>
                <div class="feature-card">
                    <span class="material-symbols-outlined feature-icon">edit_note</span>
                    <h4 class="feature-name">Mise à jour Dynamique</h4>
                    <p class="feature-desc">Modification en temps réel des métadonnées grâce aux requêtes SQL UPDATE préparées.</p>
                    <span class="feature-tech">C: sqlite3_bind_text()</span>
                </div>
            </div>
        </div>
    </section>

    <section class="code-section" id="code">
        <div class="container">
            <div class="flex-center gap-4 mb-12">
                <span class="material-symbols-outlined text-primary">code_blocks</span>
                <h2 class="section-h2-caps">Implémentation Technique</h2>
            </div>
            <div class="code-window">
                <div class="window-header">
                    <div class="window-dots">
                        <div class="dot red"></div>
                        <div class="dot yellow"></div>
                        <div class="dot green"></div>
                    </div>
                    <div class="window-title">Contact_Manager_Core — main.c / schema.sql</div>
                </div>
                <div class="code-grid">
                    <div class="code-panel">
                        <pre class="code-block"><code><span class="text-secondary">typedef struct</span> {
    <span class="text-secondary">int</span> id;
    <span class="text-secondary">char</span> nom[50];
    <span class="text-secondary">char</span> tel[20];
} <span class="text-primary">Contact</span>;</code></pre>
                    </div>
                    <div class="code-panel dark-panel">
                        <pre class="code-block"><code><span class="text-secondary">CREATE TABLE</span> <span class="text-primary">contacts</span> (
    id <span class="text-secondary">INTEGER PRIMARY KEY</span> AUTOINCREMENT,
    nom <span class="text-secondary">TEXT NOT NULL</span>,
    tel <span class="text-secondary">TEXT UNIQUE NOT NULL</span>
);</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="db-section" id="database">
        <div class="container">
            <h2 class="section-title-center">Architecture du <span class="text-primary">Schéma</span></h2>
            <div class="db-grid">
                <div class="db-card primary-border">
                    <p class="db-meta">DATA_TYPE_01</p>
                    <h5 class="db-field">ID</h5>
                    <p class="db-type">Clé Primaire (Auto-incrément)</p>
                </div>
                <div class="db-card">
                    <p class="db-meta">DATA_TYPE_02</p>
                    <h5 class="db-field">NOM</h5>
                    <p class="db-type">TEXT (Obligatoire)</p>
                </div>
                <div class="db-card">
                    <p class="db-meta">DATA_TYPE_03</p>
                    <h5 class="db-field">TÉLÉPHONE</h5>
                    <p class="db-type">TEXT UNIQUE (Contrainte)</p>
                </div>
                <div class="db-card">
                    <p class="db-meta">DATA_TYPE_04</p>
                    <h5 class="db-field">CRÉÉ LE</h5>
                    <p class="db-type">DATETIME (Auto)</p>
                </div>
            </div>
        </div>
    </section>

    <section class="timeline-section" id="evolutions">
        <div class="container">
            <h2 class="section-h2-large">Évolutions du <span class="text-primary">Projet</span></h2>
            <div class="timeline-container">
                <div class="timeline-line"></div>
                
                <div class="timeline-item">
                    <div class="timeline-content text-right">
                        <h4 class="timeline-title">Interface GTK</h4>
                        <p class="timeline-desc">Passage d'une interface terminal à une interface graphique fenêtrée tout en gardant le cœur en C.</p>
                    </div>
                    <div class="timeline-dot">
                        <div class="dot-inner pulse"></div>
                    </div>
                    <div class="timeline-phase">PHASE_01</div>
                </div>

                <div class="timeline-item reverse">
                    <div class="timeline-content">
                        <h4 class="timeline-title">Export JSON/CSV</h4>
                        <p class="timeline-desc">Ajout d'un module de portabilité pour exporter la base SQL vers des formats universels.</p>
                    </div>
                    <div class="timeline-dot">
                        <div class="dot-inner"></div>
                    </div>
                    <div class="timeline-phase text-right">PHASE_02</div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-content text-right">
                        <h4 class="timeline-title">Sync Cloud</h4>
                        <p class="timeline-desc">Implémentation d'une API REST pour synchroniser les contacts locaux avec un serveur distant.</p>
                    </div>
                    <div class="timeline-dot">
                        <div class="dot-inner"></div>
                    </div>
                    <div class="timeline-phase">PHASE_03</div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p class="footer-copy">© 2026 ContactC-SQL // Logiciel Libres</p>
    </footer>

</body>
</html>