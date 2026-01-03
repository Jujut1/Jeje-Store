<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DarkStore | Jual Nokos, Panel, Script Bot WA</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header Misterius -->
    <header class="dark-header">
        <div class="container">
            <h1 class="logo">🕸️ DarkStore <span class="neon-text">MasterWeb</span></h1>
            <nav>
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <a href="pages/products.php?cat=nokos"><i class="fas fa-globe"></i> Nokos</a>
                <a href="pages/products.php?cat=panel"><i class="fas fa-server"></i> Panel</a>
                <a href="pages/products.php?cat=script"><i class="fas fa-robot"></i> Script Bot WA</a>
                <a href="cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="admin/dashboard.php"><i class="fas fa-crown"></i> Dashboard</a>
                    <a href="includes/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                <?php else: ?>
                    <a href="admin/login.php"><i class="fas fa-key"></i> Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h2 class="neon-text">🛒 Jual Beli <span class="typing">Nokos, Panel Pterodactyl, Script Bot WA</span></h2>
            <p>Panel 1-10GB • Unlimited • ADP • Own Panel • QRIS Payment • Free Download Script</p>
            <a href="#products" class="cta-button">🎃 Jelajahi Produk</a>
        </div>
    </section>

    <!-- Produk Unggulan -->
    <section id="products" class="products">
        <div class="container">
            <h2><i class="fas fa-star"></i> Produk Unggulan</h2>
            <div class="product-grid">
                <?php
                include 'includes/config.php';
                $stmt = $pdo->query("SELECT * FROM products LIMIT 3");
                while($row = $stmt->fetch()):
                ?>
                <div class="product-card">
                    <div class="product-icon">
                        <?php
                        $icon = $row['category']=='nokos'?'🌐':
                                ($row['category']=='panel'?'🖥️':'🤖');
                        echo $icon;
                        ?>
                    </div>
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <p><?= htmlspecialchars(substr($row['description'],0,100)) ?>...</p>
                    <div class="price">Rp <?= number_format($row['price'],0,',','.') ?></div>
                    <a href="pages/checkout.php?product=<?= $row['id'] ?>" class="buy-btn"><i class="fas fa-bolt"></i> Beli Sekarang</a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="dark-footer">
        <p>👻 Jeje Store &copy; 2023 - Jualan Digital dengan Mistis</p>
        <p>Powered by Pterodactyl & QRIS API</p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
