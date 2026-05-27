<?php
// admin/deconnexion.php

// 1. On démarre la session pour pouvoir y accéder et la détruire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. On vide toutes les variables de session
$_SESSION = [];

// 3. Si un cookie de session existe, on le détruit également (Sécurité maximale)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// 4. On détruit officiellement la session sur le serveur
session_destroy();

// 5. Redirection immédiate vers la page de connexion de l'espace admin
header('Location: connexion.php');
exit();