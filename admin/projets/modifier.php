<?php
// admin/projets/modifier.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../config/connexion.php'); 
require_once('../../fonctions.php');

// Protection d'accès stricte
verifierAuthentification();

$erreur = null;
$succes = null;

// 1. Récupération et validation de l'ID du projet à modifier
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit();
}

// 2. Chargement des données actuelles du projet (y compris la description !)
try {
    $stmt = $pdo->prepare("SELECT * FROM projets WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $projet = $stmt->fetch();

    if (!$projet) {
        // Si le projet n'existe pas, retour au répertoire
        header('Location: index.php');
        exit();
    }
} catch (PDOException $e) {
    error_log("Erreur Chargement Projet: " . $e->getMessage());
    die("LOG_ERROR // CRITICAL_FETCH_FAILURE");
}

// 3. Traitement de la mise à jour (Soumission du formulaire)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Protection CSRF (Exigence prof)
    $token_soumis = $_POST['csrf_token'] ?? '';
    if (!verifier_csrf($token_soumis)) {
        die("LOG_ERROR // CSRF_TOKEN_INVALID");
    }

    // Récupération et nettoyage des champs (Failles XSS)
    $titre = isset($_POST['titre']) ? nettoyer($_POST['titre']) : '';
    $description = isset($_POST['description']) ? nettoyer($_POST['description']) : '';
    $technologies = isset($_POST['technologies']) ? nettoyer($_POST['technologies']) : '';
    $lien = isset($_POST['lien']) ? filter_var($_POST['lien'], FILTER_SANITIZE_URL) : '';

    if (champ_requis($titre) && champ_requis($description) && champ_requis($technologies)) {
        
        $nom_image_bdd = $projet['image']; // Par défaut, on garde l'ancienne image

        // Gestion de l'upload si une NOUVELLE image est fournie
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                
                $max_size = 3 * 1024 * 1024; 
                $extensions_autorisees = ['jpg', 'jpeg', 'png', 'webp'];

                // Vérification du type MIME réel
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $file_tmp);
                finfo_close($finfo);
                $mimes_autorises = ['image/jpeg', 'image/png', 'image/webp'];

                if (!in_array($file_ext, $extensions_autorisees) || !in_array($mime_type, $mimes_autorises)) {
                    $erreur = "Format d'image non autorisé (JPG, PNG, WEBP uniquement).";
                } elseif ($file_size > $max_size) {
                    $erreur = "Le fichier est trop lourd (Maximum 3 Mo).";
                } else {
                    // Nouveau nom unique
                    $nom_image_bdd = bin2hex(random_bytes(8)) . '.' . $file_ext;
                    $dossier_destination = '../../images/projets/';

                    if (move_uploaded_file($file_tmp, $dossier_destination . $nom_image_bdd)) {
                        // EXIGENCE BONUS : On supprime l'ancienne image du serveur pour ne pas stocker de fichiers inutiles
                        if (!empty($projet['image']) && file_exists($dossier_destination . $projet['image'])) {
                            unlink($dossier_destination . $projet['image']);
                        }
                    } else {
                        $erreur = "Échec du transfert de la nouvelle image.";
                        $nom_image_bdd = $projet['image'];
                    }
                }
            }
        }

        // Si pas d'erreur, exécution de la mise à jour
        if ($erreur === null) {
            try {
                $sql = "UPDATE projets 
                        SET titre = :titre, description = :description, technologies = :technologies, image = :image, lien = :lien 
                        WHERE id = :id";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'titre'        => $titre,
                    'description'  => $description,
                    'technologies' => $technologies,
                    'image'        => $nom_image_bdd,
                    'lien'         => !empty($lien) ? $lien : null,
                    'id'           => $id
                ]);

                // Rechargement des nouvelles données pour rafraîchir le formulaire
                $stmt = $pdo->prepare("SELECT * FROM projets WHERE id = :id");
                $stmt->execute(['id' => $id]);
                $projet = $stmt->fetch();

                $succes = "Protocoles mis à jour avec succès dans les archives.";
            } catch (PDOException $e) {
                error_log("Erreur Update Projet: " . $e->getMessage());
                $erreur = "Échec de la mise à jour de la base de données.";
            }
        }
    } else {
        $erreur = "Veuillez remplir tous les champs obligatoires (*).";
    }
}

