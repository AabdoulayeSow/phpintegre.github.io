<?php 
// On inclut les fonctions au cas où elles ne l'auraient pas été plus haut
require_once('fonctions.php'); 
?>

<footer class="w-full py-12 px-6 mt-20 footer-border">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
        
        <div class="flex items-center gap-4">
            <span class="text-[#00F719] font-black font-headline">KINETIC_LOGIC</span>
            <span class="font-headline text-xs uppercase text-[#c8c6c5]">
                © <?php echo date('Y'); ?> KINETIC_LOGIC // SYSTEM_ARCHITECT // ALL RIGHTS RESERVED..
            </span>
        </div>

        <div class="flex gap-8">
            <?php 
                // Utilisation de la fonction pour tes réseaux sociaux
                generer_lien_social('https://www.linkedin.com/in/abdoulaye-sow-58b98b35a', 'LinkedIn');
                generer_lien_social('https://t.me/Abdallahso', 'Télégramme');
                generer_lien_social('https://github.com/dashboard', 'Github');
            ?>
        </div>
        
    </div>
</footer>