<?php
/**
 * Sakura Florist Solo - Official Website
 * Promotional website for flower arrangements in Surakarta.
 */
require_once 'config/db.php';

// Fetch Configuration
$stmt = $pdo->query('SELECT * FROM config LIMIT 1');
$config = $stmt->fetch();

// Fetch Categories
$categories = $pdo->query('SELECT * FROM categories WHERE visible = 1')->fetchAll();

// Fetch Flowers
$flowers = $pdo->query('SELECT f.*, c.name as cat_name FROM flowers f LEFT JOIN categories c ON f.categories_id = c.id WHERE f.visible = 1 ORDER BY f.created_at DESC')->fetchAll();

// Fetch Dynamic Pages for Navbar
$nav_pages = $pdo->query('SELECT title, slug FROM pages WHERE visible = 1')->fetchAll();

// Default WA
$wa_number = $config['whatsapp'] ?? '081567883835';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Metadata -->
    <title><?php echo htmlspecialchars($config['title'] ?? 'Sakura Florist Solo'); ?> – Karangan Bunga Surakarta</title>
    <meta name="description" content="<?php echo htmlspecialchars($config['description'] ?? ''); ?>">
    <meta name="keywords" content="Florist Surakarta, Karangan Bunga Solo, Sakura Florist Solo, Toko Bunga Solo, Karangan Bunga Papan Solo">
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($config['title'] ?? 'Sakura Florist Solo'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($config['description'] ?? ''); ?>">
    <meta property="og:image" content="<?php echo $config['logo'] ? $config['logo'] : 'assets/img/icon.png'; ?>">
    <meta property="og:type" content="website">

    <!-- Favicon -->
    <?php if ($config['favicon']): ?>
    <link rel="icon" type="image/x-icon" href="<?php echo (strpos($config['favicon'], 'http') === 0 ? '' : '/') . $config['favicon']; ?>">
    <?php endif; ?>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Florist",
      "name": "<?php echo htmlspecialchars($config['title'] ?? 'Sakura Florist Solo'); ?>",
      "image": "<?php echo $config['logo'] ? $config['logo'] : ''; ?>",
      "url": "<?php echo (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>",
      "telephone": "<?php echo $wa_number; ?>",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?php echo htmlspecialchars($config['address'] ?? 'Surakarta'); ?>",
        "addressLocality": "Solo",
        "addressRegion": "Jawa Tengah",
        "postalCode": "57126",
        "addressCountry": "ID"
      }
    }
    </script>
