<?php
// config/connexion.php

// Identifiants de production pour InfinityFree
//$host = 'sql101.infinityfree.com';
// $dbname = 'if0_41805682_portfolio';
// $username = 'if0_41805682';
// $password = 'CBvmnurgL2'; 

//<?php

// config/connexion.php
$host = 'localhost';
$dbname = 'portfolio';
$username = 'root';
$password = ''; // Vide par défaut sur XAMPP
try {

    // EXIGENCE 3.1 : Connexion PDO sécurisée avec l'encodage utf8mb4
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // EXIGENCE 3.1 : Activation du mode exception pour attraper les erreurs proprement
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Configuration du mode de récupération par défaut en tableau associatif
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // EXIGENCE 3.1 : Écrire l'erreur système réelle UNIQUEMENT dans les logs privés de XAMPP
    error_log("Erreur critique de connexion BDD : " . $e->getMessage());
    // EXIGENCE 3.1 : Afficher un message d'erreur générique et anonyme pour le navigateur
    die("ERREUR_CRITIQUE // SERVICES_INDISPONIBLES // Impossible d'établir la liaison avec les services de données.");

}

?>