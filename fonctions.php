<?php

/*

  1. INITIALISATION DU SYSTÈME & DES SESSIONS (SÉCURITÉ)

*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
  
  2. FONCTIONS DE NAVIGATION & COMPOSANTS

*/

/**
 * Génère un lien de navigation avec la classe "active" si c'est la page actuelle.
 */
function generer_lien_nav(string $nom_fichier, string $texte_lien) {
    $page_actuelle = basename($_SERVER['PHP_SELF']);
    $classe_active = ($page_actuelle === $nom_fichier) ? ' text-white border-b-2 border-[#00F719]' : ' text-gray-400 hover:text-white';
    
    echo '<a class="transition-colors font-medium' . $classe_active . '" href="./' . htmlspecialchars($nom_fichier, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($texte_lien, ENT_QUOTES, 'UTF-8') . '</a>';
}

/**
 * Affiche le bouton de connexion/admin dynamique dans la navbar
 */
function afficher_bouton_admin() {
    if (isset($_SESSION['admin_id'])) {
        echo '<a href="/admin/dashboard.php" class="bg-[#00F719] text-black px-4 py-2 rounded font-bold hover:bg-green-400 transition">Dashboard</a>';
    } else {
        echo '<a href="/admin/connexion.php" class="border border-[#00F719] text-[#00F719] px-4 py-2 rounded hover:bg-[#00F719] hover:text-black transition">Admin</a>';
    }
}

function generer_lien_social(string $url, string $plateforme) {
    echo '<a class="footer-link" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" target="_blank">' . htmlspecialchars($plateforme, ENT_QUOTES, 'UTF-8') . '</a>';
}


/*
 
  3. FONCTIONS DE VALIDATION & NETTOYAGE

*/

function champ_requis($valeur): bool {
    return !empty(trim((string)$valeur));
}

function nettoyer(string $valeur): string {
    return trim($valeur);
}

function valider_email(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}


/*

  4. EXIGENCES SÉCURITÉ OBLIGATOIRES (SECTION 3.2)

*/

function e(?string $valeur): string {
    return htmlspecialchars($valeur ?? '', ENT_QUOTES, 'UTF-8');
}

function genererTokenCSRF(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifier_csrf(?string $token_soumis): bool {
    if (!isset($_SESSION['csrf_token']) || empty($token_soumis)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token_soumis);
}


/*

  5. SÉCURISATION DE L'ESPACE D'ADMINISTRATION

*/

/**
 * Vérifie si l'admin est connecté.
 * Utilise un chemin relatif pour garantir la redirection.
 */
function verifierAuthentification(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['admin_id'])) {
        // Redirection relative sécurisée vers la page de connexion
        header('Location: ../admin/connexion.php');
        exit(); 
    }
}

/*
 
  6. JOURNALISATION DES VISITES

*/

function enregistrerVisite(PDO $pdo, string $nom_page) {
    $adresse_ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $liste_ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $adresse_ip = trim($liste_ips[0]);
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO visites (adresse_ip, page, date_visite) VALUES (:adresse_ip, :page, NOW())");
        $stmt->execute([
            'adresse_ip' => $adresse_ip,
            'page'       => $nom_page
        ]);
    } catch (PDOException $e) {
        error_log("Erreur de journalisation : " . $e->getMessage());
    }
}
?>