</head>
<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="100">

    <?php require_once 'components/navbar.php'; ?>

    <!-- Hero Section -->
    <header id="heroSection">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 text-center text-lg-start">
                    <div data-aos="fade-right" data-aos-duration="1200">
                        <span class="badge rounded-pill bg-light text-primary mb-3 px-3 py-2 border">Premium Florist Surakarta</span>
                        <h1 class="hero-title"><?php echo htmlspecialchars($config['title'] ?? 'SAKURA FLORIST SOLO'); ?></h1>
                        <p class="hero-subtitle mx-auto mx-lg-0">
                            Menyediakan berbagai pilihan bunga segar dan karangan bunga elegan untuk setiap momen berharga Anda di area Surakarta dan sekitarnya.
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start mt-4">
                            <a href="#" class="btn-whatsapp btn-order-whatsapp" data-wa="<?php echo $wa_number; ?>">
                                <i class="fab fa-whatsapp"></i> Order via WhatsApp
                            </a>
                            <a href="/catalog" class="btn btn-outline-dark rounded-pill px-5 py-3 fw-semibold">
                                <i class="fas fa-search me-2"></i> Jelajahi Katalog
                            </a>
                        </div>
                        <div class="mt-5 d-flex gap-4 justify-content-center justify-content-lg-start text-muted small">
                            <span><i class="fas fa-check-circle text-primary me-2"></i> Free Delivery Solo</span>
                            <span><i class="fas fa-check-circle text-primary me-2"></i> 24/7 Service</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" data-aos="zoom-in" data-aos-delay="200">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1526047932273-341f2a7631f9?q=80&w=1000&auto=format&fit=crop" class="img-fluid rounded-4 shadow-lg border border-3 border-white" alt="Sakura Florist Hero">
                        <div class="glass-card p-3 position-absolute bottom-0 start-0 m-4 shadow text-center d-none d-md-block" data-aos="fade-up" data-aos-delay="600">
                            <h5 class="mb-0 text-primary">1000+</h5>
                            <small class="text-muted">Happy Clients</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Flower Catalog Section -->
    <section id="catalog">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-title" data-aos="fade-up">
                    <h5 class="text-primary text-uppercase letter-spacing-2 mb-3">Produk Unggulan</h5>
                    <h2>Katalog Bunga Kami</h2>
                </div>
                <p class="text-muted max-w-600 mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Pilih rangkaian bunga terbaik dengan desain modern dan bunga segar pilihan untuk orang tersayang.
                </p>
                <div class="mt-5 d-flex flex-wrap justify-content-center gap-2" data-aos="fade-up" data-aos-delay="200">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    <?php foreach ($categories as $cat): ?>
                    <button class="filter-btn" data-filter="cat-<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></button>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="row g-4 mt-2" id="flowerCatalog">
                <?php foreach ($flowers as $flower): ?>
                <div class="col-sm-6 col-lg-4 flower-item cat-<?php echo $flower['categories_id']; ?>" data-aos="fade-up">
                    <div class="flower-card shadow-sm">
                        <div class="flower-img-wrapper">
                            <a href="/flower/<?php echo $flower['id']; ?>">
                                <img src="<?php echo (strpos($flower['image'], 'http') === 0 ? '' : '/') . $flower['image']; ?>" alt="<?php echo htmlspecialchars($flower['name']); ?>" loading="lazy">
                            </a>
                            <div class="flower-overlay">
                                <a href="#" class="btn btn-light rounded-pill px-4 shadow-sm btn-order-whatsapp" data-flower="<?php echo htmlspecialchars($flower['name']); ?>" data-wa="<?php echo $wa_number; ?>">
                                    <i class="fab fa-whatsapp text-success me-2"></i> Pesan Sekarang
                                </a>
                            </div>
                        </div>
                        <div class="p-4 text-center">
                            <a href="/flower/<?php echo $flower['id']; ?>" class="text-decoration-none text-dark">
                                <h4 class="mb-2 h5 hover-primary"><?php echo htmlspecialchars($flower['name']); ?></h4>
                            </a>
                            <p class="text-primary fw-semibold h5 mb-0">Rp <?php echo number_format($flower['price'], 0, ',', '.'); ?></p>
                            <small class="text-muted mt-2 d-block"><?php echo htmlspecialchars($flower['cat_name'] ?? 'Uncategorized'); ?></small>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="bg-light">
        <div class="container">
            <div class="text-center mb-3">
                <div class="section-title" data-aos="fade-up">
                    <h5 class="text-primary text-uppercase letter-spacing-2 mb-3">Galeri Karya</h5>
                    <h2>Sentuhan Estetika Kami</h2>
                </div>
            </div>
            <div id="flowerCarousel" class="carousel slide shadow-lg rounded-4 overflow-hidden border border-5 border-white" data-bs-ride="carousel" data-aos="zoom-out">
                <div class="carousel-inner">
                    <?php 
                    $gallery_stmt = $pdo->query('SELECT image, name FROM flowers WHERE visible = 1 LIMIT 5');
                    $gallery_items = $gallery_stmt->fetchAll();
                    foreach ($gallery_items as $index => $item): 
                    ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <img src="<?php echo (strpos($item['image'], 'http') === 0 ? '' : '/') . $item['image']; ?>" class="d-block w-100" style="height: 600px; object-fit: cover;" alt="<?php echo htmlspecialchars($item['name']); ?>" loading="lazy">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 class="bg-dark bg-opacity-25 backdrop-blur p-3 d-inline-block rounded-pill mb-4 border border-white border-opacity-25"><?php echo htmlspecialchars($item['name']); ?></h5>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#flowerCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#flowerCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Contact & Stats Section -->
    <section id="contact">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="section-title">
                        <h5 class="text-primary text-uppercase letter-spacing-2 mb-3">Hubungi Kami</h5>
                        <h2>Ada Pertanyaan? Kami Siap Membantu</h2>
                    </div>
                    <p class="text-muted mb-5">
                        Layanan pelanggan kami tersedia 24 jam untuk membantu Anda memilih karangan bunga terbaik. Jangan ragu untuk berkonsultasi mengenai desain dan budget Anda.
                    </p>
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-4 me-3">
                            <i class="fas fa-location-dot text-primary h4 mb-0"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Alamat Workshop</h6>
                            <p class="mb-0 small text-muted"><?php echo htmlspecialchars($config['address'] ?? 'SURAKARTA, Jawa Tengah'); ?></p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-4 me-3">
                            <i class="fab fa-facebook-f text-primary h4 mb-0"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Social Media</h6>
                            <p class="mb-0 small text-muted">@sakurafloristsolo</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="glass-card p-5 text-center">
                        <h3 class="mb-4">Konsultasi Desain & Harga</h3>
                        <p class="mb-5">Klik tombol di bawah untuk terhubung langsung dengan desainer bunga kami.</p>
                        <a href="#" class="btn-whatsapp btn-order-whatsapp btn-lg" data-wa="<?php echo $wa_number; ?>">
                            <i class="fab fa-whatsapp"></i> Chat WhatsApp
                        </a>
                        <div class="row mt-5 g-4">
                            <div class="col-4 border-end">
                                <h4 class="text-primary mb-0">2 Jam</h4>
                                <small class="text-muted">Proses Kilat</small>
                            </div>
                            <div class="col-4 border-end">
                                <h4 class="text-primary mb-0">Fresh</h4>
                                <small class="text-muted">Bunga Segar</small>
                            </div>
                            <div class="col-4">
                                <h4 class="text-primary mb-0">Best</h4>
                                <small class="text-muted">Kualitas Pro</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php require_once 'components/footer.php'; ?>
</body>
</html>
