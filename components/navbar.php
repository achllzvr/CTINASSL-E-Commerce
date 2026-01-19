<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            
            <div class="flex items-center gap-3 h-full">
                <img src="assets/images/karbono_logo.png" alt="Karbono Logo" class="h-10 w-auto object-contain">
                <span class="text-2xl font-display text-karbono-green self-center pt-1">karbono</span>
            </div>
            
            <div class="flex items-center gap-6">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="text-right hidden sm:block">
                        <span class="block text-xs text-gray-400">Signed in as</span>
                        <span class="block text-sm font-bold text-karbono-dark"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                    </div>
                    
                    <?php if($_SESSION['role'] == 'regular_user'): ?>
                        <?php 
                            $cartCount = 0;
                            if (isset($db)) {
                                $cartCount = $db->getCartCount($_SESSION['user_id']);
                            }
                        ?>
                        <button onclick="document.getElementById('cartModal').showModal()" class="relative p-2 text-gray-400 hover:text-karbono-green transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            
                            <?php if($cartCount > 0): ?>
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full">
                                    <?php echo $cartCount; ?>
                                </span>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>

                    <?php if($_SESSION['role'] == 'admin_sec' || $_SESSION['role'] == 'staff_user'): ?>
                        <a href="dashboard.php" class="bg-gray-100 text-karbono-dark px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-200 transition">Dashboard</a>
                    <?php endif; ?>
                    
                    <a href="actions/auth_code.php?logout=true" class="text-sm text-red-500 font-bold hover:text-red-700 border border-red-200 px-4 py-2 rounded-lg hover:bg-red-50 transition">Logout</a>
                <?php else: ?>
                    <button onclick="document.getElementById('loginModal').showModal()" class="text-karbono-green font-bold hover:text-green-700">Login</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>