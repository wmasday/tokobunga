<?php
/**
 * Blog List Page
 * Sakura Florist Solo
 */
require_once 'config/db.php';

// Fetch Configuration
$stmt_conf = $pdo->query('SELECT * FROM config LIMIT 1');
$config = $stmt_conf->fetch();

// Fetch Blogs
$blogs = $pdo->query('SELECT * FROM blogs WHERE visible = 1 ORDER BY created_at DESC')->fetchAll();

// Fetch Dynamic Pages for Navbar
$nav_pages = $pdo->query('SELECT title, slug FROM pages WHERE visible = 1')->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Blog & Inspirasi Bunga – <?php echo htmlspecialchars($config['title'] ?? 'Sakura Florist Solo'); ?></title>
    <meta name="description" content="Tips merawat bunga, inspirasi rangkaian bunga, dan berita terbaru dari Sakura Florist Solo.">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <style>
        .blog-header { background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 120px 0 60px; text-align: center; }
        .blog-card { border: none; border-radius: 20px; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease; height: 100%; display: flex; flex-direction: column; background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .blog-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .blog-img-wrapper { height: 250px; overflow: hidden; position: relative; }
        .blog-img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .blog-card:hover .blog-img-wrapper img { transform: scale(1.1); }
        .blog-date { position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.9); padding: 5px 15px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; color: var(--primary-color); }
        .blog-body { padding: 30px; flex-grow: 1; }
        .blog-title { font-size: 1.25rem; font-weight: 700; margin-bottom: 15px; color: #333; line-height: 1.4; }
        .blog-excerpt { color: #666; font-size: 0.95rem; margin-bottom: 20px; }
        .btn-read-more { color: var(--primary-color); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: gap 0.3s; }
        .btn-read-more:hover { gap: 12px; }
    </style>
</head>
<body>

    <?php require_once 'components/navbar.php'; ?>

    <header class="blog-header">
        <div class="container" data-aos="fade-down">
            <h1 class="display-4 fw-bold text-dark">Blog & Inspirasi</h1>
            <p class="lead text-dark">Temukan tips dan cerita menarik seputar dunia bunga</p>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="row g-4">
                <?php foreach ($blogs as $blog): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="blog-card">
                        <div class="blog-img-wrapper">
                            <img src="<?php echo (strpos($blog['image'], 'http') === 0 ? '' : '/') . htmlspecialchars($blog['image'] ?: 'https://images.unsplash.com/photo-1490750967868-88aa4486c946'); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                            <span class="blog-date"><?php echo date('d M Y', strtotime($blog['created_at'])); ?></span>
                        </div>
                        <div class="blog-body">
                            <h3 class="blog-title"><?php echo htmlspecialchars($blog['title']); ?></h3>
                            <p class="blog-excerpt"><?php echo htmlspecialchars($blog['excerpt']); ?></p>
                            <a href="/blog/<?php echo $blog['slug']; ?>" class="btn-read-more">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <?php if (empty($blogs)): ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>
                    <h3>Belum ada artikel blog.</h3>
                    <p class="text-muted">Nantikan update terbaru dari kami segera!</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php require_once 'components/footer.php'; ?>
</body>
</html>
