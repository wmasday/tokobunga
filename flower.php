<?php
/**
 * Flower Detail Page - Premium Edition
 * Sakura Florist Solo
 */
require_once 'config/db.php';

// Fetch Configuration
$stmt_conf = $pdo->query('SELECT * FROM config LIMIT 1');
$config = $stmt_conf->fetch();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    header('Location: /catalog');
    exit;
}

// Fetch Flower Data
$stmt = $pdo->prepare('SELECT f.*, c.name as cat_name FROM flowers f LEFT JOIN categories c ON f.categories_id = c.id WHERE f.id = ? AND f.visible = 1');
$stmt->execute([$id]);
$flower = $stmt->fetch();

if (!$flower) {
    // Return 404 or redirect
    header("HTTP/1.0 404 Not Found");
    echo "<h1 style='text-align:center; margin-top:20%'>Product Not Found 🌸</h1>";
    exit;
}

$wa_number = $config['whatsapp'] ?? '081567883835';
$wa_message_template = $config['wa_message'] ?? 'Halo Sakura Florist, saya ingin memesan: {{flower_name}}';
$wa_message = urlencode(str_replace('{{flower_name}}', $flower['name'], $wa_message_template));
$wa_link = "https://wa.me/{$wa_number}?text={$wa_message}";

// Fetch Pages for navbar
$nav_pages = $pdo->query('SELECT title, slug FROM pages WHERE visible = 1')->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($flower['name']); ?> – <?php echo htmlspecialchars($config['title'] ?? 'Sakura Florist Solo'); ?></title>
    
    <meta name="description" content="Pesan <?php echo htmlspecialchars($flower['name']); ?> sekarang di <?php echo htmlspecialchars($config['title'] ?? 'Sakura Florist Solo'); ?>. Kualitas terbaik untuk momen spesial Anda.">
    <meta property="og:title" content="<?php echo htmlspecialchars($flower['name']); ?> – Sakura Florist Solo">
    <meta property="og:image" content="<?php echo (strpos($flower['image'], 'http') === 0 ? '' : '/') . $flower['image']; ?>">
    <meta property="og:type" content="product">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <style>
        .product-page-header {
            background: linear-gradient(to right, #fdfbfb 0%, #ebedee 100%);
            padding: 120px 0 30px;
        }
        .detail-image-wrapper {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .detail-image-wrapper img {
            width: 100%;
            height: auto;
            max-height: 600px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .detail-image-wrapper:hover img {
            transform: scale(1.05);
        }
        .product-price {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary);
            margin: 20px 0;
            display: inline-block;
        }
        .product-badge {
            background: rgba(249, 70, 133, 0.1);
            color: var(--primary);
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .detail-description {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #4b5563;
        }
        .order-btn-large {
            padding: 15px 30px;
            font-size: 1.05rem;
            border-radius: 12px;
            font-weight: 600;
            background-color: #25D366;
            color: white;
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            text-decoration: none;
        }
        .order-btn-large:hover {
            background-color: #22c15c;
            color: white;
        }
        .features-list {
            list-style: none;
            padding: 0;
            margin: 30px 0;
        }
        .features-list li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            color: #64748b;
            font-weight: 500;
        }
        .features-list li i {
            color: var(--primary);
            margin-right: 12px;
            font-size: 1.2rem;
        }
        
        @media (min-width: 992px) {
            .product-sidebar {
                position: sticky;
                top: 100px;
            }
        }
    </style>
</head>
<body>

    <?php require_once 'components/navbar.php'; ?>

    <!-- Header spacing -->
    <div class="product-page-header">
        <div class="container" data-aos="fade-down">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Home</a></li>
                    <li class="breadcrumb-item"><a href="/catalog" class="text-decoration-none text-muted">Katalog</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($flower['name']); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Product Details Section -->
    <section class="py-5" style="background-color: #fafbfc;">
        <div class="container">
            <div class="row g-5 align-items-start">
                
                <!-- Product Image -->
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="detail-image-wrapper border border-white border-4">
                        <img src="<?php echo (strpos($flower['image'], 'http') === 0 ? '' : '/') . $flower['image']; ?>" alt="<?php echo htmlspecialchars($flower['name']); ?>">
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="product-sidebar bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                        <span class="product-badge mb-3 d-inline-block">
                            <i class="fas fa-tag me-2"></i> <?php echo htmlspecialchars($flower['cat_name'] ?? 'Koleksi Kami'); ?>
                        </span>
                        
                        <h1 class="display-5 fw-bold mb-3 text-dark"><?php echo htmlspecialchars($flower['name']); ?></h1>
                        
                        <div class="product-price">
                            Rp <?php echo number_format($flower['price'], 0, ',', '.'); ?>
                        </div>
                        
                        <hr class="my-4 border-light">
                        
                        <div class="detail-description mb-4">
                            <?php 
                            if (!empty($flower['description'])) {
                                echo $flower['description']; 
                            } else {
                                echo '<p>Rangkaian bunga elegan dan indah ini sangat cocok untuk memeriahkan hari spesial atau menyampaikan perasaan mendalam kepada orang terkasih. Dibuat dengan bunga segar pilihan dan dirangkai oleh florist profesional kami.</p>';
                            }
                            ?>
                        </div>
                        
                        <ul class="features-list">
                            <li><i class="fas fa-check-circle"></i> Bunga Segar Kualitas Premium</li>
                            <li><i class="fas fa-truck-fast"></i> Pengiriman Tepat Waktu</li>
                            <li><i class="fas fa-ribbon"></i> Gratis Kartu Ucapan / Pita</li>
                            <li><i class="fas fa-camera"></i> Foto Hasil Sebelum Dikirim</li>
                        </ul>
                        
                        <div class="mt-5">
                            <a href="<?php echo $wa_link; ?>" target="_blank" class="order-btn-large">
                                <i class="fab fa-whatsapp me-3 fa-lg"></i> Pesan via WhatsApp Sekarang
                            </a>
                            <p class="text-center text-muted small mt-3">
                                <i class="fas fa-shield-alt me-1"></i> Transaksi Aman & Terpercaya
                            </p>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    
    <!-- Related Items (Optional simple section) -->
    <section class="py-5 bg-white">
        <div class="container" data-aos="fade-up">
            <h3 class="fw-bold mb-4">Mungkin Anda Juga Suka</h3>
            <div class="row g-4">
                <?php
                // Fetch 4 related items randomly from same category
                $related_stmt = $pdo->prepare('SELECT f.*, c.name as cat_name FROM flowers f LEFT JOIN categories c ON f.categories_id = c.id WHERE f.categories_id = ? AND f.id != ? AND f.visible = 1 ORDER BY RAND() LIMIT 4');
                $related_stmt->execute([$flower['categories_id'], $flower['id']]);
                $related = $related_stmt->fetchAll();
                
                if (count($related) == 0) {
                    $related_stmt = $pdo->prepare('SELECT f.*, c.name as cat_name FROM flowers f LEFT JOIN categories c ON f.categories_id = c.id WHERE f.id != ? AND f.visible = 1 ORDER BY RAND() LIMIT 4');
                    $related_stmt->execute([$flower['id']]);
                    $related = $related_stmt->fetchAll();
                }

                foreach ($related as $rel):
                ?>
                <div class="col-6 col-md-3">
                    <div class="flower-card shadow-sm h-100 border">
                        <div class="flower-img-wrapper" style="aspect-ratio: 1/1;">
                            <a href="/flower/<?php echo $rel['id']; ?>">
                                <img src="<?php echo (strpos($rel['image'], 'http') === 0 ? '' : '/') . $rel['image']; ?>" alt="<?php echo htmlspecialchars($rel['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            </a>
                        </div>
                        <div class="p-3 text-center">
                            <a href="/flower/<?php echo $rel['id']; ?>" class="text-decoration-none text-dark">
                                <h5 class="mb-1 fw-bold fs-6 text-truncate"><?php echo htmlspecialchars($rel['name']); ?></h5>
                            </a>
                            <p class="text-primary fw-bold mb-0 small">Rp <?php echo number_format($rel['price'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php require_once 'components/footer.php'; ?>
</body>
</html>
