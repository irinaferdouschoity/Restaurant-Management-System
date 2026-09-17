<?php include 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Savor Flavor - Restaurant</title>
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
        <section class="hero">
            <h1>Savor Flavor Simplify Service Online</h1>
            <p>The restaurant vendor's fees were expirators relative with stunning visuals and matching descriptions, setting the rings for a memorable dining experience.</p>
        </section>

        <section class="featured-recipes">
            <h2>HOT SELLING RECIPE amazing work</h2>
            <div class="recipes-grid">
                <?php
                $stmt = $pdo->query("SELECT * FROM menu_items LIMIT 4");
                while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "
                    <div class='recipe-card'>
                        <img src='{$item['image_path']}' alt='{$item['name']}' onerror=\"this.src='https://via.placeholder.com/300x200?text=Food+Image'\">
                        <h3>{$item['name']}</h3>
                        <p>{$item['description']}</p>
                        <div class='price'>\${$item['price']}</div>
                        <button onclick='addToCart({$item['id']})'>Add to Cart</button>
                    </div>";
                }
                ?>
            </div>
        </section>

        <section class="about-joy">
            <h2>Moat joir joy</h2>
            <p>Joir joy is famous in delightful forms of vibrant flavors, creating an equivalent of happiness with its unique and refreshing essence!</p>
        </section>

        <!-- About Section -->
        <section id="about" class="about-section">
            <div class="container">
                <h2>About Savor Flavor</h2>
                <p>Welcome to Savor Flavor, where culinary excellence meets exceptional service. Our chefs use only the freshest ingredients to create memorable dining experiences.</p>
                <p>Founded in 2020, we've been serving the community with passion and dedication to quality.</p>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="contact-section">
            <div class="container">
                <h2>Contact Us</h2>
                <div class="contact-info">
                    <p><strong>Address:</strong> 123 Restaurant Street, Food City</p>
                    <p><strong>Phone:</strong> (555) 123-4567</p>
                    <p><strong>Email:</strong> info@savorflavor.com</p>
                    <p><strong>Hours:</strong> Mon-Sun: 11:00 AM - 10:00 PM</p>
                </div>
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