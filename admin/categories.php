<?php
/**
 * Categories CRUD - Modern Dashboard Edition
 * Sakura Florist Solo
 */
ob_start();
require_once '../config/db.php';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Handle Delete Action - MUST BE BEFORE HEADER
if ($action === 'delete' && $id) {
    try {
        $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        header('Location: categories.php');
        exit;
    } catch (PDOException $e) {
        $error = "Cannot delete category. It might be in use by flowers.";
    }
}

include 'header.php';

// Handle Form Submission (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $visible = isset($_POST['visible']) ? 1 : 0;

    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare('INSERT INTO categories (name, visible) VALUES (?, ?)');
        $stmt->execute([$name, $visible]);
        echo "<script>$(document).ready(() => Swal.fire('Success', 'Category added!', 'success').then(() => window.location='categories.php'));</script>";
    } elseif (isset($_POST['edit'])) {
        $stmt = $pdo->prepare('UPDATE categories SET name = ?, visible = ? WHERE id = ?');
        $stmt->execute([$name, $visible, $id]);
        echo "<script>$(document).ready(() => Swal.fire('Success', 'Category updated!', 'success').then(() => window.location='categories.php'));</script>";
    }
}

if (isset($error)) {
    echo "<script>$(document).ready(() => Swal.fire('Error', '" . addslashes($error) . "', 'error'));</script>";
}
?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold h3 mb-1">Categories</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Product Categories</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-6 text-md-end">
        <?php if ($action === 'list'): ?>
            <a href="categories.php?action=add" class="btn btn-admin btn-admin-primary px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i> Add New Category
            </a>
        <?php else: ?>
            <a href="categories.php" class="btn btn-light btn-admin border px-4 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="row g-4">
    <?php if ($action === 'add' || $action === 'edit'): 
        $cat = ['name' => '', 'visible' => 1];
        if ($action === 'edit' && $id) {
            $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
            $stmt->execute([$id]);
            $cat = $stmt->fetch();
        }
    ?>
    <div class="col-lg-6 mx-auto">
        <div class="card-admin border-0 shadow-sm">
            <h5 class="fw-bold mb-4"><?= ucfirst($action) ?> Category</h5>
            <form method="POST">
                <div class="mb-4">
                    <label class="form-label-admin">Category Name</label>
                    <input type="text" name="name" class="form-control-admin w-100" value="<?= htmlspecialchars($cat['name']) ?>" required placeholder="e.g. Bunga Papan">
                </div>
                <div class="mb-4">
                    <div class="form-check form-switch pt-1">
                        <input type="checkbox" name="visible" class="form-check-input" id="visibleCheck" <?= $cat['visible'] ? 'checked' : '' ?>>
                        <label class="form-check-label ms-2 small fw-100" for="visibleCheck">Show in public catalog filter</label>
                    </div>
                </div>
                
                <hr class="my-4 border-light">
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="categories.php" class="btn btn-light px-4 border rounded-pill">Cancel</a>
                    <button type="submit" name="<?= $action ?>" class="btn btn-admin btn-admin-primary px-5 rounded-pill shadow-sm">
                        <?= ucfirst($action) ?> Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php else: ?>
    <div class="col-lg-12 mx-auto">
        <div class="card-admin border-0 shadow-sm">
            <div class="table-admin-container border-0 mt-2">
                <table class="table-admin text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Category Name</th>
                            <th>Visibility</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query('SELECT * FROM categories ORDER BY name ASC');
                        $i = 1;
                        while ($row = $stmt->fetch()):
                        ?>
                        <tr>
                            <td class="text-muted small"><?= $i++ ?></td>
                            <td class="fw-600"><?= htmlspecialchars($row['name']) ?></td>
                            <td>
                                <?= $row['visible'] ? 
                                    '<span class="badge bg-soft-green text-success px-3 py-2 rounded-pill small">Displaying</span>' : 
                                    '<span class="badge bg-soft-orange text-warning px-3 py-2 rounded-pill small">Hidden</span>' ?>
                            </td>
                            <td class="text-end">
                                <a href="categories.php?action=edit&id=<?= $row['id'] ?>" class="btn btn-light btn-sm rounded-circle shadow-none border me-1" title="Edit">
                                    <i class="fas fa-edit text-primary"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="confirmDelete('categories.php?action=delete&id=<?= $row['id'] ?>')" class="btn btn-light btn-sm rounded-circle shadow-none border text-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
