<?php
include 'includes/config.php';

if ($_POST) {
    try {
        $pdo->beginTransaction();
        
        // Calculate total from cart items
        $cartItems = json_decode($_POST['cart_items'], true);
        $total = 0;
        
        foreach ($cartItems as $itemId) {
            $stmt = $pdo->prepare("SELECT price FROM menu_items WHERE id = ?");
            $stmt->execute([$itemId]);
            $item = $stmt->fetch();
            if ($item) {
                $total += $item['price'];
            }
        }
        
        // Insert order
        $stmt = $pdo->prepare("INSERT INTO orders (customer_name, customer_phone, total_amount, order_type, table_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['customer_name'] ?? 'Unknown',
            $_POST['customer_phone'] ?? '',
            $total,
            $_POST['order_type'] ?? 'dine-in',
            $_POST['table_number'] ?? null
        ]);
        
        $orderId = $pdo->lastInsertId();
        
        // Insert order items
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, menu_item_id, quantity, price) VALUES (?, ?, 1, ?)");
        
        foreach ($cartItems as $itemId) {
            $itemStmt = $pdo->prepare("SELECT price FROM menu_items WHERE id = ?");
            $itemStmt->execute([$itemId]);
            $item = $itemStmt->fetch();
            
            if ($item) {
                $stmt->execute([$orderId, $itemId, $item['price']]);
            }
        }
        
        $pdo->commit();
        echo json_encode(['success' => true, 'order_id' => $orderId]);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No data received']);
}
?>