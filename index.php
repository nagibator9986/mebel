<?php
include 'database.php';

// Fetch categories
$stmt = $pdo->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch products
$stmt = $pdo->prepare("SELECT products.*, categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch recent products (simulate recent posts)
$recent_products = array_slice($products, 0, 3);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
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
            <a href="#">👤</a>
            <a href="cart.php">🛒</a>
        </div>
    </header>

    <section class="breadcrumb">
        <p>Home > Blog</p>
    </section>

    <section class="blog-header">
        <h1>Blog</h1>
    </section>

    <main class="blog-content">
        <section class="articles">
            <?php foreach ($products as $product): ?>
            <article>
                <img src="path/to/your/image.jpg" alt="Product Image">
                <div class="article-meta">
                    <span>👤 Admin</span>
                    <span>📅 <?php echo date('d M Y'); ?></span>
                    <span>🏷️ <?php echo $product['category_name']; ?></span>
                </div>
                <h2><?php echo $product['name']; ?></h2>
                <p><?php echo substr($product['description'], 0, 100); ?>...</p>
                <a href="#" class="read-more">Read more</a>
            </article>
            <?php endforeach; ?>
        </section>

        <aside class="sidebar">
            <div class="search-bar">
                <input type="text" placeholder="Search">
                <button>🔍</button>
            </div>
            <div class="categories">
                <h3>Categories</h3>
                <ul>
                    <?php foreach ($categories as $category): ?>
                    <li><?php echo $category['name']; ?> (<?php echo $category['post_count']; ?>)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="recent-posts">
                <h3>Recent Posts</h3>
                <ul>
                    <?php foreach ($recent_products as $recent): ?>
                    <li>
                        <img src="path/to/your/image.jpg" alt="Recent Product Image">
                        <div>
                            <h4><?php echo $recent['name']; ?></h4>
                            <p><?php echo date('d M Y'); ?></p>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>
    </main>

    <section class="pagination">
        <a href="#" class="page-link active">1</a>
        <a href="#" class="page-link">2</a>
        <a href="#" class="page-link">3</a>
        <a href="#" class="page-link">Next</a>
    </section>

    <section class="features">
        <div class="feature">
            <img src="quality-icon.png" alt="High Quality">
            <p>High Quality</p>
            <span>crafted from top materials</span>
        </div>
        <div class="feature">
            <img src="warranty-icon.png" alt="Warranty Protection">
            <p>Warranty Protection</p>
            <span>Over 2 years</span>
        </div>
        <div class="feature">
            <img src="shipping-icon.png" alt="Free Shipping">
            <p>Free Shipping</p>
            <span>Order over 150 $</span>
        </div>
        <div class="feature">
            <img src="support-icon.png" alt="24 / 7 Support">
            <p>24 / 7 Support</p>
            <span>Dedicated support</span>
        </div>
    </section>

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
