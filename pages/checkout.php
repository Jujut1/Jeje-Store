<?php
include '../includes/config.php';
if(!isset($_SESSION['user'])) {
    header('Location: ../admin/login.php');
    exit;
}

$product_id = $_GET['product'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if(!$product) die("Produk tidak ditemukan! 👾");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout - <?= $product['name'] ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="checkout-container">
        <h2>🛒 Checkout <span class="neon-text"><?= $product['name'] ?></span></h2>
        
        <form method="POST" action="process_order.php">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            
            <!-- Pilihan Variant Berdasarkan Kategori -->
            <div class="variant-section">
                <?php if($product['category'] == 'nokos'): ?>
                    <label><i class="fas fa-flag"></i> Pilih Negara:</label>
                    <select name="variant[country]" required>
                        <option value="US">Amerika Serikat</option>
                        <option value="ID">Indonesia</option>
                        <option value="SG">Singapura</option>
                        <option value="JP">Jepang</option>
                        <option value="custom">Custom (isi note)</option>
                    </select>
                    <label>Catatan Kustom:</label>
                    <input type="text" name="variant[note]" placeholder="Contoh: Nomor khusus, dll.">
                    
                <?php elseif($product['category'] == 'panel'): ?>
                    <label><i class="fas fa-sliders-h"></i> Tipe Panel:</label>
                    <select name="variant[panel_type]" required>
                        <option value="1gb">1GB - Rp 50.000</option>
                        <option value="5gb">5GB - Rp 150.000</option>
                        <option value="10gb">10GB - Rp 250.000</option>
                        <option value="unlimited">Unlimited - Rp 500.000</option>
                        <option value="adp">ADP - Rp 300.000</option>
                        <option value="own">Own Panel - Rp 1.000.000</option>
                    </select>
                    
                <?php elseif($product['category'] == 'script'): ?>
                    <p>⚠️ Script ini gratis, klik langsung download setelah checkout.</p>
                    <input type="hidden" name="variant[type]" value="free_download">
                <?php endif; ?>
            </div>
            
            <!-- QRIS Payment Section -->
            <div class="payment-section">
                <h3><i class="fas fa-qrcode"></i> Pembayaran QRIS</h3>
                <p>Total: <strong>Rp <?= number_format($product['price'],0,',','.') ?></strong></p>
                <div class="qris-display">
                    <img src="../uploads/qris/default.jpg" alt="QRIS" id="qrisImage">
                    <p>Scan QR di atas untuk pembayaran</p>
                </div>
                <label>Upload Bukti TF:</label>
                <input type="file" name="proof" accept="image/*">
            </div>
            
            <button type="submit" class="cta-button"><i class="fas fa-lock"></i> Konfirmasi Order</button>
        </form>
    </div>
</body>
</html>
