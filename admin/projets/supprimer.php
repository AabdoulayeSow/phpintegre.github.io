<?php
// admin/projets/supprimer.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../config/connexion.php'); 
require_once('../../fonctions.php');

// 1. EXIGENCE PROF : Protection d'accès de l'opérateur
verifierAuthentification();

// 2. Récupération et validation stricte de l'identifiant par URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    try {
        // 3. EXIGENCE PROF : Récupérer le nom de l'image avant de supprimer la ligne en BDD
        $stmt_image = $pdo->prepare("SELECT image FROM projets WHERE id = :id");
        $stmt_image->execute(['id' => $id]);
        $projet = $stmt_image->fetch();

        if ($projet) {
            // 4. EXIGENCE QUALITÉ : Destruction physique du fichier image sur le serveur
            if (!empty($projet['image'])) {
                $chemin_image = '../../images/projets/' . $projet['image'];
                if (file_exists($chemin_image)) {
                    unlink($chemin_image); // Supprime l'image du disque
                }
            }

            // 5. EXIGENCE PROF : Requête préparée pour l'effacement en BDD
            $stmt_delete = $pdo->prepare("DELETE FROM projets WHERE id = :id");
            $stmt_delete->execute(['id' => $id]);
        }

    } catch (PDOException $e) {
        // Enregistrement de l'erreur dans les logs système cachés
        error_log("Erreur Suppression Projet: " . $e->getMessage());
        die("LOG_ERROR // CRITICAL_DELETE_FAILURE // Opération avortée par le noyau.");
    }
}

// 6. Redirection automatique vers le répertoire mis à jour
header('Location: index.php');
exit();