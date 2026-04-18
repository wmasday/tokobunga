<?php
/**
 * View Page - Render Dynamic Pages by Slug
 * Sakura Florist Solo
 */
require_once 'config/db.php';

$slug = $_GET['slug'] ?? '';

// Fetch Page Data
$stmt = $pdo->prepare('SELECT * FROM pages WHERE slug = ? AND visible = 1 LIMIT 1');
$stmt->execute([$slug]);
$page = $stmt->fetch();

if (!$page) {
    header('Location: index.php');
    exit;
}

// Fetch Configuration
$stmt_conf = $pdo->query('SELECT * FROM config LIMIT 1');
$config = $stmt_conf->fetch();

// Fetch Dynamic Pages for Navbar
$nav_pages = $pdo->query('SELECT title, slug FROM pages WHERE visible = 1')->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo htmlspecialchars($page['title']); ?> – <?php echo htmlspecialchars($config['title'] ?? 'Sakura Florist Solo'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($config['description'] ?? ''); ?>">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <style>
        .page-header { background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); color: white; padding: 100px 0 50px; text-align: center; }
        .page-content { padding: 80px 0; min-height: 60vh; }
        .page-content img { max-width: 100%; height: auto; border-radius: 15px; margin: 20px 0; }
    </style>
</head>
<body>

    <?php require_once 'components/navbar.php'; ?>

    <header class="page-header">
        <div class="container" data-aos="fade-down">
            <h1 class="display-4"><?php echo htmlspecialchars($page['title']); ?></h1>
        </div>
    </header>

    <main class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9" data-aos="fade-up">
                    <div class="glass-card p-5">
                        <?php echo html_entity_decode($page['content']); ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once 'components/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>
