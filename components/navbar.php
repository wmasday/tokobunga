<?php
/**
 * Shared Navbar Component
 * Sakura Florist Solo - Modern Glassmorphism Edition
 */

if (!isset($nav_pages)) {
    $nav_pages = $pdo->query('SELECT title, slug FROM pages WHERE visible = 1')->fetchAll();
}

$current_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>
<style>
    .navbar-glass {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.4s ease;
    }
    
    .navbar-brand {
        font-weight: 800;
        letter-spacing: 1.5px;
        color: #1e293b !important;
        font-size: 1.25rem;
    }
    
    .nav-link {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b !important;
        padding: 0.5rem 1.2rem !important;
        transition: 0.3s;
        position: relative;
    }
    
    .nav-link:hover, .nav-link.active {
        color: var(--primary) !important;
    }
    
    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: var(--primary);
        transition: 0.3s;
        transform: translateX(-50%);
    }
    
    .nav-link.active::after, .nav-link:hover::after {
        width: 20px;
    }
    
    /* Mobile Menu Modernization */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: 0.4s;
            transform: translateY(-20px);
        }
        
        .navbar-collapse.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .navbar-nav {
            width: 100%;
        }
        
        .nav-link {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        
        .mobile-close {
            position: absolute;
            top: 30px;
            right: 30px;
            font-size: 2rem;
            color: #64748b;
            cursor: pointer;
        }
    }
    
    /* Custom Toggler */
    .navbar-toggler-icon-custom {
        width: 24px;
        height: 2px;
        background: #1e293b;
        display: block;
        position: relative;
        transition: 0.3s;
    }
    .navbar-toggler-icon-custom::before, .navbar-toggler-icon-custom::after {
        content: '';
        width: 24px;
        height: 2px;
        background: #1e293b;
        position: absolute;
        left: 0;
        transition: 0.3s;
    }
    .navbar-toggler-icon-custom::before { top: -8px; }
    .navbar-toggler-icon-custom::after { top: 8px; }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top py-3 navbar-glass" aria-label="Main Navigation">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/index.php">
            <?php if ($config['logo']): ?>
                <img src="<?php echo (strpos($config['logo'], 'http') === 0 ? '' : '/') . $config['logo']; ?>" alt="Logo" height="35" class="me-3">
            <?php endif; ?>
            <span>SAKURA FLORIST</span>
        </a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon-custom"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Mobile Close Button -->
            <div class="mobile-close d-lg-none" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fas fa-times"></i>
            </div>
            
            <ul class="navbar-nav ms-auto text-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_uri === '/' || $current_uri === '/index.php') ? 'active' : ''; ?>" <?php echo ($current_uri === '/' || $current_uri === '/index.php') ? 'aria-current="page"' : ''; ?> href="/index.php">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_uri === '/catalog') ? 'active' : ''; ?>" <?php echo ($current_uri === '/catalog') ? 'aria-current="page"' : ''; ?> href="/catalog">Katalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_uri === '/blog' || strpos($current_uri, '/blog/') === 0) ? 'active' : ''; ?>" <?php echo ($current_uri === '/blog' || strpos($current_uri, '/blog/') === 0) ? 'aria-current="page"' : ''; ?> href="/blog">Blog</a>
                </li>
                <?php foreach ($nav_pages as $page): 
                    $page_uri = '/page/' . $page['slug'];
                    $is_active = ($current_uri === $page_uri);
                ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $is_active ? 'active' : ''; ?>" <?php echo $is_active ? 'aria-current="page"' : ''; ?> href="<?php echo $page_uri; ?>"><?php echo htmlspecialchars($page['title']); ?></a>
                </li>
                <?php endforeach; ?>
                <li class="nav-item">
                    <a class="nav-link" href="/index.php#contact">Kontak</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
