<?php
/**
 * Flowers CRUD - Modern Dashboard Edition
 * Sakura Florist Solo
 */
ob_start();
require_once '../config/db.php';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Handle Delete Action - MUST BE BEFORE HEADER
if ($action === 'delete' && $id) {
    try {
        $stmt = $pdo->prepare('DELETE FROM flowers WHERE id = ?');
        $stmt->execute([$id]);
        header('Location: flowers.php');
        exit;
    } catch (PDOException $e) {
        $error = "Error deleting flower record.";
    }
}

include 'header.php';

// Handle Form Submission (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['categories_id'];
    $visible = isset($_POST['visible']) ? 1 : 0;
    $image_path = $_POST['current_image'] ?? '';
    $description = $_POST['description'] ?? '';

    // Handle Image Upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../assets/img/flowers/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $file_name = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = 'assets/img/flowers/' . $file_name;
        }
    }

    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare('INSERT INTO flowers (name, description, price, image, categories_id, visible) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$name, $description, $price, $image_path, $category_id, $visible]);
        echo "<script>$(document).ready(() => Swal.fire('Success', 'Flower added!', 'success').then(() => window.location='flowers.php'));</script>";
    } elseif (isset($_POST['edit'])) {
        $stmt = $pdo->prepare('UPDATE flowers SET name = ?, description = ?, price = ?, image = ?, categories_id = ?, visible = ? WHERE id = ?');
        $stmt->execute([$name, $description, $price, $image_path, $category_id, $visible, $id]);
        echo "<script>$(document).ready(() => Swal.fire('Success', 'Flower updated!', 'success').then(() => window.location='flowers.php'));</script>";
    }
}

if (isset($error)) {
    echo "<script>$(document).ready(() => Swal.fire('Error', '" . addslashes($error) . "', 'error'));</script>";
}
?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold h3 mb-1">Manage Flowers</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Flowers</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-6 text-md-end">
        <?php if ($action === 'list'): ?>
            <a href="flowers.php?action=add" class="btn btn-admin btn-admin-primary px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i> Add New Flower
            </a>
        <?php else: ?>
            <a href="flowers.php" class="btn btn-light btn-admin border px-4 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="card-admin border-0 shadow-sm">
    <?php if ($action === 'add' || $action === 'edit'): 
        $flower = ['name' => '', 'description' => '', 'price' => 0, 'image' => '', 'categories_id' => '', 'visible' => 1];
        if ($action === 'edit' && $id) {
            $stmt = $pdo->prepare('SELECT * FROM flowers WHERE id = ?');
            $stmt->execute([$id]);
            $flower = $stmt->fetch();
        }
    ?>
        <h5 class="fw-bold mb-4"><?= ucfirst($action) ?> Flower Details</h5>
        <form method="POST" enctype="multipart/form-data">
            <div class="row g-4">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label-admin">Flower Name</label>
                            <input type="text" name="name" class="form-control-admin w-100" value="<?= htmlspecialchars($flower['name']) ?>" required placeholder="e.g. Buket Mawar Merah">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label-admin">Price (IDR)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">Rp</span>
                                <input type="number" name="price" class="form-control-admin border-start-0 w-75" value="<?= $flower['price'] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label-admin">Category</label>
                            <select name="categories_id" class="form-select form-control-admin" required>
                                <option value="">Select Category</option>
                                <?php
                                $cats = $pdo->query('SELECT * FROM categories');
                                while ($cat = $cats->fetch()):
                                ?>
                                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $flower['categories_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label-admin">Description</label>
                            <textarea name="description" class="form-control-admin w-100 summernote" placeholder="Write a description for this flower..."><?= htmlspecialchars($flower['description'] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="form-check form-switch mt-2">
                                <input type="checkbox" name="visible" class="form-check-input" id="visibleCheck" <?= $flower['visible'] ? 'checked' : '' ?>>
                                <label class="form-check-label ms-2" for="visibleCheck">Visible on public catalog</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="p-4 bg-light rounded-4 text-center border">
                        <label class="form-label-admin d-block mb-3 text-start">Product Image</label>
                        <?php if ($flower['image']): ?>
                            <div class="mb-3 position-relative d-inline-block">
                                <img src="../<?= $flower['image'] ?>" class="rounded-4 shadow-sm" style="max-width: 100%; max-height: 250px;">
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge bg-primary">Current</span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="mb-3 p-5 bg-white rounded-4 border border-dashed d-flex flex-column align-items-center">
                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                <span class="text-muted small">No image uploaded yet</span>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="image" class="form-control-admin bg-white w-100" accept="image/*">
                        <input type="hidden" name="current_image" value="<?= $flower['image'] ?>">
                        <p class="small text-muted mt-2 mb-0">Recommended: Square image (1:1)</p>
                    </div>
                </div>
            </div>
            
            <hr class="my-5 border-light">
            
            <div class="d-flex justify-content-end gap-3">
                <a href="flowers.php" class="btn btn-light px-4 border rounded-pill">Cancel</a>
                <button type="submit" name="<?= $action ?>" class="btn btn-admin btn-admin-primary px-5 rounded-pill shadow-sm">
                    <?= ucfirst($action) ?> Product
                </button>
            </div>
        </form>

    <?php else: ?>
        <div class="table-admin-container border-0 mt-2">
            <table class="table-admin text-nowrap">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Flower Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Availability</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query('SELECT f.*, c.name as cat_name FROM flowers f LEFT JOIN categories c ON f.categories_id = c.id ORDER BY f.created_at DESC');
                    while ($row = $stmt->fetch()):
                    ?>
                    <tr>
                        <td>
                            <?php if ($row['image']): ?>
                                <img src="../<?= $row['image'] ?>" width="45" height="45" class="rounded shadow-sm object-fit-cover border">
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                                    <i class="fas fa-image text-muted small"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="fw-600"><?= htmlspecialchars($row['name']) ?></td>
                        <td>
                            <span class="badge bg-light text-muted border px-2 py-1"><?= htmlspecialchars($row['cat_name'] ?? 'Uncategorized') ?></span>
                        </td>
                        <td class="fw-bold">Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                        <td>
                            <?= $row['visible'] ? 
                                '<span class="d-flex align-items-center text-success small fw-bold"><i class="fas fa-check-circle me-1"></i> Public</span>' : 
                                '<span class="d-flex align-items-center text-muted small fw-bold"><i class="fas fa-eye-slash me-1"></i> Hidden</span>' ?>
                        </td>
                        <td class="text-end">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle shadow-none border" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><a class="dropdown-item py-2 small" href="flowers.php?action=edit&id=<?= $row['id'] ?>"><i class="fas fa-edit me-2 text-primary"></i> Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item py-2 small text-danger" href="javascript:void(0)" onclick="confirmDelete('flowers.php?action=delete&id=<?= $row['id'] ?>')"><i class="fas fa-trash me-2"></i> Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
