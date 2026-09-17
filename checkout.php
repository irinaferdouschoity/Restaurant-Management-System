<?php include 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Savor Flavor</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Savor Flavor</div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="cart.php">Cart</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="checkout-section">
            <h1>Checkout</h1>
            <form id="checkout-form">
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" name="customer_name" required>
                </div>
                <div class="form-group">
                    <label>Phone Number:</label>
                    <input type="tel" name="customer_phone" required>
                </div>
                <div class="form-group">
                    <label>Order Type:</label>
                    <select name="order_type">
                        <option value="dine-in">Dine In</option>
                        <option value="takeaway">Takeaway</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Table Number (if dine-in):</label>
                    <input type="text" name="table_number">
                </div>
                <button type="submit">Place Order</button>
            </form>
        </section>
    </main>

    <script>
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            
            fetch('place_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    ...Object.fromEntries(formData),
                    cart_items: JSON.stringify(cart)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    localStorage.removeItem('cart');
                    alert('Order placed successfully! Order ID: ' + data.order_id);
                    window.location.href = 'index.php';
                } else {
                    alert('Error: ' + data.error);
                }
            });
        });
    </script>
</body>
</html>