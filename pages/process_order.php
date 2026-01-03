<?php
include '../includes/config.php';
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_SESSION['user_id'])){
    $product_id = $_POST['product_id'];
    $variant = json_encode($_POST['variant']);
    $user_id = $_SESSION['user_id'];
    
    // Ambil harga produk
    $stmt = $pdo->prepare("SELECT price FROM products WHERE id=?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    // Generate QRIS (simulasi)
    $qris_code = "00020101021126680014ID.CO.QRIS.WWW01189360091100225555550214555550303UMI51440014ID.CO.QRIS.WWW0215ID10200355550303UMI520454995802ID5915DarkStore Store6013Jakarta Selatan61051234062380114DM".time()."6304".strtoupper(md5(time()));
    
    // Simpan order
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, product_id, variant, total_price, qris_image, status) VALUES (?,?,?,?,?,?)");
    $stmt->execute([
        $user_id,
        $product_id,
        $variant,
        $product['price'],
        'qris_'.time().'.jpg',
        'pending'
    ]);
    
    $order_id = $pdo->lastInsertId();
    
    // Simpan payment info
    $stmt = $pdo->prepare("INSERT INTO payments (order_id, qris_code) VALUES (?,?)");
    $stmt->execute([$order_id, $qris_code]);
    
    // Redirect ke status order
    header("Location: order_status.php?order=".$order_id);
    exit;
}
?>
