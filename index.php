<?php
session_start();
include '../includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Get dashboard statistics
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$pendingOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();
$confirmedOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'confirmed'")->fetchColumn();
$completedOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'completed'")->fetchColumn();
$totalRevenue = $pdo->query("SELECT SUM(total_amount) FROM orders WHERE status = 'completed'")->fetchColumn() ?? 0;
$todayRevenue = $pdo->query("SELECT SUM(total_amount) FROM orders WHERE status = 'completed' AND DATE(created_at) = CURDATE()")->fetchColumn() ?? 0;

// Get recent orders
$recentOrders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Savor Flavor</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .welcome-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #ecf0f1;
        }
        
        .welcome-header h1 {
            color: #2c3e50;
            margin: 0;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-info span {
            color: #7f8c8d;
        }
        
        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .logout-btn:hover {
            background: #c0392b;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .action-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s;
        }
        
        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .action-card h3 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .action-card p {
            color: #7f8c8d;
            margin: 0;
        }
        
        .revenue-chart {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            margin: 2rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .chart-placeholder {
            background: #f8f9fa;
            height: 200px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7f8c8d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="index.php" class="active">Dashboard</a></li>
                <li><a href="orders.php">Orders Management</a></li>
                <li><a href="menu.php">Menu Management</a></li>
                <li><a href="staff.php">Staff Management</a></li>
                <li><a href="logout.php" class="logout-btn">Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="welcome-header">
                <h1>Feedma Dashboard</h1>
                <div class="user-info">
                    <span>Welcome, Admin</span>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </div>
            </div>

            <!-- Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3><?php echo $totalOrders; ?></h3>
                    <p>Total Orders</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $pendingOrders; ?></h3>
                    <p>Pending Orders</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $confirmedOrders; ?></h3>
                    <p>Confirmed Orders</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $completedOrders; ?></h3>
                    <p>Completed Orders</p>
                </div>
                <div class="stat-card">
                    <h3>$<?php echo number_format($totalRevenue, 2); ?></h3>
                    <p>Total Revenue</p>
                </div>
                <div class="stat-card">
                    <h3>$<?php echo number_format($todayRevenue, 2); ?></h3>
                    <p>Today's Revenue</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="orders.php" class="action-card">
                    <h3>Manage Orders</h3>
                    <p>View and update orders</p>
                </a>
                <a href="menu.php" class="action-card">
                    <h3>Manage Menu</h3>
                    <p>Add/edit menu items</p>
                </a>
                <a href="staff.php" class="action-card">
                    <h3>Manage Staff</h3>
                    <p>Update staff information</p>
                </a>
                <a href="../index.php" class="action-card">
                    <h3>View Website</h3>
                    <p>Go to main website</p>
                </a>
            </div>

            <!-- Revenue Chart Placeholder -->
            <div class="revenue-chart">
                <h2>Revenue Overview</h2>
                <div class="chart-placeholder">
                    Revenue Chart - Would show monthly revenue data here
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="recent-orders">
                <h2>Recent Online Orders</h2>
                <?php if (count($recentOrders) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_phone']); ?></td>
                                    <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
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
                <?php else: ?>
                    <div style="background: white; padding: 2rem; text-align: center; border-radius: 8px;">
                        <p style="color: #7f8c8d; font-style: italic;">No orders found. Orders will appear here when customers place them.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- System Info -->
            <div class="stats-grid" style="margin-top: 2rem;">
                <div class="stat-card">
                    <h3><?php echo $pdo->query("SELECT COUNT(*) FROM menu_items")->fetchColumn(); ?></h3>
                    <p>Menu Items</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $pdo->query("SELECT COUNT(*) FROM staff")->fetchColumn(); ?></h3>
                    <p>Staff Members</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo date('M d, Y'); ?></h3>
                    <p>Today's Date</p>
                </div>
                <div class="stat-card">
                    <h3>Online</h3>
                    <p>System Status</p>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Auto-refresh dashboard every 30 seconds
        setInterval(() => {
            window.location.reload();
        }, 30000);

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>