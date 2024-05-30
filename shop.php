<?php
include 'database.php';

// Fetch products
$stmt = $pdo->prepare("SELECT products.*, categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">Furniro</div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="login.php">👤</a>
            <a href="cart.php">🛒</a>
        </div>
    </header>

    <section class="breadcrumb">
        <p>Home > Shop</p>
    </section>

    <section class="shop-header">
        <h1>Shop</h1>
    </section>

    <main class="shop-content">
        <section class="products">
            <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h2><?php echo $product['name']; ?></h2>
                <p><?php echo substr($product['description'], 0, 100); ?>...</p>
                <p>Price: $<?php echo $product['price']; ?></p>
                <a href="product.php?id=<?php echo $product['id']; ?>" class="view-details">View Details</a>
            </div>
            <?php endforeach; ?>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="address">
                <h3>Furniro.</h3>
                <p>400 University Drive Suite 200 Coral Gables, FL 33134 USA</p>
            </div>
            <div class="links">
                <h3>Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="help">
                <h3>Help</h3>
                <ul>
                    <li><a href="#">Payment Options</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="#">Privacy Policies</a></li>
                </ul>
            </div>
            <div class="newsletter">
                <h3>Newsletter</h3>
                <input type="email" placeholder="Enter Your Email Address">
                <button>Subscribe</button>
            </div>
        </div>
        <p>2023 Furniro. All rights reserved</p>
    </footer>
</body>
</html>
