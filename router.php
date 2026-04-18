<?php
/**
 * Router for PHP Built-in Web Server
 * Simulates .htaccess rewrites for Sakura Florist Solo
 */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 1. If it's a physical file (CSS, JS, Image), serve it
if (file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    return false;
}

// 2. Clean URLs for Blog Listing
if ($uri === '/blog' || $uri === '/blog/') {
    require 'blog.php';
    exit;
}

// 2b. Clean URLs for Catalog
if ($uri === '/catalog' || $uri === '/catalog/') {
    require 'catalog.php';
    exit;
}

// 3. Clean URLs for Blog Post Details: /blog/slug
if (preg_match('#^/blog/([^/]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require 'blog_view.php';
    exit;
}

// 4. Clean URLs for Static Pages: /page/slug
if (preg_match('#^/page/([^/]+)/?$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require 'view_page.php';
    exit;
}

// 4b. Clean URLs for Flower Details: /flower/id
if (preg_match('#^/flower/([0-9]+)/?$#', $uri, $matches)) {
    $_GET['id'] = $matches[1];
    require 'flower.php';
    exit;
}

// 5. Fallback for .php extension removal (optional convenience)
if (file_exists(__DIR__ . $uri . '.php')) {
    require __DIR__ . $uri . '.php';
    exit;
}

// 6. Otherwise, return false to let PHP handle it normally (or 404)
return false;
