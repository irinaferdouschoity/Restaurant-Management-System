<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle add staff
if ($_POST && isset($_POST['add_staff'])) {
    $stmt = $pdo->prepare("INSERT INTO staff (name, position, email, phone, image_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['position'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['image_path']
    ]);
    header('Location: staff.php');
    exit;
}

// Handle delete staff
if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM staff WHERE id = ?");
    $stmt->execute([$_GET['delete_id']]);
    header('Location: staff.php');
    exit;
}

$staff = $pdo->query("SELECT * FROM staff ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Staff Management</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="staff.php" class="active">Staff</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <h1>Staff Management</h1>
            
            <!-- Add New Staff Form -->
            <div class="form-section">
                <h2>Add New Staff Member</h2>
                <form method="POST">
                    <input type="text" name="name" placeholder="Full Name" required>
                    <input type="text" name="position" placeholder="Position" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="phone" placeholder="Phone" required>
                    <input type="text" name="image_path" placeholder="Image Path (e.g., images/staff/staff.jpg)" required>
                    <button type="submit" name="add_staff">Add Staff</button>
                </form>
            </div>

            <!-- Staff List -->
            <div class="staff-list">
                <h2>Current Staff</h2>
                <div class="staff-grid">
                    <?php foreach ($staff as $member): ?>
                        <div class="staff-card">
                            <img src="<?php echo $member['image_path']; ?>" alt="<?php echo htmlspecialchars($member['name']); ?>" 
                                 onerror="this.src='https://via.placeholder.com/150x150?text=Staff'">
                            <h3><?php echo htmlspecialchars($member['name']); ?></h3>
                            <p><strong>Position:</strong> <?php echo htmlspecialchars($member['position']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($member['email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($member['phone']); ?></p>
                            <a href="staff.php?delete_id=<?php echo $member['id']; ?>" 
                               onclick="return confirm('Delete this staff member?')" 
                               class="btn-delete">Delete</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>