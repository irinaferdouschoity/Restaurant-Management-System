<?php include 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Savor Flavor</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Savor Flavor</div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="cart.php">Cart (<span id="cart-count">0</span>)</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="cart-section">
            <h1>Your Cart</h1>
            <div id="cart-items">
                <!-- Cart items will be loaded here by JavaScript -->
            </div>
            <div class="cart-total">
                <h3>Total: $<span id="total-price">0</span></h3>
                <button onclick="checkout()">Proceed to Checkout</button>
            </div>
        </section>
    </main>

    <script>
        function loadCart() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            document.getElementById('cart-count').textContent = cart.length;
            
            if (cart.length === 0) {
                document.getElementById('cart-items').innerHTML = '<p>Your cart is empty</p>';
                return;
            }

            // Fetch cart items details from server
            fetch('get_cart_items.php?ids=' + cart.join(','))
                .then(response => response.json())
                .then(items => {
                    let html = '';
                    let total = 0;
                    
                    items.forEach(item => {
                        html += `
                            <div class="cart-item">
                                <img src="${item.image_path}" alt="${item.name}">
                                <div class="item-details">
                                    <h3>${item.name}</h3>
                                    <p>$${item.price}</p>
                                </div>
                                <button onclick="removeFromCart(${item.id})">Remove</button>
                            </div>
                        `;
                        total += parseFloat(item.price);
                    });
                    
                    document.getElementById('cart-items').innerHTML = html;
                    document.getElementById('total-price').textContent = total.toFixed(2);
                });
        }

        function removeFromCart(itemId) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart = cart.filter(id => id != itemId);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function checkout() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            
            window.location.href = 'checkout.php';
        }

        document.addEventListener('DOMContentLoaded', loadCart);
    </script>
</body>
</html>