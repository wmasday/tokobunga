<?php
/**
 * Catalog Page - Professional Flower Collection
 * Sakura Florist Solo
 */
require_once 'config/db.php';

// Fetch Configuration
$stmt_conf = $pdo->query('SELECT * FROM config LIMIT 1');
$config = $stmt_conf->fetch();

// Filtering & Sorting Logic
$category_id = $_GET['category'] ?? 'all';
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'newest';

// Pagination Settings
$items_per_page = 12;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;

// 1. First, Count total matching items for pagination
$count_query = "SELECT COUNT(*) FROM flowers f LEFT JOIN categories c ON f.categories_id = c.id WHERE f.visible = 1";
if ($category_id !== 'all') {
    $count_query .= " AND f.categories_id = '" . (int)$category_id . "'";
}
if (!empty($search)) {
    $count_query .= " AND (f.name LIKE :search OR c.name LIKE :search)";
}

$stmt_count = $pdo->prepare($count_query);
if (!empty($search)) {
    $stmt_count->bindValue(':search', "%$search%", PDO::PARAM_STR);
}
$stmt_count->execute();
$total_items = $stmt_count->fetchColumn();
$total_pages = ceil($total_items / $items_per_page);

// 2. Adjust offset
$offset = ($current_page - 1) * $items_per_page;

// 3. Main Query with LIMIT & OFFSET
$query = "SELECT f.*, c.name as cat_name FROM flowers f LEFT JOIN categories c ON f.categories_id = c.id WHERE f.visible = 1";
$params = [];

if ($category_id !== 'all') {
    $query .= " AND f.categories_id = ?";
    $params[] = $category_id;
}

if (!empty($search)) {
    $query .= " AND (f.name LIKE ? OR c.name LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Sorting logic
switch ($sort) {
    case 'price_asc':
        $query .= " ORDER BY f.price ASC";
        break;
    case 'price_desc':
        $query .= " ORDER BY f.price DESC";
        break;
    case 'newest':
    default:
        $query .= " ORDER BY f.created_at DESC";
        break;
}

$query .= " LIMIT $items_per_page OFFSET $offset";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$flowers = $stmt->fetchAll();

// Fetch Categories for Filter
$categories = $pdo->query('SELECT * FROM categories WHERE visible = 1')->fetchAll();

// Fetch Dynamic Pages for Navbar
$nav_pages = $pdo->query('SELECT title, slug FROM pages WHERE visible = 1')->fetchAll();

$wa_number = $config['whatsapp'] ?? '081567883835';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Katalog Koleksi Bunga – <?php echo htmlspecialchars($config['title'] ?? 'Sakura Florist Solo'); ?></title>
    <meta name="description" content="Jelajahi berbagai pilihan karangan bunga premium dari Sakura Florist Solo.">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <style>
        .catalog-header { 
            background: linear-gradient(135deg, #FFF5F8 0%, #FFFFFF 100%); 
            padding: 150px 0 80px; 
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .catalog-header::after {
            content: '🌸';
            position: absolute;
            font-size: 20rem;
            opacity: 0.03;
            right: -50px;
            bottom: -50px;
            transform: rotate(-15deg);
        }
        
        .filter-section {
            margin-top: -30px;
            padding: 20px 0;
            position: relative;
            z-index: 10;
        }
        
        .search-box {
            position: relative;
            max-width: 400px;
        }
        .search-box input {
            border-radius: 12px;
            padding: 10px 20px 10px 45px;
            border: 1px solid #eef0f2;
            background: #f8fafc;
            transition: 0.3s;
            font-size: 0.95rem;
        }
        .search-box input:focus {
            background: #fff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(249, 70, 133, 0.05);
        }
        .search-box i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
        }
        
        .filter-pills {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .filter-btn {
            background: #f8fafc;
            color: #64748b;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: 0.3s;
            border: 1px solid #e2e8f0;
        }
        .filter-btn:hover, .filter-btn.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }
        
        .sort-select {
            border-radius: 12px;
            padding: 8px 15px;
            border: 1px solid #eef0f2;
            background: #f8fafc;
            color: #64748b;
            font-size: 0.9rem;
            cursor: pointer;
            outline: none;
            transition: 0.3s;
        }
        .sort-select:focus {
            border-color: var(--primary);
            background: #fff;
        }

        /* Pagination Styling */
        .pagination-container {
            margin-top: 50px;
        }
        .pagination .page-link {
            border: none;
            margin: 0 5px;
            border-radius: 12px;
            color: #64748b;
            font-weight: 500;
            padding: 10px 18px;
            transition: 0.3s;
            background: #f8fafc;
            border: 1px solid #eef0f2;
        }
        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 4px 12px rgba(249, 70, 133, 0.2);
        }
        .pagination .page-link:hover:not(.active) {
            background: #fff;
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Refined Flower Card Style */
        .flower-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border: 1px solid #f1f5f9;
        }
        .flower-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            border-color: rgba(249, 70, 133, 0.1);
        }
        
        .flower-img-wrapper {
            position: relative;
            overflow: hidden;
            background: #f8fafc;
            aspect-ratio: 4/5;
            width: 100%;
            height: auto;
        }
        .flower-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        .flower-card:hover .flower-img-wrapper img {
            transform: scale(1.08);
        }
        
        .flower-overlay {
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            padding: 20px;
            background: linear-gradient(to top, rgba(255,255,255,0.9), transparent);
            display: flex;
            justify-content: center;
            transition: 0.4s;
            opacity: 0;
        }
        .flower-card:hover .flower-overlay {
            bottom: 0;
            opacity: 1;
        }

        .flower-details {
            padding: 24px;
        }
        .flower-category {
            font-size: 0.75rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }
        .flower-title {
            color: #1e293b;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 12px;
            line-height: 1.4;
        }
        .flower-price {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
        }
        .flower-price::before {
            content: '';
            width: 4px;
            height: 4px;
            background: var(--primary);
            border-radius: 50%;
            margin-right: 10px;
            opacity: 0.5;
        }
        
        .no-results {
            padding: 100px 0;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .catalog-header { padding: 120px 0 60px; }
            .filter-section { margin-top: -30px; padding: 20px; }
            .flower-details { padding: 15px; }
            .flower-title { font-size: 0.95rem; margin-bottom: 8px; }
            .flower-price { font-size: 0.9rem; }
            .flower-category { font-size: 0.65rem; }
            .btn-order-whatsapp { padding: 8px 15px !important; font-size: 0.8rem !important; }
        }
    </style>
