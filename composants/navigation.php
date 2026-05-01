<?php 
// 1. On appelle le fichier de fonctions en tout premier
require_once('fonctions.php'); 
?>

<nav class="fixed top-0 w-full z-50 nav-bg backdrop-blur-xl">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
        
        <!-- Logo -->
        <div class="flex items-center gap-2 cursor-pointer active:scale-95 transition-transform">
            <span class="material-symbols-outlined text-[#00F719]">terminal</span>
            <span class="text-xl font-bold tracking-tighter text-[#00F719] font-headline">KINETIC_LOGIC</span>
        </div>

        <!-- Liens de navigation générés par PHP -->
        <div class="hidden md:flex gap-8">
            <?php 
                // La fonction s'occupe de tout : elle écrit le HTML et décide si le lien est "active"
                generer_lien_nav('index.php', 'Home'); 
                generer_lien_nav('project.php', 'Projects'); 
                generer_lien_nav('contact.php', 'Contact'); 
            ?>
        </div>
        
    </div>
</nav>