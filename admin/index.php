<?php
/**
 * Admin Dashboard Home - Modern Edition
 * Sakura Florist Solo
 */
require_once '../config/db.php';
include 'header.php';

// Fetch stats
$count_flowers = $pdo->query('SELECT COUNT(*) FROM flowers')->fetchColumn();
$count_categories = $pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn();
$count_pages = $pdo->query('SELECT COUNT(*) FROM pages')->fetchColumn();
?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold h3 mb-1">Dashboard</h2>
        <p class="text-muted small">Ringkasan aktivitas toko Sakura Florist Solo anda hari ini.</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Stat 1: Flowers -->
    <div class="col-md-4">
        <div class="card-admin stat-card border-0 shadow-sm h-100">
            <div class="stat-icon bg-soft-pink">
                <i class="fas fa-leaf"></i>
            </div>
            <div>
                <p class="text-muted small fw-600 mb-0">Total Flowers</p>
                <h3 class="fw-bold mb-0"><?= $count_flowers ?></h3>
                <a href="flowers.php" class="small text-primary text-decoration-none">Manage inventory →</a>
            </div>
        </div>
    </div>

    <!-- Stat 2: Categories -->
    <div class="col-md-4">
        <div class="card-admin stat-card border-0 shadow-sm h-100">
            <div class="stat-icon bg-soft-blue">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <p class="text-muted small fw-600 mb-0">Categories</p>
                <h3 class="fw-bold mb-0"><?= $count_categories ?></h3>
                <a href="categories.php" class="small text-primary text-decoration-none">Manage categories →</a>
            </div>
        </div>
    </div>

    <!-- Stat 3: Pages -->
    <div class="col-md-4">
        <div class="card-admin stat-card border-0 shadow-sm h-100">
            <div class="stat-icon bg-soft-green">
                <i class="fas fa-pager"></i>
            </div>
            <div>
                <p class="text-muted small fw-600 mb-0">Dynamic Pages</p>
                <h3 class="fw-bold mb-0"><?= $count_pages ?></h3>
                <a href="pages.php" class="small text-primary text-decoration-none">Manage pages →</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-admin">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Recently Added Flowers</h5>
                <a href="flowers.php" class="btn btn-light btn-sm rounded-pill px-3">View All</a>
            </div>
            <div class="table-admin-container border-0 shadow-none">
                <table class="table-admin">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query('SELECT f.*, c.name as cat_name FROM flowers f LEFT JOIN categories c ON f.categories_id = c.id ORDER BY f.created_at DESC LIMIT 5');
                        while ($row = $stmt->fetch()):
                        ?>
                        <tr>
                            <td class="fw-600"><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['cat_name'] ?? 'N/A') ?></td>
                            <td class="fw-bold">Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                            <td>
                                <?= $row['visible'] ? '<span class="badge bg-soft-green text-success">Visible</span>' : '<span class="badge bg-soft-orange text-warning">Hidden</span>' ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card-admin">
            <h5 class="fw-bold mb-4">Quick Actions</h5>
            <div class="d-grid gap-3">
                <a href="flowers.php?action=add" class="btn btn-admin btn-admin-primary py-3">
                    <i class="fas fa-plus me-2"></i> Add New Flower
                </a>
                <a href="blogs.php?action=add" class="btn btn-light btn-admin py-3 border">
                    <i class="fas fa-plus me-2"></i> New Blog Post
                </a>
                <a href="config.php" class="btn btn-light btn-admin py-3 border">
                    <i class="fas fa-cog me-2"></i> General Settings
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
