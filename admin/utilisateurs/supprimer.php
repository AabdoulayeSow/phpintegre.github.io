<?php
// admin/utilisateurs/supprimer.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../config/connexion.php'); 
require_once('../../fonctions.php');

// 1. Protection d'accès stricte
verifierAuthentification();

// 2. EXIGENCE DE SÉCURITÉ : Vérifier que la requête provient bien d'un formulaire en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

$id_a_supprimer = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$id_connecte = isset($_SESSION['admin_id']) ? (int)$_SESSION['admin_id'] : 0;

// 3. Règles de gestion et de sécurité
if ($id_a_supprimer <= 0) {
    header('Location: index.php?erreur=INVALID_ID');
    exit();
}

if ($id_a_supprimer === $id_connecte) {
    // Impossible de s'auto-détruire pour éviter le verrouillage du système
    header('Location: index.php?erreur=AUTO_DESTRUCTION_DENIED');
    exit();
}

try {
    // 4. Requête préparée pour la suppression sécurisée
    $stmt = $pdo->prepare("DELETE FROM administrateurs WHERE id = :id");
    $stmt->execute(['id' => $id_a_supprimer]);

    // Redirection avec pavé de succès
    header('Location: index.php?statut=DELETED');
    exit();

} catch (PDOException $e) {
    error_log("Erreur Suppression Administrateur: " . $e->getMessage());
    header('Location: index.php?erreur=SQL_FAILURE');
    exit();
}