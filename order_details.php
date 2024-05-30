<?php
include 'database.php';
session_start();

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
    $stmt->execute([$order_id, $_SESSION['user_id']]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        $stmt = $pdo->prepare("SELECT order_items.*, products.name FROM order_items LEFT JOIN products ON order_items.product_id = products.id WHERE order_id = ?");
        $stmt->execute([$order_id]);
        $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        header("Location: order_history.php");
        exit;
    }
} else {
    header("Location: order_history.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
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
        <p>Home > Order History > Order Details</p>
    </section>

    <section class="order-details-header">
        <h1>Order Details</h1>
    </section>

    <main class="order-details-content">
        <table border="1">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo $item['price']; ?></td>
                    <td>$<?php echo $item['quantity'] * $item['price']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>Order Total: $<?php echo $order['total']; ?></p>
        <p>Order Date: <?php echo $order['created_at']; ?></p>
        <p>Order Status: <?php echo $order['status']; ?></p>
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
