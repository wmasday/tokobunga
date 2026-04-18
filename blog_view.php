<?php
/**
 * Blog Detail Page
 * Sakura Florist Solo
 */
require_once 'config/db.php';

$slug = $_GET['slug'] ?? '';

// Fetch Blog Data
$stmt = $pdo->prepare('SELECT * FROM blogs WHERE slug = ? AND visible = 1 LIMIT 1');
$stmt->execute([$slug]);
$blog = $stmt->fetch();

if (!$blog) {
    header('Location: blog.php');
    exit;
}

// Fetch Configuration
$stmt_conf = $pdo->query('SELECT * FROM config LIMIT 1');
$config = $stmt_conf->fetch();

// Fetch Recent Blogs for Sidebar
$recent_blogs = $pdo->prepare('SELECT title, slug, image, created_at FROM blogs WHERE id != ? AND visible = 1 ORDER BY created_at DESC LIMIT 5');
$recent_blogs->execute([$blog['id']]);
$recent_items = $recent_blogs->fetchAll();

// Fetch Dynamic Pages for Navbar
$nav_pages = $pdo->query('SELECT title, slug FROM pages WHERE visible = 1')->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo htmlspecialchars($blog['title']); ?> – <?php echo htmlspecialchars($config['title'] ?? 'Sakura Florist Solo'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($blog['excerpt']); ?>">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <style>
        .post-header { padding: 150px 0 80px; position: relative; overflow: hidden; background: #f8f9fa; }
        .post-title { font-size: 3rem; font-weight: 800; line-height: 1.2; color: #333; }
        .post-meta { color: #888; font-size: 0.9rem; margin-top: 20px; }
        .post-featured-img { width: 100%; height: 500px; object-fit: cover; border-radius: 25px; margin-top: -60px; box-shadow: 0 20px 50px rgba(0,0,0,0.15); position: relative; z-index: 10; }
        .post-content { padding: 80px 0; font-size: 1.1rem; line-height: 1.8; color: #444; }
        .post-content img { max-width: 100%; border-radius: 15px; margin: 30px 0; }
        .sidebar-card { background: #fff; border-radius: 20px; padding: 30px; border: 1px solid #eee; margin-bottom: 30px; }
        .sidebar-title { font-size: 1.25rem; font-weight: 700; border-bottom: 2px solid var(--primary-color); display: inline-block; padding-bottom: 10px; margin-bottom: 25px; }
        .recent-post-item { display: flex; gap: 15px; margin-bottom: 20px; text-decoration: none; color: inherit; transition: 0.3s; }
        .recent-post-item:hover { color: var(--primary-color); }
        .recent-post-img { width: 70px; height: 70px; border-radius: 12px; object-fit: cover; }
        .recent-post-title { font-size: 0.95rem; font-weight: 600; margin: 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        
        @media (max-width: 768px) {
            .post-title { font-size: 2rem; }
            .post-featured-img { height: 300px; }
        }
    </style>
</head>
<body>

    <?php require_once 'components/navbar.php'; ?>

    <header class="post-header">
        <div class="container text-center">
            <nav aria-label="breadcrumb" data-aos="fade-up">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/index.php" class="text-decoration-none text-muted">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="/blog" class="text-decoration-none text-muted">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
            <h1 class="post-title col-lg-8 mx-auto" data-aos="fade-up" data-aos-delay="100"><?php echo htmlspecialchars($blog['title']); ?></h1>
            <div class="post-meta" data-aos="fade-up" data-aos-delay="200">
                <span class="me-3"><i class="far fa-calendar-alt me-2"></i> <?php echo date('d F Y', strtotime($blog['created_at'])); ?></span>
                <span><i class="far fa-user me-2"></i> Admin Sakura</span>
            </div>
        </div>
    </header>

    <div class="container">
        <img src="<?php echo (strpos($blog['image'], 'http') === 0 ? '' : '/') . htmlspecialchars($blog['image'] ?: 'https://images.unsplash.com/photo-1490750967868-88aa4486c946'); ?>" class="post-featured-img" alt="<?php echo htmlspecialchars($blog['title']); ?>" data-aos="zoom-in">
    </div>

    <main class="post-content">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="glass-card p-4 p-md-5">
                        <div class="article-body">
                            <?php echo html_entity_decode($blog['content']); ?>
                        </div>
                        <hr class="my-5 opacity-10">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex gap-2">
                                <span class="badge bg-light text-muted p-2 px-3">#TipsBunga</span>
                                <span class="badge bg-light text-muted p-2 px-3">#SakuraFlorist</span>
                                <span class="badge bg-light text-muted p-2 px-3">#Solo</span>
                            </div>
                            <div class="share-buttons">
                                <span class="text-muted small me-2">Bagikan:</span>
                                <a href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($blog['title'] . ' - http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" target="_blank" class="btn btn-outline-success btn-sm rounded-circle"><i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4" data-aos="fade-left">
                    <div class="sidebar-card shadow-sm sticky-top" style="top: 100px;">
                        <h4 class="sidebar-title">Artikel Terbaru</h4>
                        <div class="recent-posts">
                            <?php foreach ($recent_items as $item): ?>
                            <a href="/blog/<?php echo $item['slug']; ?>" class="recent-post-item">
                                <img src="<?php echo (strpos($item['image'], 'http') === 0 ? '' : '/') . htmlspecialchars($item['image'] ?: 'https://images.unsplash.com/photo-1490750967868-88aa4486c946'); ?>" class="recent-post-img" alt="thumb">
                                <div>
                                    <h5 class="recent-post-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                                    <small class="text-muted"><?php echo date('d M Y', strtotime($item['created_at'])); ?></small>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="mt-5 p-4 bg-primary bg-opacity-10 rounded-4 text-center">
                            <h5>Butuh Bunga Segar?</h5>
                            <p class="small text-muted">Hubungi kami untuk pesanan kilat area Solo.</p>
                            <a href="#" class="btn btn-primary rounded-pill w-100 btn-order-whatsapp" data-wa="<?php echo $config['whatsapp'] ?? '081567883835'; ?>">
                                <i class="fab fa-whatsapp me-2"></i> Chat Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once 'components/footer.php'; ?>
</body>
</html>
