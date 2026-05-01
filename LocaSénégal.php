<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>LocaSénégal - Système d'Exploitation Immobilier</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="style-LocaSénégal.css">

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#00F719",
                        "on-primary": "#000000",
                        "secondary": "#0D0D0D",
                        "background": "#050505",
                        "surface": "#0A0A0A",
                        "surface-variant": "#141414",
                        "outline": "#00F719",
                        "on-background": "#FFFFFF",
                        "on-surface": "#F2F2F2",
                        "on-surface-variant": "#A3A3A3"
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background text-on-background font-body selection:bg-primary/40 terminal-scanline">

    <nav class="fixed top-0 w-full z-50 bg-black/80 backdrop-blur-md border-b border-primary/20">
        <div class="flex justify-between items-center max-w-7xl mx-auto px-8 py-4">
            <div class="text-2xl font-bold tracking-tighter text-primary font-headline uppercase italic">LocaSénégal</div>
            <div class="hidden md:flex gap-10 items-center font-headline text-xs tracking-[0.2em] uppercase font-semibold">
                <a class="text-primary border-b-2 border-primary pb-1" href="#modèle">Modèle économique</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors" href="#inventaire">L'Inventaire</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors" href="#busness">Busness modèle</a>
            </div>
            <div class="flex items-center gap-6">
                <button class="material-symbols-outlined text-on-surface-variant hover:text-primary kinetic-transition">dashboard</button>
                <a href="./index.html">
                    <button class="bg-primary text-black px-6 py-2 rounded-lg font-bold uppercase text-xs tracking-widest hover:shadow-[0_0_20px_#00F719] active:scale-95">
                        Revenir à l’accueil
                    </button>
                </a>
            </div>
        </div>
    </nav>

    <main class="pt-24">
        <section class="relative px-8 py-20 lg:py-32 overflow-hidden">
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[120px]"></div>
            </div>
            <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center relative z-10">
                <div>
                    <span class="text-primary font-label text-xs font-bold tracking-[0.4em] mb-4 block uppercase neon-glow-text">Standard de location 2.0</span>
                    <h1 class="font-headline text-6xl lg:text-8xl font-black tracking-tighter leading-[0.9] mb-8 uppercase italic">
                        Loca<span class="text-primary">Sénégal</span>
                    </h1>
                    <p class="text-lg text-on-surface-variant max-w-lg mb-10 leading-relaxed font-light border-l-2 border-primary/30 pl-6">
                        L'immobilier sénégalais en <strong>Haute Résolution</strong>. Un protocole ultra-rapide reliant les biens d'exception aux locataires certifiés via une grille de données sécurisée.
                    </p>
                    <div class="flex flex-wrap gap-6">
                        <button class="bg-primary text-black px-10 py-5 rounded-lg font-black text-sm uppercase tracking-[0.2em] hover:shadow-[0_0_30px_rgba(0,247,25,0.4)] kinetic-transition">
                            Explorer les Biens
                        </button>
                        <button class="kinetic-glass px-10 py-5 rounded-lg font-bold text-sm text-primary uppercase tracking-[0.2em] border border-primary/30 hover:border-primary">
                            Spécifications Data
                        </button>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative z-10 kinetic-glass p-2 rounded-xl border-primary/40">
                        <img alt="Dashboard" class="rounded-lg w-full h-auto" src="./img/pc.jpeg" />
                        <div class="absolute -bottom-6 -left-6 w-56 kinetic-glass p-1 rounded-xl border-primary hidden md:block">
                            <img alt="App" class="rounded-lg shadow-xl" src="./img/mobile.jpeg" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 bg-surface border-y border-white/5">
            <div class="max-w-7xl mx-auto px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-4">
                    <div>
                        <h2 class="font-headline text-4xl font-bold uppercase tracking-tighter italic">Le Nouveau Protocole</h2>
                        <p class="text-primary font-mono text-xs mt-2 uppercase tracking-widest">Version d'exploitation 2.4.0</p>
                    </div>
                    <div class="h-px flex-grow mx-8 bg-primary/20 hidden md:block mb-3"></div>
                </div>
                <div class="grid md:grid-cols-2 gap-px bg-white/5">
                    <div class="bg-background p-10 lg:p-16">
                        <span class="material-symbols-outlined text-white/20 text-5xl mb-8">block</span>
                        <h3 class="text-2xl font-bold mb-6 font-headline uppercase tracking-tight">Inefficacités du Marché</h3>
                        <ul class="space-y-6 text-on-surface-variant font-light">
                            <li class="flex items-center gap-4"><span class="w-1 h-1 bg-white/20"></span>Opacité des prix et frais d'agences cachés</li>
                            <li class="flex items-center gap-4"><span class="w-1 h-1 bg-white/20"></span>Annonces non vérifiées et doublons systématiques</li>
                            <li class="flex items-center gap-4"><span class="w-1 h-1 bg-white/20"></span>Processus contractuels archaïques et risqués</li>
                        </ul>
                    </div>
                    <div class="bg-background p-10 lg:p-16 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 blur-3xl"></div>
                        <span class="material-symbols-outlined text-primary text-5xl mb-8 neon-glow-text">verified_user</span>
                        <h3 class="text-2xl font-bold mb-6 font-headline uppercase tracking-tight text-primary">Logique LocaSénégal</h3>
                        <ul class="space-y-6 text-on-surface-variant font-light">
                            <li class="flex items-center gap-4"><span class="w-2 h-[2px] bg-primary"></span>Connexion directe propriétaire-locataire certifié</li>
                            <li class="flex items-center gap-4"><span class="w-2 h-[2px] bg-primary"></span>Indexation en temps réel des tarifs du marché</li>
                            <li class="flex items-center gap-4"><span class="w-2 h-[2px] bg-primary"></span>Contrats numériques à valeur juridique absolue</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 max-w-7xl mx-auto px-8">
            <div class="mb-20">
                <span class="text-primary font-label text-xs font-bold tracking-[0.4em] uppercase mb-4 block">Architecture de l'écosystème</span>
                <h2 id="modèle" class="font-headline text-5xl font-black uppercase italic leading-none">Modèle Économique</h2>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="kinetic-glass p-10 rounded-xl border-white/5">
                    <div class="w-14 h-14 bg-white/5 rounded-lg flex items-center justify-center mb-8 border border-white/10">
                        <span class="material-symbols-outlined text-primary">analytics</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 font-headline uppercase tracking-tight">Gestion SaaS</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed font-light">Outils de gestion d'actifs pour les bailleurs professionnels et agences à haut volume.</p>
                </div>
                <div class="kinetic-glass p-10 rounded-xl bg-primary/5 border-primary/40 relative">
                    <div class="absolute -top-px left-10 right-10 h-px bg-gradient-to-r from-transparent via-primary to-transparent"></div>
                    <div class="w-14 h-14 bg-primary/10 rounded-lg flex items-center justify-center mb-8 border border-primary/30">
                        <span class="material-symbols-outlined text-primary neon-glow-text">payments</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 font-headline uppercase tracking-tight text-primary">Frais de Nœud</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed font-light">Commission fixe et transparente sur la sécurisation des transactions par séquestre numérique.</p>
                </div>
                <div class="kinetic-glass p-10 rounded-xl border-white/5">
                    <div class="w-14 h-14 bg-white/5 rounded-lg flex items-center justify-center mb-8 border border-white/10">
                        <span class="material-symbols-outlined text-primary">electric_bolt</span>
                    </div>
                    <h3 class="text-xl font-bold mb-4 font-headline uppercase tracking-tight">Boosters</h3>
                    <p class="text-on-surface-variant text-sm leading-relaxed font-light">Mise en avant algorithmique pour les biens prioritaires et services logistiques intégrés.</p>
                </div>
            </div>
        </section>

        <section class="py-24 max-w-7xl mx-auto px-8">
            <div class="bg-black border border-primary/30 rounded-2xl p-12 lg:p-24 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full pointer-events-none opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
                <h2 class="font-headline text-5xl lg:text-7xl font-black mb-8 uppercase italic relative z-10 leading-none">Lancer la <span class="text-primary">Séquence</span></h2>
                <p class="text-xl text-on-surface-variant max-w-2xl mx-auto mb-16 font-light relative z-10">
                    Le futur du marché immobilier sénégalais est ici. Déployez votre recherche maintenant.
                </p>
                <div class="relative z-10 inline-block">
                    <a id="busness" href="./ingredient/pdfff.pdf">
                        <button class="bg-primary text-black px-12 py-6 rounded-lg font-black uppercase text-sm tracking-[0.3em] shadow-[0_0_40px_rgba(0,247,25,0.2)] flex items-center gap-4 active:scale-95">
                            Voir le busness modèle
                            <span class="material-symbols-outlined text-2xl">arrow_forward</span>
                        </button>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="w-full border-t border-white/5 bg-black py-20">
        <div class="max-w-7xl mx-auto px-8 flex flex-col md:flex-row justify-between items-start">
            <div class="mb-12 md:mb-0">
                <div class="text-3xl font-black text-primary font-headline italic uppercase mb-4 tracking-tighter">LocaSénégal</div>
                <p class="text-xs text-on-surface-variant font-mono uppercase tracking-[0.2em]">Immobilier OS // Dakar 2026</p>
            </div>
            <div class="text-right">
                <div class="text-[10px] text-on-surface-variant/40 font-mono">
                    © LOCASÉNÉGAL<br />OPERATIONS_DAKAR_HQ
                </div>
            </div>
        </div>
    </footer>
</body>
</html>