<?php 
require_once('fonctions.php'); 

// --- LOGIQUE DE TRAITEMENT ---
$erreurs_quick = [];
$erreurs_devis = [];
$succes_quick  = false;
$succes_devis  = false;
$demande_valide = []; 

// Initialisation variables pour la persistance 
$nom = $email = $message = "";
$type_projet = $timeline = $budget = $description = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // CAS 1 : FORMULAIRE QUICK PULSE
    if (isset($_POST['action']) && $_POST['action'] === 'quick_pulse') {
        $nom     = nettoyer($_POST['nom'] ?? '');
        $email    = nettoyer($_POST['email'] ?? '');
        $message  = nettoyer($_POST['message'] ?? '');

        if (!champ_requis($nom))     $erreurs_quick['nom'] = "IDENTITE_REQUISE";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurs_quick['email'] = "DESTINATION_INVALID";
        if (!champ_requis($message)) $erreurs_quick['message'] = "CONTENU_VIDE";

        if (empty($erreurs_quick)) $succes_quick = true;
    }

    // CAS 2 : FORMULAIRE CAHIER DES CHARGES
    if (isset($_POST['action']) && $_POST['action'] === 'generer_devis') {
        // Stockage immédiat dans le tableau associatif requis
        $demande_valide = [
            'type_projet' => nettoyer($_POST['type_projet'] ?? ''),
            'timeline'    => nettoyer($_POST['timeline'] ?? ''),
            'budget'      => nettoyer($_POST['budget'] ?? ''),
            'description' => nettoyer($_POST['description'] ?? ''),
            'nda'         => isset($_POST['nda']) ? 'OUI' : 'NON'
        ];

        // Validation champ par champ
        if (empty($demande_valide['type_projet'])) $erreurs_devis['type'] = "SCOPE_NON_DEFINI";
        if (empty($demande_valide['timeline']))    $erreurs_devis['time'] = "DELAI_NON_SPECIFIE";
        if (empty($demande_valide['budget']))      $erreurs_devis['budget'] = "BUDGET_NON_SPECIFIE";
        if (empty($demande_valide['description'])) $erreurs_devis['desc'] = "DETAILS_MANQUANTS";
        
        if (empty($erreurs_devis)) {
            $succes_devis = true;
        } else {
            // Pour la persistance en cas d'erreur
            $type_projet = $demande_valide['type_projet'];
            $timeline    = $demande_valide['timeline'];
            $budget      = $demande_valide['budget'];
            $description = $demande_valide['description'];
        }
    }
}
?>
<!DOCTYPE html>
<html class="dark overflow-x-hidden" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>KINETIC_LOGIC // CONTACT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style-contact.css">
</head>

