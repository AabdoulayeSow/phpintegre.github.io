<nav class="fixed top-0 w-full z-50 nav-bg backdrop-blur-xl">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
        
        <div class="flex items-center gap-2 cursor-pointer active:scale-95 transition-transform">
            <span class="material-symbols-outlined text-[#00F719]">terminal</span>
            <span class="text-xl font-bold tracking-tighter text-[#00F719] font-headline">KINETIC_LOGIC</span>
        </div>

        <div class="flex items-center gap-8">
            <div class="hidden md:flex gap-8">
                <?php 
                    generer_lien_nav('index.php', 'Home'); 
                    generer_lien_nav('project.php', 'Projects'); 
                    generer_lien_nav('contact.php', 'Contact'); 
                ?>
            </div>

            <div>
                <?php if (isset($_SESSION['admin_id'])): ?>
                    <a href="admin/dashboard.php" class="bg-[#00F719] text-black px-4 py-2 rounded font-bold hover:bg-green-400 transition">
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="admin/connexion.php" class="border border-[#00F719] text-[#00F719] px-4 py-2 rounded hover:bg-[#00F719] hover:text-black transition">
                        Admin
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>