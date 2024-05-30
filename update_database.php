<?php
try {
    $pdo = new PDO('sqlite:ecommerce.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the orders table exists
    $result = $pdo->query("PRAGMA table_info(orders)");
    if ($result->fetchAll(PDO::FETCH_ASSOC) === []) {
        // Create orders table
        $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            total DECIMAL(10, 2) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            status VARCHAR(50) DEFAULT 'Pending',
            FOREIGN KEY (user_id) REFERENCES users(id)
        )");
        echo "Table 'orders' created successfully.<br>";
    } else {
        echo "Table 'orders' already exists.<br>";
    }

    // Check if the order_items table exists
    $result = $pdo->query("PRAGMA table_info(order_items)");
    if ($result->fetchAll(PDO::FETCH_ASSOC) === []) {
        // Create order_items table
        $pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER,
            product_id INTEGER,
            quantity INTEGER NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(id),
            FOREIGN KEY (product_id) REFERENCES products(id)
        )");
        echo "Table 'order_items' created successfully.<br>";
    } else {
        echo "Table 'order_items' already exists.<br>";
    }

    echo "Database updated successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
