<?php
session_start();
require_once 'classes/database.php';
$db = new Database();
$products = $db->getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'components/header.php'; ?>
<body class="bg-gray-50 font-sans flex flex-col min-h-screen">

    <?php include 'components/navbar.php'; ?>

    <?php if(isset($_SESSION['swal'])): ?>
    <script>
        Swal.fire({
            icon: '<?php echo $_SESSION['swal']['icon']; ?>',
            title: '<?php echo $_SESSION['swal']['title']; ?>',
            text: '<?php echo $_SESSION['swal']['text'] ?? ''; ?>',
            confirmButtonColor: '#76B947'
        });
    </script>
    <?php unset($_SESSION['swal']); endif; ?>

    <div class="bg-karbono-green text-white relative overflow-hidden flex flex-col justify-center items-center text-center min-h-[40vh] px-4">
        <div class="relative z-10 max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-display mb-6 drop-shadow-sm leading-tight">Make the Invisible, Visible</h1>
            <p class="text-lg md:text-2xl font-light opacity-95 leading-relaxed max-w-2xl mx-auto">
                Track your emissions and offset your footprint starting at just <span class="font-bold text-yellow-300">₱2.50</span>.
            </p>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 flex-grow">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-karbono-dark">Eco-Marketplace</h2>
            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full"><?php echo count($products); ?> Items Available</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach($products as $product): ?>
            
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full relative hover:z-50">
                
                <div class="h-48 w-full relative rounded-t-2xl group z-10">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>" 
                             
                             /* EXPLANATION OF CLASSES:
                                left-1/2 -translate-x-1/2:  Centers image horizontally at all times.
                                bottom-0:                   Anchors image to the bottom seam.
                                origin-bottom:              Forces all growth to happen UPWARDS.
                                
                                -- HOVER STATES --
                                group-hover:h-[150%]:       Grows 50% taller (Upwards).
                                group-hover:w-[120%]:       Grows 20% wider (Centered expansion).
                             */
                             class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full h-full object-cover rounded-t-2xl transition-all duration-300 ease-out origin-bottom
                                    group-hover:h-[150%] group-hover:w-[120%] 
                                    group-hover:rounded-xl group-hover:shadow-2xl z-20"
                             
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"> 
                        
                        <div class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-300 rounded-t-2xl" style="display: none;">
                            <span class="font-display text-3xl opacity-30 select-none">Karbono</span>
                        </div>
                    <?php else: ?>
                        <div class="absolute inset-0 flex items-center justify-center bg-gray-50 rounded-t-2xl">
                             <span class="font-display text-3xl text-gray-300 opacity-30 select-none">Karbono</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="p-6 flex flex-col flex-grow bg-white rounded-b-2xl relative z-30">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 leading-tight"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-3 flex-grow"><?php echo htmlspecialchars($product['description']); ?></p>
                    
                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between mt-auto">
                        <span class="text-karbono-green font-bold text-2xl">₱<?php echo number_format($product['price'], 2); ?></span>
                        
                        <?php if(!isset($_SESSION['user_id']) || $_SESSION['role'] == 'guest_user'): ?>
                            <button onclick="document.getElementById('loginModal').showModal()" class="text-gray-400 text-sm font-semibold hover:text-karbono-green transition-colors">
                                Login to Buy
                            </button>
                        <?php else: ?>
                            <form action="actions/cart_code.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" class="bg-karbono-green hover:bg-green-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:shadow-lg transform active:scale-95 transition-all">
                                    Add to Cart
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'components/auth_modals.php'; ?>
    <?php include 'components/cart_modal.php'; ?>

</body>
</html>