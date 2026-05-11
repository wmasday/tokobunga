<?php
/**
 * Dynamic Sitemap Generator
 * Sakura Florist Solo
 */
require_once 'config/db.php';

header("Content-Type: application/xml; charset=utf-8");

$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

// Fetch Flowers
$flowers = $pdo->query('SELECT id, created_at FROM flowers WHERE visible = 1 ORDER BY created_at DESC')->fetchAll();

// Fetch Blogs
$blogs = $pdo->query('SELECT slug, created_at FROM blogs WHERE visible = 1 ORDER BY created_at DESC')->fetchAll();

// Fetch Pages
$pages = $pdo->query('SELECT slug FROM pages WHERE visible = 1')->fetchAll();

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// 1. Homepage
echo '<url>';
echo '<loc>' . $base_url . '/</loc>';
echo '<priority>1.0</priority>';
echo '<changefreq>daily</changefreq>';
echo '</url>';

// 2. Catalog Page
echo '<url>';
echo '<loc>' . $base_url . '/catalog</loc>';
echo '<priority>0.9</priority>';
echo '<changefreq>weekly</changefreq>';
echo '</url>';

// 3. Blog Listing
echo '<url>';
echo '<loc>' . $base_url . '/blog</loc>';
echo '<priority>0.8</priority>';
echo '<changefreq>weekly</changefreq>';
echo '</url>';

// 4. Flowers
foreach ($flowers as $flower) {
    echo '<url>';
    echo '<loc>' . $base_url . '/flower/' . $flower['id'] . '</loc>';
    echo '<lastmod>' . date('Y-m-d', strtotime($flower['created_at'])) . '</lastmod>';
    echo '<priority>0.8</priority>';
    echo '<changefreq>monthly</changefreq>';
    echo '</url>';
}

// 5. Blogs
foreach ($blogs as $blog) {
    echo '<url>';
    echo '<loc>' . $base_url . '/blog/' . $blog['slug'] . '</loc>';
    echo '<lastmod>' . date('Y-m-d', strtotime($blog['created_at'])) . '</lastmod>';
    echo '<priority>0.7</priority>';
    echo '<changefreq>monthly</changefreq>';
    echo '</url>';
}

// 6. Pages
foreach ($pages as $page) {
    echo '<url>';
    echo '<loc>' . $base_url . '/page/' . $page['slug'] . '</loc>';
    echo '<priority>0.5</priority>';
    echo '<changefreq>monthly</changefreq>';
    echo '</url>';
}

echo '</urlset>';
