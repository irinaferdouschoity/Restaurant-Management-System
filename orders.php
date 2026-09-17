<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle order confirmation
if (isset($_GET['action']) && $_GET['action'] == 'confirm' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("UPDATE orders SET status = 'confirmed' WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    header('Location: orders.php');
    exit;
}

// Handle order completion
if (isset($_GET['action']) && $_GET['action'] == 'complete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("UPDATE orders SET status = 'completed' WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    header('Location: orders.php');
    exit;
}

$orders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Orders Management</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="orders.php" class="active">Orders</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="staff.php">Staff</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <h1>Orders Management</h1>
            
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['customer_phone']); ?></td>
                            <td>$<?php echo $order['total_amount']; ?></td>
                            <td><?php echo ucfirst($order['order_type']); ?></td>
                            <td>
                                <span class="status-<?php echo $order['status']; ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                            <td>
                                <?php if ($order['status'] == 'pending'): ?>
                                    <a href="orders.php?action=confirm&id=<?php echo $order['id']; ?>" class="btn-confirm">Confirm</a>
                                <?php elseif ($order['status'] == 'confirmed'): ?>
                                    <a href="orders.php?action=complete&id=<?php echo $order['id']; ?>" class="btn-complete">Complete</a>
                                <?php else: ?>
                                    <span class="btn-completed">Completed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>