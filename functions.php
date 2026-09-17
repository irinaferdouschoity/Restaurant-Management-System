<?php
function getOrderCount($pdo, $status = null) {
    if ($status) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE status = ?");
        $stmt->execute([$status]);
        return $stmt->fetchColumn();
    }
    return $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
}

function getTotalRevenue($pdo) {
    return $pdo->query("SELECT SUM(total_amount) FROM orders WHERE status = 'confirmed'")->fetchColumn() ?? 0;
}

function formatCurrency($amount) {
    return '$' . number_format($amount, 2);
}
?>