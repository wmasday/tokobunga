<?php
/**
 * Blogs CRUD - Modern Dashboard Edition
 * Sakura Florist Solo
 */
require_once '../config/db.php';
include 'header.php';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $slug = $_POST['slug'];
    $excerpt = $_POST['excerpt'];
    $content = $_POST['content'];
    $image = $_POST['image'];
    $visible = isset($_POST['visible']) ? 1 : 0;

    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare('INSERT INTO blogs (title, slug, excerpt, content, image, visible) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$title, $slug, $excerpt, $content, $image, $visible]);
        echo "<script>$(document).ready(() => Swal.fire('Success', 'Blog post added!', 'success').then(() => window.location='blogs.php'));</script>";
    } elseif (isset($_POST['edit'])) {
        $stmt = $pdo->prepare('UPDATE blogs SET title = ?, slug = ?, excerpt = ?, content = ?, image = ?, visible = ? WHERE id = ?');
        $stmt->execute([$title, $slug, $excerpt, $content, $image, $visible, $id]);
        echo "<script>$(document).ready(() => Swal.fire('Success', 'Blog post updated!', 'success').then(() => window.location='blogs.php'));</script>";
    }
}

if ($action === 'delete' && $id) {
    $stmt = $pdo->prepare('DELETE FROM blogs WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: blogs.php');
    exit;
}
?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold h3 mb-1">Blog Posts</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Blogs</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-6 text-md-end">
        <?php if ($action === 'list'): ?>
            <a href="blogs.php?action=add" class="btn btn-admin btn-admin-primary px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i> Add New Post
            </a>
        <?php else: ?>
            <a href="blogs.php" class="btn btn-light btn-admin border px-4 shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($action === 'add' || $action === 'edit'): 
    $blog = ['title' => '', 'slug' => '', 'excerpt' => '', 'content' => '', 'image' => '', 'visible' => 1];
    if ($action === 'edit' && $id) {
        $stmt = $pdo->prepare('SELECT * FROM blogs WHERE id = ?');
        $stmt->execute([$id]);
        $blog = $stmt->fetch();
    }
?>
    <form method="POST">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-admin border-0 shadow-sm">
                    <h5 class="fw-bold mb-4"><?= ucfirst($action) ?> Post Content</h5>
                    <div class="mb-4">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Post Title</label>
                        <input type="text" name="title" class="form-control-admin w-100" id="blogTitle" value="<?= htmlspecialchars($blog['title']) ?>" required onkeyup="generateBlogSlug()" placeholder="Enter title...">
                    </div>
                    <div class="mb-4">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Post Content</label>
                        <textarea name="content" class="form-control-admin w-100 summernote"><?= htmlspecialchars($blog['content']) ?></textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Excerpt (Summary)</label>
                        <textarea name="excerpt" class="form-control-admin w-100" rows="3" placeholder="Brief summary for catalog..."><?= htmlspecialchars($blog['excerpt']) ?></textarea>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-admin border-0 shadow-sm mb-4">
                    <h5 class="fw-bold mb-4">Post Settings</h5>
                    <div class="mb-4">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Post Slug</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 small">/blog/</span>
                            <input type="text" name="slug" class="form-control-admin border-start-0 w-50" id="blogSlug" value="<?= htmlspecialchars($blog['slug']) ?>" required readonly>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Featured Image URL</label>
                        <input type="url" name="image" class="form-control-admin w-100" value="<?= htmlspecialchars($blog['image']) ?>" placeholder="https://images.unsplash.com/...">
                        <?php if ($blog['image']): ?>
                             <div class="mt-3 rounded-4 overflow-hidden border">
                                <img src="<?= htmlspecialchars($blog['image']) ?>" class="w-100 object-fit-cover" style="height: 150px;">
                             </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-check form-switch pt-1 mb-4">
                        <input type="checkbox" name="visible" class="form-check-input" id="visibleCheck" <?= $blog['visible'] ? 'checked' : '' ?>>
                        <label class="form-check-label ms-2 small" for="visibleCheck">Visible to Public</label>
                    </div>
                    
                    <button type="submit" name="<?= $action ?>" class="btn btn-admin btn-admin-primary w-100 py-3 rounded-pill shadow-sm">
                        <?= ucfirst($action) ?> Publish Post
                    </button>
                    <a href="blogs.php" class="btn btn-light w-100 py-3 border rounded-pill mt-3">Discard Changes</a>
                </div>
            </div>
        </div>
    </form>

    <script>
    function generateBlogSlug() {
        let title = document.getElementById('blogTitle').value;
        let slug = title.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
        document.getElementById('blogSlug').value = slug;
    }
    </script>

<?php else: ?>
    <div class="card-admin border-0 shadow-sm">
        <div class="table-admin-container border-0 mt-2">
            <table class="table-admin text-nowrap">
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>Title & Intro</th>
                        <th>Created Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query('SELECT * FROM blogs ORDER BY created_at DESC');
                    while ($row = $stmt->fetch()):
                    ?>
                    <tr>
                        <td>
                            <img src="<?= htmlspecialchars($row['image']) ?>" width="60" height="60" class="rounded-4 shadow-sm object-fit-cover border">
                        </td>
                        <td>
                            <div class="fw-bold mb-1"><?= htmlspecialchars($row['title']) ?></div>
                            <div class="text-muted small" style="max-width: 300px; white-space: normal; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= htmlspecialchars($row['excerpt']) ?></div>
                        </td>
                        <td class="small text-muted">
                            <i class="fas fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($row['created_at'])) ?>
                        </td>
                        <td>
                            <?= $row['visible'] ? 
                                '<span class="badge bg-soft-green text-success px-3 py-2 rounded-pill small">Published</span>' : 
                                '<span class="badge bg-soft-orange text-warning px-3 py-2 rounded-pill small">Draft</span>' ?>
                        </td>
                        <td class="text-end">
                            <a href="blogs.php?action=edit&id=<?= $row['id'] ?>" class="btn btn-light btn-sm rounded-circle shadow-none border me-1">
                                <i class="fas fa-edit text-primary"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="confirmDelete('blogs.php?action=delete&id=<?= $row['id'] ?>')" class="btn btn-light btn-sm rounded-circle shadow-none border text-danger">
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
