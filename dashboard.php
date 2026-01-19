<?php
session_start();
require_once 'classes/database.php';

// Security Guard
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin_sec' && $_SESSION['role'] !== 'staff_user')) {
    header("Location: index.php");
    exit();
}

$db = new Database();
$orders = $db->getPendingOrders();
$logs = ($_SESSION['role'] === 'admin_sec') ? $db->getAuditLogs() : [];
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'components/header.php'; ?>
<body class="bg-gray-100 font-sans flex min-h-screen">

    <?php include 'components/sidebar.php'; ?>

    <main class="flex-1 p-8 overflow-y-auto">
        
        <header class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>
                <p class="text-gray-500 text-sm mt-1">Welcome back, <?php echo htmlspecialchars($_SESSION['email']); ?></p>
            </div>
            <div class="text-sm bg-white px-4 py-2 rounded-lg shadow-sm text-gray-600 border border-gray-200">
                Current Time: <span class="font-mono font-bold"><?php echo date('H:i'); ?></span>
            </div>
        </header>

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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Pending Orders</h3>
                    <p class="text-4xl font-bold text-karbono-dark"><?php echo count($orders); ?></p>
                </div>
                <div class="p-3 bg-blue-50 text-blue-500 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
            
             <?php if($_SESSION['role'] === 'admin_sec'): ?>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Security Events</h3>
                    <p class="text-4xl font-bold text-red-600"><?php echo count($logs); ?></p>
                </div>
                <div class="p-3 bg-red-50 text-red-500 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>
             <?php endif; ?>
        </div>

        <div class="bg-white rounded-2xl shadow-sm mb-8 overflow-hidden border border-gray-100">
            <div class="px-8 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800">Pending Approvals</h3>
                <span class="text-xs font-medium bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full">Requires Action</span>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wider">
                        <th class="px-8 py-4 font-semibold">Order ID</th>
                        <th class="px-8 py-4 font-semibold">User Email</th>
                        <th class="px-8 py-4 font-semibold">Amount</th>
                        <th class="px-8 py-4 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if(empty($orders)): ?>
                        <tr><td colspan="4" class="px-8 py-8 text-center text-gray-400 italic">No pending orders found.</td></tr>
                    <?php endif; ?>
                    
                    <?php foreach($orders as $order): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-8 py-4 font-mono text-sm text-gray-600">#<?php echo $order['id']; ?></td>
                        <td class="px-8 py-4 font-medium text-gray-800"><?php echo htmlspecialchars($order['email']); ?></td>
                        <td class="px-8 py-4 font-bold text-karbono-green">₱<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td class="px-8 py-4 text-right">
                            <form action="actions/order_code.php" method="POST">
                                <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                <input type="hidden" name="action" value="approve">
                                <button class="bg-karbono-green text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-green-600 transition shadow-sm hover:shadow-md">
                                    Approve & Email
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if($_SESSION['role'] === 'admin_sec'): ?>
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-red-100">
            <div class="px-8 py-5 border-b border-red-100 bg-red-50/50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-red-900">Security Audit Trail</h3>
                <span class="text-xs bg-red-200 text-red-800 px-2.5 py-1 rounded-full font-bold">Confidential</span>
            </div>
            <div class="max-h-96 overflow-y-auto">
                <table class="w-full text-left">
                    <thead class="sticky top-0 bg-white shadow-sm z-10">
                        <tr class="text-xs text-gray-400 uppercase tracking-wider border-b">
                            <th class="px-8 py-3 bg-gray-50">Timestamp</th>
                            <th class="px-8 py-3 bg-gray-50">Event Type</th>
                            <th class="px-8 py-3 bg-gray-50">User ID</th>
                            <th class="px-8 py-3 bg-gray-50">IP Address</th>
                            <th class="px-8 py-3 bg-gray-50">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        <?php foreach($logs as $log): ?>
                        <tr class="group hover:bg-red-50/30 transition-colors">
                            <td class="px-8 py-3 text-gray-500 whitespace-nowrap"><?php echo $log['created_at']; ?></td>
                            <td class="px-8 py-3 font-bold <?php echo strpos($log['action'], 'Failed') !== false || strpos($log['action'], 'Locked') !== false ? 'text-red-600' : 'text-blue-600'; ?>">
                                <?php echo htmlspecialchars($log['action']); ?>
                            </td>
                            <td class="px-8 py-3 text-gray-600 font-mono"><?php echo $log['user_id'] ?: '<span class="text-gray-300">-</span>'; ?></td>
                            <td class="px-8 py-3 font-mono text-xs text-gray-500"><?php echo $log['ip_address']; ?></td>
                            <td class="px-8 py-3 text-gray-600"><?php echo htmlspecialchars($log['details']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </main>
</body>
</html>