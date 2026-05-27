
<?php
// admin/projets/ajouter.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../config/connexion.php'); 
require_once('../../fonctions.php');

// Protection d'accès stricte
verifierAuthentification();

$erreur = null;
$succes = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. EXIGENCE PROF : Protection CSRF
    $token_soumis = $_POST['csrf_token'] ?? '';
    if (!verifier_csrf($token_soumis)) {
        die("LOG_ERROR // CSRF_TOKEN_INVALID // Tentative de faille détectée.");
    }

    // 2. Récupération et nettoyage des données textuelles (Exigence Failles XSS)
    $titre = isset($_POST['titre']) ? nettoyer($_POST['titre']) : '';
    $description = isset($_POST['description']) ? nettoyer($_POST['description']) : '';
    $technologies = isset($_POST['technologies']) ? nettoyer($_POST['technologies']) : '';
    $lien = isset($_POST['lien']) ? filter_var($_POST['lien'], FILTER_SANITIZE_URL) : '';

    // 3. Validation des champs obligatoires
    if (champ_requis($titre) && champ_requis($description) && champ_requis($technologies)) {
        
        $nom_image_bdd = null; // Par défaut si aucune image n'est fournie

        // 4. EXIGENCE PROF : Traitement ultra-sécurisé de l'upload d'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                
                // Restriction stricte de la taille (ex: max 3 Mo)
                $max_size = 3 * 1024 * 1024; 
                
                // Extraction et vérification de l'extension
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $extensions_autorisees = ['jpg', 'jpeg', 'png', 'webp'];

                // Vérification du type MIME réel de l'image (Exigence de sécurité avancée)
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $file_tmp);
                finfo_close($finfo);
                $mimes_autorises = ['image/jpeg', 'image/png', 'image/webp'];

                if (!in_array($file_ext, $extensions_autorisees) || !in_array($mime_type, $mimes_autorises)) {
                    $erreur = "Format d'image non autorisé. Extensions acceptées : JPG, PNG, WEBP.";
                } elseif ($file_size > $max_size) {
                    $erreur = "Le fichier est trop lourd. Limite système fixée à 3 Mo.";
                } else {
                    // Renommage unique pour éviter l'écrasement (Exigence du cours)
                    $nom_image_bdd = bin2hex(random_bytes(8)) . '.' . $file_ext;
                    
                    // Chemin de destination vers ton dossier d'images public
                    $dossier_destination = '../../images/projets/';
                    
                    // Création automatique du dossier s'il n'existe pas encore
                    if (!is_dir($dossier_destination)) {
                        mkdir($dossier_destination, 0755, true);
                    }

                    // Déplacement final du fichier temporaire
                    if (!move_uploaded_file($file_tmp, $dossier_destination . $nom_image_bdd)) {
                        $erreur = "Échec du transfert système vers le répertoire d'images.";
                        $nom_image_bdd = null;
                    }
                }
            } else {
                $erreur = "Une erreur technique est survenue lors du téléversement de l'image.";
            }
        }

        // 5. Insertion en BDD si aucune erreur de fichier n'a été levée
        if ($erreur === null) {
            try {
                // EXIGENCE PROF : Requête préparée PDO stricte
                $sql = "INSERT INTO projets (titre, description, technologies, image, lien, date_creation) 
                        VALUES (:titre, :description, :technologies, :image, :lien, NOW())";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'titre'        => $titre,
                    'description'  => $description,
                    'technologies' => $technologies,
                    'image'        => $nom_image_bdd,
                    'lien'         => !empty($lien) ? $lien : null
                ]);

                $succes = "Le nouveau projet a été injecté avec succès dans les archives.";
                
                // Réinitialisation des variables pour vider le formulaire
                $titre = $description = $technologies = $lien = "";

            } catch (PDOException $e) {
                error_log("Erreur Insertion Projet: " . $e->getMessage());
                $erreur = "Échec de l'injection en base de données.";
            }
        }

    } else {
        $erreur = "Veuillez renseigner tous les protocoles obligatoires (*).";
    }
}

