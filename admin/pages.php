<?php
/**
 * Pages CRUD - Modern Dashboard Edition
 * Sakura Florist Solo
 */
ob_start();
require_once '../config/db.php';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Handle Delete Action - MUST BE BEFORE HEADER
if ($action === 'delete' && $id) {
    try {
        $stmt = $pdo->prepare('DELETE FROM pages WHERE id = ?');
        $stmt->execute([$id]);
        header('Location: pages.php');
        exit;
    } catch (PDOException $e) {
        $error = "Error removing page.";
    }
}

include 'header.php';

// Handle Form Submission (Add/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $slug = $_POST['slug'];
    $content = $_POST['content'];
    $visible = isset($_POST['visible']) ? 1 : 0;

    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare('INSERT INTO pages (title, slug, content, visible) VALUES (?, ?, ?, ?)');
        $stmt->execute([$title, $slug, $content, $visible]);
        echo "<script>$(document).ready(() => Swal.fire('Success', 'Page added!', 'success').then(() => window.location='pages.php'));</script>";
    } elseif (isset($_POST['edit'])) {
        $stmt = $pdo->prepare('UPDATE pages SET title = ?, slug = ?, content = ?, visible = ? WHERE id = ?');
        $stmt->execute([$title, $slug, $content, $visible, $id]);
        echo "<script>$(document).ready(() => Swal.fire('Success', 'Page updated!', 'success').then(() => window.location='pages.php'));</script>";
    }
}

if (isset($error)) {
    echo "<script>$(document).ready(() => Swal.fire('Error', '" . addslashes($error) . "', 'error'));</script>";
}
?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold h3 mb-1">Dynamic Pages</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Pages</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-6 text-md-end">
        <?php if ($action === 'list'): ?>
            <a href="pages.php?action=add" class="btn btn-admin btn-admin-primary px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i> Add New Page
            </a>
        <?php else: ?>
            <a href="pages.php" class="btn btn-light btn-admin border px-4 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($action === 'add' || $action === 'edit'): 
    $pg = ['title' => '', 'slug' => '', 'content' => '', 'visible' => 1];
    if ($action === 'edit' && $id) {
        $stmt = $pdo->prepare('SELECT * FROM pages WHERE id = ?');
        $stmt->execute([$id]);
        $pg = $stmt->fetch();
    }
?>
    <form method="POST">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-admin border-0 shadow-sm">
                    <h5 class="fw-bold mb-4"><?= ucfirst($action) ?> Page Content</h5>
                    <div class="mb-4">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Page Title</label>
                        <input type="text" name="title" class="form-control-admin w-100" id="pageTitle" value="<?= htmlspecialchars($pg['title']) ?>" required onkeyup="generateSlug()" placeholder="e.g. Tentang Kami">
                    </div>
                    <div class="mb-0">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Page Content</label>
                        <textarea name="content" class="form-control-admin w-100 summernote"><?= htmlspecialchars($pg['content']) ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card-admin border-0 shadow-sm">
                    <h5 class="fw-bold mb-4">Page Settings</h5>
                    <div class="mb-4">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Page Slug</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 small">/page/</span>
                            <input type="text" name="slug" class="form-control-admin border-start-0 w-50" id="pageSlug" value="<?= htmlspecialchars($pg['slug']) ?>" required readonly>
                        </div>
                        <small class="text-muted mt-2 d-block">Auto-generated based on title.</small>
                    </div>
                    
                    <div class="form-check form-switch pt-1 mb-4">
                        <input type="checkbox" name="visible" class="form-check-input" id="visibleCheck" <?= $pg['visible'] ? 'checked' : '' ?>>
                        <label class="form-check-label ms-2 small" for="visibleCheck">Show in Header Navigation</label>
                    </div>
                    
                    <hr class="my-4 border-light">
                    
                    <div class="d-grid gap-2">
                        <button type="submit" name="<?= $action ?>" class="btn btn-admin btn-admin-primary py-3 rounded-pill shadow-sm">
                            <?= ucfirst($action) ?> Page
                        </button>
                        <a href="pages.php" class="btn btn-light py-3 border rounded-pill">Discard Changes</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
    function generateSlug() {
        let title = document.getElementById('pageTitle').value;
        let slug = title.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
        document.getElementById('pageSlug').value = slug;
    }
    </script>

<?php else: ?>
    <div class="card-admin border-0 shadow-sm">
        <div class="table-admin-container border-0 mt-2">
            <table class="table-admin text-nowrap">
                <thead>
                    <tr>
                        <th>Page Title</th>
                        <th>URL Slug</th>
                        <th>Menu Navigation</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query('SELECT * FROM pages ORDER BY title ASC');
                    while ($row = $stmt->fetch()):
                    ?>
                    <tr>
                        <td class="fw-600"><?= htmlspecialchars($row['title']) ?></td>
                        <td><code class="text-primary bg-primary-light px-2 py-1 rounded">/page/<?= htmlspecialchars($row['slug']) ?></code></td>
                        <td>
                            <?= $row['visible'] ? 
                                '<span class="badge bg-soft-green text-success px-3 py-2 rounded-pill small">Visible</span>' : 
                                '<span class="badge bg-soft-orange text-warning px-3 py-2 rounded-pill small">Hidden</span>' ?>
                        </td>
                        <td class="text-end">
                            <a href="pages.php?action=edit&id=<?= $row['id'] ?>" class="btn btn-light btn-sm rounded-circle shadow-none border me-1" title="Edit">
                                <i class="fas fa-edit text-primary"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="confirmDelete('pages.php?action=delete&id=<?= $row['id'] ?>')" class="btn btn-light btn-sm rounded-circle shadow-none border text-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
