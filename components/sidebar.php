<aside class="w-64 bg-karbono-dark text-white flex-shrink-0 flex flex-col shadow-xl z-10">
    
    <div class="p-6 flex items-center gap-3 border-b border-gray-700">
        <img src="assets/images/karbono_logo.png" alt="Logo" class="h-8 w-auto">
        <div>
            <h1 class="text-xl font-display text-karbono-green">Karbono</h1>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest leading-none mt-1">
                <?php echo $_SESSION['role'] == 'admin_sec' ? 'Admin Panel' : 'Staff Panel'; ?>
            </p>
        </div>
    </div>
    
    <nav class="mt-6 flex-grow">
        <a href="index.php" class="flex items-center gap-3 py-3 px-6 hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">
            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Shop
        </a>
        <a href="#" class="flex items-center gap-3 py-3 px-6 bg-gray-800 border-l-4 border-karbono-green text-white font-bold">
            <svg class="w-5 h-5 text-karbono-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Overview
        </a>
    </nav>
    
    <div class="p-6 border-t border-gray-700">
            <a href="actions/auth_code.php?logout=true" class="flex items-center gap-2 text-sm text-red-400 hover:text-red-300 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Sign Out
            </a>
    </div>
</aside>