// Régénération du token pour le formulaire
$csrf_token = genererTokenCSRF();
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CORE_SYSTEM // INDEX_NEW_PROJECT</title>
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
            <a href="index.php" class="flex items-center gap-2 text-[#baccb0] hover:text-[#00f719] font-mono text-xs transition-colors">
                <span class="material-symbols-outlined text-sm">arrow_back</span> BACK_TO_DIRECTORY
            </a>
        </div>
        <div class="flex items-center gap-6 font-mono text-xs">
            <span class="text-[#baccb0]">SYS_OPERATOR: <span class="text-[#00f719]"><?= isset($_SESSION['admin_prenom']) ? e($_SESSION['admin_prenom']) : 'UNKNOWN' ?></span></span>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-8 py-12 flex flex-col gap-8">
        
        <header class="border-b border-[#30363d] pb-6">
            <span class="font-mono text-[#00f719] text-xs tracking-[0.3em] uppercase">SYSTEM_INJECTION</span>
            <h1 class="font-headline text-4xl font-bold tracking-tight text-[#e2e2e2]">INDEXER UN PROJET</h1>
        </header>

        <?php if ($erreur): ?>
            <div class="bg-red-950/20 border border-red-900 text-red-400 p-4 font-mono text-xs uppercase tracking-wide">
                [// ERROR] : <?= e($erreur) ?>
            </div>
        <?php endif; ?>

        <?php if ($succes): ?>
            <div class="bg-green-950/20 border border-[#00f719] text-[#00f719] p-4 font-mono text-xs uppercase tracking-wide">
                [// SUCCESS] : <?= e($succes) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 font-mono text-xs">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

            <div>
                <label class="block text-[#baccb0] uppercase tracking-wider mb-2">Titre du Projet *</label>
                <input type="text" name="titre" required value="<?= isset($titre) ? e($titre) : '' ?>" class="w-full bg-[#0d1117] border border-[#30363d] focus:border-[#00f719] outline-none p-3 text-[#e2e2e2] transition-colors">
            </div>

            <div>
                <label class="block text-[#baccb0] uppercase tracking-wider mb-2">Technologies utilisées * (Séparées par des virgules)</label>
                <input type="text" name="technologies" placeholder="HTML, Tailwind, PHP, MySQL" required value="<?= isset($technologies) ? e($technologies) : '' ?>" class="w-full bg-[#0d1117] border border-[#30363d] focus:border-[#00f719] outline-none p-3 text-[#e2e2e2] transition-colors">
            </div>

            <div>
                <label class="block text-[#baccb0] uppercase tracking-wider mb-2">Lien externe / GitHub (Optionnel)</label>
                <input type="url" name="lien" placeholder="https://github.com/..." value="<?= isset($lien) ? e($lien) : '' ?>" class="w-full bg-[#0d1117] border border-[#30363d] focus:border-[#00f719] outline-none p-3 text-[#e2e2e2] transition-colors">
            </div>

            <div>
                <label class="block text-[#baccb0] uppercase tracking-wider mb-2">Description complète *</label>
                <textarea name="description" rows="5" required class="w-full bg-[#0d1117] border border-[#30363d] focus:border-[#00f719] outline-none p-3 text-[#e2e2e2] transition-colors"><?= isset($description) ? e($description) : '' ?></textarea>
            </div>

            <div>
                <label class="block text-[#baccb0] uppercase tracking-wider mb-2">Fichier Visuel / Capture d'écran (JPG, PNG, WEBP)</label>
                <div class="relative border border-dashed border-[#30363d] hover:border-[#00f719] transition-colors p-6 text-center bg-[#161b22]/20">
                    <input type="file" name="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <span class="material-symbols-outlined text-[#baccb0] text-2xl mb-2">cloud_upload</span>
                    <p class="text-[#baccb0]">Glissez votre fichier ici ou cliquez pour explorer la mémoire locale.</p>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-[#00f719] text-[#0d1117] font-bold px-8 py-3 hover:bg-[#00f719]/80 transition-colors uppercase tracking-wider">
                    EXECUTE_INJECTION ➔
                </button>
            </div>
        </form>

    </main>

</body>
</html>