</head>
<body>

    <?php require_once 'components/navbar.php'; ?>

    <header class="catalog-header">
        <div class="container" data-aos="fade-up">
            <h1 class="display-3 mb-3">Koleksi Bunga Kami</h1>
            <p class="text-muted lead col-lg-6 mx-auto">Temukan berbagai pilihan karangan bunga segar dan papan bunga terbaik untuk setiap momen spesial Anda.</p>
        </div>
    </header>

    <div class="container pt-5">
        <!-- Filter & Search Section -->
        <div class="filter-section mb-5" data-aos="fade-up" data-aos-delay="100">
            <form action="/catalog" method="GET" id="catalogFilterForm">
                <!-- Top Row: Search & Sort -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div class="search-box flex-grow-1">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="form-control" placeholder="Cari karangan bunga..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="small text-muted d-none d-sm-block">Urutkan:</label>
                        <select name="sort" class="sort-select" onchange="document.getElementById('catalogFilterForm').submit()">
                            <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Terbaru</option>
                            <option value="price_asc" <?php echo $sort === 'price_asc' ? 'selected' : ''; ?>>Harga Terendah</option>
                            <option value="price_desc" <?php echo $sort === 'price_desc' ? 'selected' : ''; ?>>Harga Tertinggi</option>
                        </select>
                    </div>
                </div>

                <!-- Bottom Row: Categories -->
                <div class="filter-pills">
                    <a href="/catalog?category=all&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>" class="filter-btn <?php echo $category_id === 'all' ? 'active' : ''; ?>">Semua</a>
                    <?php foreach ($categories as $cat): ?>
                    <a href="/catalog?category=<?php echo $cat['id']; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>" class="filter-btn <?php echo $category_id == $cat['id'] ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </a>
                    <?php endforeach; ?>
                </div>

                <!-- Hidden Input to preserve category on sort change -->
                <input type="hidden" name="category" value="<?php echo $category_id; ?>">
            </form>
        </div>

        <!-- Flowers Grid -->
        <main class="py-4">
            <div class="row g-4 justify-content-start">
                <?php if ($flowers): ?>
                    <?php foreach ($flowers as $index => $flower): ?>
                    <div class="col-6 col-md-4 col-lg-3 catalog-item" data-aos="fade-up" data-aos-delay="<?php echo ($index % 4) * 100; ?>">
                        <div class="flower-card h-100">
                            <div class="flower-img-wrapper">
                                <a href="/flower/<?php echo $flower['id']; ?>">
                                    <img src="<?php echo (strpos($flower['image'], 'http') === 0 ? '' : '/') . $flower['image']; ?>" alt="<?php echo htmlspecialchars($flower['name']); ?>" loading="lazy">
                                </a>
                                <div class="flower-overlay">
                                    <a href="#" class="btn btn-white rounded-pill px-4 shadow-sm btn-order-whatsapp border-0" data-flower="<?php echo htmlspecialchars($flower['name']); ?>" data-wa="<?php echo $wa_number; ?>">
                                        <i class="fab fa-whatsapp text-success me-2"></i> Pesan Sekarang
                                    </a>
                                </div>
                            </div>
                            <div class="flower-details">
                                <span class="flower-category"><?php echo htmlspecialchars($flower['cat_name'] ?? 'Pilihan'); ?></span>
                                <a href="/flower/<?php echo $flower['id']; ?>" class="text-decoration-none text-dark">
                                    <h3 class="flower-title mb-2 hover-primary"><?php echo htmlspecialchars($flower['name']); ?></h3>
                                </a>
                                <div class="flower-price">
                                    Rp <?php echo number_format($flower['price'], 0, ',', '.'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-results" data-aos="fade-up">
                        <i class="fas fa-search fa-4x text-muted mb-4"></i>
                        <h3>Ups! Tidak ada hasil ditemukan.</h3>
                        <p class="text-muted">Coba gunakan kata kunci lain atau pilih kategori berbeda.</p>
                        <a href="/catalog" class="btn btn-primary rounded-pill px-4 mt-3">Reset Filter</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination Grid Footer -->
            <?php if ($total_pages > 1): ?>
            <div class="pagination-container d-flex justify-content-center" data-aos="fade-up">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <!-- Previous Page -->
                        <li class="page-item <?php echo $current_page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $current_page - 1; ?>&category=<?php echo urlencode($category_id); ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>" aria-label="Previous">
                                <i class="fas fa-chevron-left small"></i>
                            </a>
                        </li>

                        <!-- Page Numbers -->
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $current_page === $i ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&category=<?php echo urlencode($category_id); ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>

                        <!-- Next Page -->
                        <li class="page-item <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $current_page + 1; ?>&category=<?php echo urlencode($category_id); ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo $sort; ?>" aria-label="Next">
                                <i class="fas fa-chevron-right small"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <?php require_once 'components/footer.php'; ?>
</body>
</html>
