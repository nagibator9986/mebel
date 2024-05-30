<?php
try {
    $pdo = new PDO('sqlite:ecommerce.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the image column exists
    $result = $pdo->query("PRAGMA table_info(products)");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);

    $columnExists = false;
    foreach ($columns as $column) {
        if ($column['name'] == 'image') {
            $columnExists = true;
            break;
        }
    }

    if (!$columnExists) {
        // Add the image column
        $pdo->exec("ALTER TABLE products ADD COLUMN image VARCHAR(255)");
        echo "Column 'image' added successfully.";
    } else {
        echo "Column 'image' already exists.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
