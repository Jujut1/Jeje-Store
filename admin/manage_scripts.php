<?php
include '../includes/auth.php';
adminOnly();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Script - DarkStore Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>🕶️ DarkMaster</h2>
            <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="manage_products.php"><i class="fas fa-box"></i> Produk</a>
            <a href="manage_scripts.php" class="active"><i class="fas fa-code"></i> Script Bot</a>
            <a href="manage_orders.php"><i class="fas fa-clipboard-list"></i> Order</a>
        </aside>
        
        <main class="content">
            <h1><i class="fas fa-robot"></i> Kelola File Script Bot WA</h1>
            
            <!-- Upload Script Baru -->
            <div class="card">
                <h3><i class="fas fa-upload"></i> Upload Script Baru</h3>
                <form action="upload_script.php" method="POST" enctype="multipart/form-data">
                    <label>Pilih Produk Script:</label>
                    <select name="product_id">
                        <?php
                        $stmt = $pdo->query("SELECT id,name FROM products WHERE category='script'");
                        while($row = $stmt->fetch()){
                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                        }
                        ?>
                    </select>
                    <label>File Script (ZIP/JS):</label>
                    <input type="file" name="script_file" required>
                    <button type="submit"><i class="fas fa-cloud-upload-alt"></i> Upload</button>
                </form>
            </div>
            
            <!-- Daftar Script -->
            <div class="card">
                <h3><i class="fas fa-list"></i> Script Tersedia</h3>
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>File</th>
                        <th>Download</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $stmt = $pdo->query("
                        SELECT s.*, p.name 
                        FROM scripts s 
                        JOIN products p ON s.product_id=p.id
                    ");
                    while($row = $stmt->fetch()):
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><code><?= htmlspecialchars(basename($row['file_path'])) ?></code></td>
                        <td><span class="badge"><?= $row['download_count'] ?>x</span></td>
                        <td>
                            <a href="../pages/download.php?script=<?= $row['id'] ?>" class="btn-small"><i class="fas fa-download"></i></a>
                            <a href="delete_script.php?id=<?= $row['id'] ?>" class="btn-small danger"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
