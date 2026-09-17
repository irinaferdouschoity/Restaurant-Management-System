<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle add menu item
if ($_POST && isset($_POST['add_item'])) {
    $stmt = $pdo->prepare("INSERT INTO menu_items (name, description, price, category, image_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['description'],
        $_POST['price'],
        $_POST['category'],
        $_POST['image_path']
    ]);
    header('Location: menu.php');
    exit;
}

// Handle delete menu item
if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->execute([$_GET['delete_id']]);
    header('Location: menu.php');
    exit;
}

$menu_items = $pdo->query("SELECT * FROM menu_items ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Menu Management</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="menu.php" class="active">Menu</a></li>
                <li><a href="staff.php">Staff</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <h1>Menu Management</h1>
            
            <!-- Add New Item Form -->
            <div class="form-section">
                <h2>Add New Menu Item</h2>
                <form method="POST">
                    <input type="text" name="name" placeholder="Item Name" required>
                    <textarea name="description" placeholder="Description" required></textarea>
                    <input type="number" step="0.01" name="price" placeholder="Price" required>
                    <input type="text" name="category" placeholder="Category" required>
                    <input type="text" name="image_path" placeholder="Image Path (e.g., images/food/item.jpg)" required>
                    <button type="submit" name="add_item">Add Item</button>
                </form>
            </div>

            <!-- Menu Items List -->
            <div class="items-list">
                <h2>Current Menu Items</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menu_items as $item): ?>
                            <tr>
                                <td><?php echo $item['id']; ?></td>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo htmlspecialchars($item['description']); ?></td>
                                <td>$<?php echo $item['price']; ?></td>
                                <td><?php echo htmlspecialchars($item['category']); ?></td>
                                <td>
                                    <a href="menu.php?delete_id=<?php echo $item['id']; ?>" 
                                       onclick="return confirm('Delete this item?')" 
                                       class="btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>