<body class="custom-body selection:bg-[#00f719] selection:text-[#003a01] overflow-x-hidden w-full">
    
    <?php require('composants/navigation.php'); ?>

    <main class="pt-32 pb-20 px-6 max-w-7xl mx-auto overflow-hidden">
        <header class="mb-20">
            <div class="status-badge">
                <span class="font-headline text-[#00f719] text-[10px] uppercase tracking-[0.3em]">Status: Available for hire</span>
            </div>
            <h1 class="font-headline text-5xl md:text-7xl font-bold tracking-tight text-[#f1f1f1] mb-6 leading-none break-words">
                ESTABLISH_CONNECTION
            </h1>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- FORMULAIRE QUICK PULSE -->
            <section class="lg:col-span-4 bg-[#1b1b1b] p-8 relative overflow-hidden group">
                <h2 class="font-headline text-2xl font-semibold mb-8 text-[#00f719] uppercase tracking-tight">Quick_Pulse</h2>
                
                <?php if ($succes_quick): ?>
                    <div class="mb-6 p-4 bg-[#00f719]/10 border border-[#00f719] text-[#00f719] font-mono text-[10px]">SYSTEM_MSG: DONNÉES_TRANSMISES</div>
                <?php endif; ?>

                <form method="POST" action="contact.php" class="space-y-8">
                    <input type="hidden" name="action" value="quick_pulse">
                    <div class="input-group">
                        <label class="input-label">IDENTITE</label>
                        <input name="nom" class="input-field" type="text" value="<?= $nom ?>" placeholder="Your Name"/>
                        <?php if(isset($erreurs_quick['nom'])): ?><p class="text-red-500 text-[10px] mt-1 font-mono uppercase"><?= $erreurs_quick['nom'] ?></p><?php endif; ?>
                    </div>
                    <div class="input-group">
                        <label class="input-label">DESTINATION</label>
                        <input name="email" class="input-field" type="email" value="<?= $email ?>" placeholder="Email Address"/>
                        <?php if(isset($erreurs_quick['email'])): ?><p class="text-red-500 text-[10px] mt-1 font-mono uppercase"><?= $erreurs_quick['email'] ?></p><?php endif; ?>
                    </div>
                    <div class="input-group">
                        <label class="input-label">CONTENU</label>
                        <textarea name="message" class="input-field resize-none" rows="4" placeholder="Brief Message..."><?= $message ?></textarea>
                        <?php if(isset($erreurs_quick['message'])): ?><p class="text-red-500 text-[10px] mt-1 font-mono uppercase"><?= $erreurs_quick['message'] ?></p><?php endif; ?>
                    </div>
                    <button type="submit" class="submit-btn-primary w-full">TRANSMETTRE_DONNEES</button>
                </form>
            </section>

            <!-- FORMULAIRE CAHIER DES CHARGES -->
            <section class="lg:col-span-8 bg-[#1f1f1f] p-8 md:p-12 border-l-2 border-[#00f719]/20 overflow-hidden">
                
                <?php if ($succes_devis): ?>
                    <!-- RÉCAPITULATIF (Rendu Facture Technique) -->
                    <div class="mb-12 p-8 border border-[#00f719] bg-[#00f719]/5 font-mono animate-pulse">
                        <h3 class="text-[#00f719] text-xl mb-6 border-b border-[#00f719]/30 pb-2">TECHNICAL_INVOICE_GENERATED</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                            <div><p class="text-[#3b4b36]">SCOPE:</p><p class="text-[#f1f1f1]"><?= $demande_valide['type_projet'] ?></p></div>
                            <div><p class="text-[#3b4b36]">TIMELINE:</p><p class="text-[#f1f1f1]"><?= $demande_valide['timeline'] ?></p></div>
                            <div><p class="text-[#3b4b36]">BUDGET_ESTIMATE:</p><p class="text-[#f1f1f1]"><?= $demande_valide['budget'] ?></p></div>
                            <div><p class="text-[#3b4b36]">NDA_REQUIRED:</p><p class="text-[#f1f1f1]"><?= $demande_valide['nda'] ?></p></div>
                            <div class="md:col-span-2"><p class="text-[#3b4b36]">CORE_REQUIREMENTS:</p><p class="text-[#f1f1f1]"><?= $demande_valide['description'] ?></p></div>
                        </div>
                        <button onclick="window.location.href='contact.php'" class="mt-8 text-[#00f719] border border-[#00f719] px-4 py-2 text-[10px] hover:bg-[#00f719] hover:text-black transition-all">REFRESH_SYSTEM</button>
                    </div>
                <?php else: ?>
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-4">
                        <div>
                            <h2 class="font-headline text-3xl font-bold text-[#f1f1f1] mb-2">CAHIER_DES_CHARGES</h2>
                            <p class="font-headline text-xs text-[#baccb0] uppercase tracking-widest">Technical Specifications Required</p>
                        </div>
                    </div>

                    <form method="POST" action="contact.php" class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                        <input type="hidden" name="action" value="generer_devis">
                        <div class="space-y-10">
                            <div class="relative">
                                <label class="label-tech">01. Development Scope</label>
                                <select name="type_projet" class="select-field">
                                    <option value="">-- SELECTIONNER_SCOPE --</option>
                                    <option value="Web & Mobile" <?= $type_projet == 'Web & Mobile' ? 'selected' : '' ?>>Application Web & Mobile</option>
                                    <option value="Réseau & Serveur" <?= $type_projet == 'Réseau & Serveur' ? 'selected' : '' ?>>Administration Réseau & Serveur</option>
                                    <option value="IoT ESP32" <?= $type_projet == 'IoT ESP32' ? 'selected' : '' ?>>Solution IoT (ESP32)</option>
                                </select>
                                <?php if(isset($erreurs_devis['type'])): ?><p class="text-red-500 text-[10px] font-mono mt-1 uppercase"><?= $erreurs_devis['type'] ?></p><?php endif; ?>
                            </div>

                            <div class="relative">
                                <label class="label-tech">02. Estimated Timeline</label>
                                <div class="flex gap-2 sm:gap-4">
                                    <label class="radio-card"><input name="timeline" value="< 1 Month" type="radio" class="hidden peer" <?= $timeline == '< 1 Month' ? 'checked' : '' ?>/><div class="radio-box">&lt; 1 Month</div></label>
                                    <label class="radio-card"><input name="timeline" value="1-3 Months" type="radio" class="hidden peer" <?= $timeline == '1-3 Months' ? 'checked' : '' ?>/><div class="radio-box">1-3 Months</div></label>
                                    <label class="radio-card"><input name="timeline" value="Long Term" type="radio" class="hidden peer" <?= $timeline == 'Long Term' ? 'checked' : '' ?>/><div class="radio-box">Long Term</div></label>
                                </div>
                                <?php if(isset($erreurs_devis['time'])): ?><p class="text-red-500 text-[10px] font-mono mt-2 uppercase"><?= $erreurs_devis['time'] ?></p><?php endif; ?>
                            </div>

                            <div class="relative">
                                <label class="label-tech">03. Target Budget</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="radio-card"><input name="budget" value="$5k-$10k" type="radio" class="hidden peer" <?= $budget == '$5k-$10k' ? 'checked' : '' ?>/><div class="radio-box">$5k - $10k</div></label>
                                    <label class="radio-card"><input name="budget" value="$10k-$25k" type="radio" class="hidden peer" <?= $budget == '$10k-$25k' ? 'checked' : '' ?>/><div class="radio-box">$10k - $25k</div></label>
                                </div>
                                <?php if(isset($erreurs_devis['budget'])): ?><p class="text-red-500 text-[10px] font-mono mt-2 uppercase"><?= $erreurs_devis['budget'] ?></p><?php endif; ?>
                            </div>
                        </div>

                        <div class="space-y-10">
                            <div class="relative">
                                <label class="label-tech">04. Technical Requirements</label>
                                <textarea name="description" class="textarea-field" placeholder="Décrivez les fonctionnalités clés..." rows="8"><?= $description ?></textarea>
                                <?php if(isset($erreurs_devis['desc'])): ?><p class="text-red-500 text-[10px] font-mono mt-1 uppercase"><?= $erreurs_devis['desc'] ?></p><?php endif; ?>
                            </div>
                            <div class="flex items-start gap-4">
                                <input name="nda" type="checkbox" class="custom-checkbox" />
                                <p class="text-[11px] text-[#baccb0] uppercase font-headline">Demande de signature NDA.</p>
                            </div>
                        </div>

                        <div class="md:col-span-2 pt-8">
                            <button type="submit" class="cta-large-btn">
                                <span class="text-lg md:text-xl uppercase">Générer la facture technique</span>
                                <span class="material-symbols-outlined text-2xl hidden sm:block">receipt_long</span>
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <?php require('composants/pied_page.php'); ?>
    <div class="glow-top"></div>
</body>
</html>