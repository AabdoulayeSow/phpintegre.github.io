<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>SMARTBIN_OS | ESP32 IoT Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="style-arduino.css">
</head>
<body class="iot-body selection:bg-[#00f719] selection:text-[#003a01]">

<nav class="fixed top-0 w-full z-50 iot-nav-blur border-b border-[#00F719]/15 shadow-[0_0_48px_0_rgba(0,247,25,0.05)]">
    <div class="max-w-full px-12 py-6 flex justify-between items-center">
        <div class="text-xl font-bold tracking-tighter text-[#00F719] font-headline">SMARTBIN_ESP32</div>
        <div class="hidden md:flex gap-12 items-center">
            <a class="nav-iot-link active" href="#hero">Système</a>
            <a class="nav-iot-link" href="#code">Code IoT</a>
            <a class="nav-iot-link" href="#process">Conception</a>
            <a class="nav-iot-link" href="#result">Hardware</a>
        </div>
        <div class="flex items-center gap-4">
            <a href="./index.php" class="back-home-btn">
                <span class="material-symbols-outlined text-sm">terminal</span> Retour Accueil
            </a>
        </div>
    </div>
</nav>

<section class="relative min-h-screen flex flex-col justify-center px-12 pt-24 overflow-hidden" id="hero">
    <div class="absolute inset-0 grid-pattern pointer-events-none"></div>
    <div class="relative z-10 grid md:grid-cols-2 gap-12 items-center max-w-7xl mx-auto w-full">
        <div class="space-y-8">
            <div class="status-pill">
                <div class="status-pulse"></div>
                <span class="status-text">ESP32 Dual-Core Active</span>
            </div>
            <h1 class="font-headline text-6xl md:text-8xl font-bold tracking-tighter leading-none">
                Smart Trash <br/>
                <span class="text-[#00f719]">IoT Edition</span>
            </h1>
            <p class="text-xl text-[#baccb0] max-w-xl font-light leading-relaxed">
                Plus qu'une simple poubelle sans contact. Grâce à l'ESP32, la gestion des déchets devient connectée : monitoring Wi-Fi, notifications en temps réel et automatisation fluide.
            </p>
            <div class="flex flex-wrap gap-4 pt-4">
               <a href="./code.php" class="btn-iot-primary">Code ESP32</a>
               <a href="./img/poubelle.png" class="btn-iot-outline">Schéma IoT</a>
            </div>
        </div>
        <div class="relative flex justify-center lg:justify-end">
            <div class="relative w-80 h-80 md:w-96 md:h-96">
                <div class="hero-glow-sphere"></div>
                <div class="rotating-border"></div>
                <div class="hero-img-container">
                    <img class="w-full h-full object-cover" src="./img/estm_moi.jpg" alt="ESP32 Project"/>
                </div>
                <div class="glass-panel wifi-badge">
                    <span class="font-mono text-xs text-[#00f719]">WIFI_CONNECTED: 2.4GHz</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 px-12 bg-[#1b1b1d]" id="code">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row gap-16">
            <div class="md:w-1/3 space-y-6">
                <h2 class="font-headline text-4xl font-bold tracking-tight">Le Cœur du Système</h2>
                <p class="text-[#baccb0] font-body leading-relaxed">
                    Contrairement à l'Arduino classique, l'ESP32 gère le servomoteur via des timers spécifiques et permet d'envoyer les données de remplissage vers un serveur via MQTT ou HTTP.
                </p>
                <div class="space-y-4 pt-4">
                    <div class="flex gap-4">
                        <span class="material-symbols-outlined text-[#00f719]">wifi</span>
                        <div>
                            <h4 class="font-bold text-sm uppercase tracking-wider text-[#e5e1e4]">Connectivité Cloud</h4>
                            <p class="text-xs text-[#baccb0]">Statut de la poubelle disponible sur Dashboard web.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <span class="material-symbols-outlined text-[#00f719]">bolt</span>
                        <div>
                            <h4 class="font-bold text-sm uppercase tracking-wider text-[#e5e1e4]">Multi-Threading</h4>
                            <p class="text-xs text-[#baccb0]">Détection et réseau tournent en parallèle.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:w-2/3">
                <div class="terminal-mockup">
                    <div class="terminal-header">
                        <div class="flex gap-2">
                            <div class="terminal-dot red"></div>
                            <div class="terminal-dot yellow"></div>
                            <div class="terminal-dot green"></div>
                        </div>
                        <span class="terminal-title">smartbin_esp32.ino</span>
                        <div class="w-12"></div>
                    </div>
                    <div class="terminal-body terminal-scroll">
<pre class="code-font"><span class="code-purple">#include</span> <span class="code-orange">&lt;WiFi.h&gt;</span>
<span class="code-purple">#include</span> <span class="code-orange">&lt;ESP32Servo.h&gt;</span>

<span class="code-blue-light">Servo</span> binServo;
<span class="code-blue">const int</span> PIN_TRIG = <span class="code-green-num">5</span>;
<span class="code-blue">const int</span> PIN_ECHO = <span class="code-green-num">18</span>;

<span class="code-blue">void</span> <span class="code-yellow">setup</span>() {
  <span class="code-yellow">Serial</span>.<span class="code-yellow">begin</span>(<span class="code-green-num">115200</span>);
  <span class="code-blue-light">ESP32PWM</span>::<span class="code-yellow">allocateTimer</span>(<span class="code-green-num">0</span>);
  binServo.<span class="code-yellow">attach</span>(<span class="code-green-num">13</span>); 
  
  <span class="code-yellow">pinMode</span>(PIN_TRIG, <span class="code-blue">OUTPUT</span>);
  <span class="code-yellow">pinMode</span>(PIN_ECHO, <span class="code-blue">INPUT</span>);
}

<span class="code-blue">void</span> <span class="code-yellow">loop</span>() {
  <span class="code-blue">long</span> duration, distance;
  <span class="code-yellow">digitalWrite</span>(PIN_TRIG, <span class="code-blue">LOW</span>);
  <span class="code-yellow">delayMicroseconds</span>(<span class="code-green-num">2</span>);
  <span class="code-yellow">digitalWrite</span>(PIN_TRIG, <span class="code-blue">HIGH</span>);
  <span class="code-yellow">delayMicroseconds</span>(<span class="code-green-num">10</span>);
  <span class="code-yellow">digitalWrite</span>(PIN_TRIG, <span class="code-blue">LOW</span>);
  
  duration = <span class="code-yellow">pulseIn</span>(PIN_ECHO, <span class="code-blue">HIGH</span>);
  distance = (duration/<span class="code-green-num">2</span>) / <span class="code-green-num">29.1</span>;

  <span class="code-purple">if</span> (distance < <span class="code-green-num">25</span>) {
    binServo.<span class="code-yellow">write</span>(<span class="code-green-num">90</span>);
    <span class="code-yellow">delay</span>(<span class="code-green-num">3000</span>);
  } <span class="code-purple">else</span> {
    binServo.<span class="code-yellow">write</span>(<span class="code-green-num">0</span>);
  }
}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 px-12 relative" id="process">
    <div class="max-w-7xl mx-auto">
        <h2 class="font-headline text-center text-4xl font-bold tracking-tight mb-20">Pipeline de Développement ESP32</h2>
        <div class="grid md:grid-cols-4 gap-8 relative">
            <div class="pipeline-connector"></div>
            <div class="step-card">
                <div class="step-number active">01</div>
                <div class="step-content">
                    <span class="material-symbols-outlined step-icon">router</span>
                    <h3 class="step-title">Réseau</h3>
                    <p class="step-desc">Configuration de la pile TCP/IP et credentials Wi-Fi.</p>
                </div>
            </div>
            <div class="step-card">
                <div class="step-number">02</div>
                <div class="step-content">
                    <span class="material-symbols-outlined step-icon">memory</span>
                    <h3 class="step-title">Hardware</h3>
                    <p class="step-desc">ESP32 DevKit V1, HC-SR04 et Servo haute précision.</p>
                </div>
            </div>
            <div class="step-card">
                <div class="step-number">03</div>
                <div class="step-content">
                    <span class="material-symbols-outlined step-icon">hub</span>
                    <h3 class="step-title">Câblage</h3>
                    <p class="step-desc">Adaptation des niveaux de tension 3.3V de l'ESP32.</p>
                </div>
            </div>
            <div class="step-card">
                <div class="step-number">04</div>
                <div class="step-content">
                    <span class="material-symbols-outlined step-icon">analytics</span>
                    <h3 class="step-title">Tests</h3>
                    <p class="step-desc">Calibration du seuil de distance et stabilité Wi-Fi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 px-12 bg-[#131315]" id="result">
    <div class="max-w-7xl mx-auto">
        <header class="mb-16">
            <h2 class="font-headline text-4xl font-bold tracking-tight text-[#e5e1e4]">Capacités Smart</h2>
            <div class="title-underline"></div>
        </header>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="glass-panel capability-card">
                <span class="material-symbols-outlined capability-icon">cloud_upload</span>
                <h3 class="text-xl font-bold mb-4 font-headline tracking-tight text-[#e5e1e4]">Sync Cloud</h3>
                <p class="text-[#baccb0] leading-relaxed">Données de remplissage transmises en temps réel pour optimiser le ramassage.</p>
            </div>
            <div class="glass-panel capability-card">
                <span class="material-symbols-outlined capability-icon">auto_mode</span>
                <h3 class="text-xl font-bold mb-4 font-headline tracking-tight text-[#e5e1e4]">Réponse Ultra-Fluide</h3>
                <p class="text-[#baccb0] leading-relaxed">Grâce au processeur 240MHz, l'ouverture est déclenchée sans aucune latence.</p>
            </div>
            <div class="glass-panel capability-card">
                <span class="material-symbols-outlined capability-icon">battery_saver</span>
                <h3 class="text-xl font-bold mb-4 font-headline tracking-tight text-[#e5e1e4]">Mode Deep Sleep</h3>
                <p class="text-[#baccb0] leading-relaxed">Consommation minimale pour une autonomie prolongée sur batterie Li-ion.</p>
            </div>
        </div>
    </div>
</section>

<footer class="w-full py-20 px-12 bg-[#131315] border-t border-[#3b4b36]/20">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center opacity-80">
        <div class="footer-iot-logo">
            © 2024 SMARTBIN_ESP32 | IoT Waste Management
        </div>
        <div class="flex gap-12 mt-8 md:mt-0">
            <a class="footer-iot-link" href="https://www.linkedin.com/in/abdoulaye-sow-58b98b35a">LinkedIn</a>
            <a class="footer-iot-link" href="https://t.me/Abdallahso">Télégramme</a>
            <a class="footer-iot-link" href="https://github.com/dashboard">Github</a>
        </div>
    </div>
</footer>

</body>
</html>