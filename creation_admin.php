<?php
// creation_admin.php
require_once('config/connexion.php');

// --- MODIFIE CES VALEURS POUR TON PROFESSEUR ---
$prenom = 'Cherif';
$nom = 'Diouf';
$email = 'cherif@gmail.com';
$mot_de_passe_clair = 'AdminSecret2026!'; // Note-le bien !

try {
    // Hachage du mot de passe (Indispensable pour la sécurité)
    $mdp_hash = password_hash($mot_de_passe_clair, PASSWORD_DEFAULT);

    // Insertion selon tes colonnes précises :
    // id est AUTO_INCREMENT, il ne faut pas l'inclure dans la requête.
    // date_creation est géré par NOW() ou DEFAULT CURRENT_TIMESTAMP.
    $sql = "INSERT INTO administrateurs (prenom, nom, email, mot_de_passe, date_creation) 
            VALUES (:prenom, :nom, :email, :mdp, NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'prenom' => $prenom,
        'nom'    => $nom,
        'email'  => $email,
        'mdp'    => $mdp_hash
    ]);

    echo "<h1>[// SUCCESS] : Compte administrateur créé.</h1>";
    echo "<p>Email de connexion : <strong>$email</strong></p>";
    echo "<p>Mot de passe : <strong>$mot_de_passe_clair</strong></p>";
    echo "<p style='color:red;'>ACTION REQUISE : Supprimez ce fichier 'creation_admin.php' immédiatement.</p>";

} catch (PDOException $e) {
    die("Erreur lors de la création : " . $e->getMessage());
}
?>