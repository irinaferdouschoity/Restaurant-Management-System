<?php include 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Savor Flavor</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Savor Flavor</div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="cart.php">Cart (<span id="cart-count">0</span>)</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="menu-section">
            <h1>Our Full Menu</h1>
            <div class="menu-grid">
                <?php
                $stmt = $pdo->query("SELECT * FROM menu_items");
                while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "
                    <div class='menu-item'>
                        <img src='{$item['image_path']}' alt='{$item['name']}' onerror=\"this.src='https://via.placeholder.com/300x200?text=Food+Image'\">
                        <div class='item-info'>
                            <h3>{$item['name']}</h3>
                            <p>{$item['description']}</p>
                            <div class='item-footer'>
                                <span class='price'>\${$item['price']}</span>
                                <button onclick='addToCart({$item['id']})'>Add to Cart</button>
                            </div>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Savor Flavor Restaurant. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function addToCart(itemId) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.push(itemId);
            localStorage.setItem('cart', JSON.stringify(cart));
            document.getElementById('cart-count').textContent = cart.length;
            alert('Item added to cart!');
        }

        document.addEventListener('DOMContentLoaded', function() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            document.getElementById('cart-count').textContent = cart.length;
        });
    </script>
</body>
</html>