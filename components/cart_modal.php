<?php
// Cart Logic
$cartItems = [];
$cartTotal = 0;
if (isset($_SESSION['user_id'])) {
    $cartItems = $db->getUserCart($_SESSION['user_id']);
    $cartTotal = $db->getCartTotal($_SESSION['user_id']);
}
?>

<dialog id="cartModal" class="bg-transparent p-0 backdrop:bg-gray-900/60 open:animate-fade-in">
    <div class="bg-white w-[90vw] max-w-2xl rounded-2xl shadow-2xl flex flex-col max-h-[85vh] overflow-hidden">
        
        <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-white z-10">
            <div>
                <h3 class="text-2xl font-display text-karbono-dark">Your Offset Cart</h3>
                <p class="text-sm text-gray-500"><?php echo count($cartItems); ?> items pending checkout</p>
            </div>
            <button onclick="this.closest('dialog').close()" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-full transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">
            <?php if(empty($cartItems)): ?>
                <div class="h-full flex flex-col items-center justify-center text-center space-y-4 py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center text-gray-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-600">Your cart is empty</p>
                        <p class="text-sm text-gray-400">Start adding offsets to make an impact.</p>
                    </div>
                    <button onclick="document.getElementById('cartModal').close()" class="px-6 py-2 bg-karbono-green text-white rounded-lg font-bold text-sm hover:bg-green-600 transition">
                        Browse Marketplace
                    </button>
                </div>
            <?php else: ?>
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                            <th class="pb-3 pl-2">Product</th>
                            <th class="pb-3 text-center">Qty</th>
                            <th class="pb-3 text-right pr-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php foreach($cartItems as $item): ?>
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td class="py-4 pl-2">
                                <p class="font-bold text-gray-800"><?php echo htmlspecialchars($item['name']); ?></p>
                                <p class="text-xs text-gray-500">Price: ₱<?php echo number_format($item['price'], 2); ?></p>
                            </td>
                            <td class="py-4 text-center">
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-lg text-sm font-bold">
                                    x<?php echo $item['quantity']; ?>
                                </span>
                            </td>
                            <td class="py-4 text-right pr-2 font-bold text-karbono-green">
                                ₱<?php echo number_format($item['subtotal'], 2); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <?php if(!empty($cartItems)): ?>
        <div class="p-8 border-t border-gray-100 bg-gray-50 z-10">
            <div class="flex justify-between items-end mb-6">
                <span class="text-sm font-bold text-gray-500 uppercase tracking-wide">Total Contribution</span>
                <span class="text-4xl font-display text-karbono-dark">₱<?php echo number_format($cartTotal, 2); ?></span>
            </div>
            
            <form action="actions/checkout_code.php" method="POST">
                <button type="submit" class="w-full bg-karbono-green text-white py-4 rounded-xl font-bold text-lg hover:bg-green-600 active:scale-[0.99] transition-all shadow-xl shadow-green-200 flex items-center justify-center gap-2">
                    <span>Confirm & Checkout</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</dialog>