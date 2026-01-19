<dialog id="loginModal" class="bg-transparent p-0 backdrop:bg-gray-900/60 open:animate-fade-in">
    <div class="bg-white w-[90vw] max-w-md p-8 rounded-2xl shadow-2xl relative flex flex-col gap-6">
        
        <div class="text-center relative">
            <button onclick="this.closest('dialog').close()" class="absolute -top-2 -right-2 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-3xl font-display text-karbono-dark">Welcome Back</h3>
            <p class="text-gray-500 text-sm mt-1">Login to continue your eco-journey.</p>
        </div>
        
        <form action="actions/auth_code.php" method="POST" class="flex flex-col gap-4">
            <input type="hidden" name="action" value="login">
            
            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider ml-1">Email Address</label>
                <input type="email" name="email" required 
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:border-karbono-green focus:ring-4 focus:ring-karbono-green/10 transition-all outline-none"
                    placeholder="you@example.com">
            </div>

            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider ml-1">Password</label>
                <input type="password" name="password" required 
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:border-karbono-green focus:ring-4 focus:ring-karbono-green/10 transition-all outline-none"
                    placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-karbono-green text-white font-bold py-3 rounded-xl hover:bg-green-600 active:scale-[0.98] transition-all shadow-lg shadow-green-200 mt-2">
                Sign In
            </button>
        </form>
        
        <div class="text-center border-t border-gray-100 pt-4">
            <p class="text-sm text-gray-500">
                New to Karbono? 
                <button onclick="document.getElementById('loginModal').close(); document.getElementById('registerModal').showModal()" class="text-karbono-orange font-bold hover:underline">
                    Create Account
                </button>
            </p>
        </div>
    </div>
</dialog>

<dialog id="registerModal" class="bg-transparent p-0 backdrop:bg-gray-900/60 open:animate-fade-in">
    <div class="bg-white w-[90vw] max-w-md p-8 rounded-2xl shadow-2xl relative flex flex-col gap-6">
        
        <div class="text-center relative">
            <button onclick="this.closest('dialog').close()" class="absolute -top-2 -right-2 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-3xl font-display text-karbono-dark">Join the Movement</h3>
            <p class="text-gray-500 text-sm mt-1">Start tracking your impact today.</p>
        </div>
        
        <form action="actions/auth_code.php" method="POST" class="flex flex-col gap-4">
            <input type="hidden" name="action" value="register">
            
            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider ml-1">Email Address</label>
                <input type="email" name="email" required 
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:border-karbono-green focus:ring-4 focus:ring-karbono-green/10 transition-all outline-none"
                    placeholder="you@example.com">
            </div>

            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider ml-1">Password</label>
                <input type="password" name="password" required 
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:border-karbono-green focus:ring-4 focus:ring-karbono-green/10 transition-all outline-none"
                    placeholder="••••••••">
            </div>

            <button type="submit" class="w-full bg-karbono-orange text-white font-bold py-3 rounded-xl hover:bg-orange-600 active:scale-[0.98] transition-all shadow-lg shadow-orange-200 mt-2">
                Send OTP Verification
            </button>
        </form>

        <div class="text-center border-t border-gray-100 pt-4">
            <p class="text-sm text-gray-500">
                Already have an account? 
                <button onclick="document.getElementById('registerModal').close(); document.getElementById('loginModal').showModal()" class="text-karbono-green font-bold hover:underline">
                    Login
                </button>
            </p>
        </div>
    </div>
</dialog>