$csrf_token = genererTokenCSRF();
?>
<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CORE_SYSTEM // EDIT_PROJECT</title>
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
            <span class="text-[#baccb0]">EDITING_NODE_ID: <span class="text-[#00f719]">#<?= (int)$projet['id'] ?></span></span>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-8 py-12 flex flex-col gap-8">
        
        <header class="border-b border-[#30363d] pb-6">
            <span class="font-mono text-[#00f719] text-xs tracking-[0.3em] uppercase">PATCH_COMMAND</span>
            <h1 class="font-headline text-4xl font-bold tracking-tight text-[#e2e2e2]">MODIFIER LE PROJET</h1>
        </header>

        <?php if ($erreur): ?>
            <div class="bg-red-950/20 border border-red-900 text-red-400 p-4 font-mono text-xs uppercase">
                [// ERROR] : <?= e($erreur) ?>
            </div>
        <?php endif; ?>

        <?php if ($succes): ?>
            <div class="bg-green-950/20 border border-[#00f719] text-[#00f719] p-4 font-mono text-xs uppercase">
                [// SUCCESS] : <?= e($succes) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="space-y-6 font-mono text-xs">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

            <div>
                <label class="block text-[#baccb0] uppercase tracking-wider mb-2">Titre du Projet *</label>
                <input type="text" name="titre" required value="<?= e($projet['titre']) ?>" class="w-full bg-[#0d1117] border border-[#30363d] focus:border-[#00f719] outline-none p-3 text-[#e2e2e2]">
            </div>

            <div>
                <label class="block text-[#baccb0] uppercase tracking-wider mb-2">Technologies utilisées *</label>
                <input type="text" name="technologies" required value="<?= e($projet['technologies']) ?>" class="w-full bg-[#0d1117] border border-[#30363d] focus:border-[#00f719] outline-none p-3 text-[#e2e2e2]">
            </div>

            <div>
                <label class="block text-[#baccb0] uppercase tracking-wider mb-2">Lien externe / GitHub</label>
                <input type="url" name="lien" value="<?= e($projet['lien']) ?>" class="w-full bg-[#0d1117] border border-[#30363d] focus:border-[#00f719] outline-none p-3 text-[#e2e2e2]">
            </div>

            <div>
                <label class="block text-[#baccb0] uppercase tracking-wider mb-2">Description complète *</label>
                <textarea name="description" rows="7" required class="w-full bg-[#0d1117] border border-[#30363d] focus:border-[#00f719] outline-none p-3 text-[#e2e2e2] leading-relaxed"><?= e($projet['description']) ?></textarea>
            </div>

            <div>
                <label class="block text-[#baccb0] uppercase tracking-wider mb-2">Visuel actuel</label>
                <div class="flex items-center gap-4 p-4 border border-[#30363d] bg-[#161b22]/30">
                    <?php if(!empty($projet['image'])): ?>
                        <img src="../../images/projets/<?= e($projet['image']) ?>" alt="Aperçu" class="w-20 h-20 object-cover border border-[#30363d]">
                    <?php endif; ?>
                    <div>
                        <p class="text-[#baccb0] mb-2">Remplacer l'image (Optionnel) :</p>
                        <input type="file" name="image" accept="image/*" class="text-xs text-[#baccb0]">
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-[#00f719] text-[#0d1117] font-bold px-8 py-3 hover:bg-[#00f719]/80 transition-colors uppercase tracking-wider">
                    EXECUTE_PATCH ➔
                </button>
            </div>
        </form>

    </main>

</body>
</html>