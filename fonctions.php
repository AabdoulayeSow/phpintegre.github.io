<?php

/*
  Génère un lien de navigation avec la classe "active" si c'est la page actuelle.
  Utilisé dans composants/navigation.php
 */
function generer_lien_nav(string $nom_fichier, string $texte_lien) {
    // 1. On récupère le nom de la page actuelle (ex: index.php)
    $page_actuelle = basename($_SERVER['PHP_SELF']);

    // 2. On vérifie si c'est la page active
    $classe_active = ($page_actuelle === $nom_fichier) ? ' active' : '';

    // 3. On affiche le code HTML proprement
    echo '<a class="nav-link' . $classe_active . '" href="./' . $nom_fichier . '">' . $texte_lien . '</a>';
}

/*
  Génère un lien de réseaux sociaux pour le footer.
  Utilisé dans composants/pied_page.php
 */
function generer_lien_social(string $url, string $plateforme) {
    echo '<a class="footer-link" href="' . $url . '" target="_blank">' . $plateforme . '</a>';
}
/*
  Vérifie qu'un champ n'est pas vide après nettoyage.
 */
function champ_requis(string $valeur): bool {
    return !empty(trim($valeur));
}

/*
  Nettoye une valeur pour l'afficher sans risque dans du HTML.
 */
function nettoyer(string $valeur): string {
    return htmlspecialchars(trim($valeur));
}
?>

