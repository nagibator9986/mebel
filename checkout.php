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
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    if ($name && $surname && $address && $phone) {
        try {
            $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
            $stmt->execute([$_SESSION['user_id'], $total]);
            $order_id = $pdo->lastInsertId();

            foreach ($products as $product) {
                $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                $stmt->execute([$order_id, $product['id'], $cart[$product['id']], $product['price']]);
            }

            unset($_SESSION['cart']);
            header("Location: order_confirmation.php");
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
        <p>Home > Checkout</p>
    </section>

    <section class="checkout-header">
        <h1>Checkout</h1>
    </section>

    <main class="checkout-content">
        <form method="post" action="checkout.php">
            <label for="name">First Name:</label>
            <input type="text" id="name" name="name" required>
            <br>
            <label for="surname">Last Name:</label>
            <input type="text" id="surname" name="surname" required>
            <br>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            <br>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
            <br>
            <p>Total: $<?php echo $total; ?></p>
            <button type="submit">Place Order</button>
        </form>
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
