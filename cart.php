<?php
include 'database.php';
session_start();

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$product_ids = array_keys($cart);
$products = [];

if ($product_ids) {
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($product_ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$total = 0;
foreach ($products as $product) {
    $total += $product['price'] * $cart[$product['id']];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update quantities
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        if ($quantity == 0) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }

    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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
        <p>Home > Cart</p>
    </section>

    <section class="cart-header">
        <h1>Cart</h1>
    </section>

    <main class="cart-content">
        <form method="post" action="cart.php">
            <table border="1">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['name']; ?></td>
                        <td>$<?php echo $product['price']; ?></td>
                        <td>
                            <input type="number" name="quantity[<?php echo $product['id']; ?>]" value="<?php echo $cart[$product['id']]; ?>" min="0">
                        </td>
                        <td>$<?php echo $product['price'] * $cart[$product['id']]; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Total: $<?php echo $total; ?></p>
            <button type="submit">Update Cart</button>
        </form>
        <a href="checkout.php">Proceed to Checkout</a>
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
