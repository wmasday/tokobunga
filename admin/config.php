<?php
/**
 * Site Configuration - Modern Dashboard Edition
 * Sakura Florist Solo
 */
require_once '../config/db.php';
include 'header.php';

// Fetch current config
$stmt = $pdo->query('SELECT * FROM config LIMIT 1');
$config = $stmt->fetch();

if (!$config) {
    // Initialize if empty
    $pdo->query("INSERT INTO config (title) VALUES ('Sakura Florist Solo')");
    $stmt = $pdo->query('SELECT * FROM config LIMIT 1');
    $config = $stmt->fetch();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $whatsapp = $_POST['whatsapp'];
    $facebook = $_POST['facebook'];
    $instagram = $_POST['instagram'];
    $wa_message = $_POST['wa_message'];
    $address = $_POST['address'];
    
    $logo = $config['logo'];
    $favicon = $config['favicon'];

    // Handle Logo Upload
    if (!empty($_FILES['logo']['name'])) {
        $target_dir = "../assets/img/";
        $file_name = 'logo_' . time() . '_' . basename($_FILES['logo']['name']);
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_dir . $file_name)) {
            $logo = 'assets/img/' . $file_name;
        }
    }

    // Handle Favicon Upload
    if (!empty($_FILES['favicon']['name'])) {
        $target_dir = "../assets/img/";
        $file_name = 'favicon_' . time() . '_' . basename($_FILES['favicon']['name']);
        if (move_uploaded_file($_FILES['favicon']['tmp_name'], $target_dir . $file_name)) {
            $favicon = 'assets/img/' . $file_name;
        }
    }

    $stmt = $pdo->prepare('UPDATE config SET title = ?, description = ?, whatsapp = ?, facebook = ?, instagram = ?, wa_message = ?, address = ?, logo = ?, favicon = ? WHERE id = ?');
    $stmt->execute([$title, $description, $whatsapp, $facebook, $instagram, $wa_message, $address, $logo, $favicon, $config['id']]);
    
    echo "<script>$(document).ready(() => Swal.fire('Success', 'Configuration updated!', 'success').then(() => window.location='config.php'));</script>";
}
?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold h3 mb-1">General Settings</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Configuration</li>
            </ol>
        </nav>
    </div>
</div>

<form method="POST" enctype="multipart/form-data">
    <div class="row g-4">
        <div class="col-xl-8">
            <!-- Brand Settings -->
            <div class="card-admin border-0 shadow-sm mb-4">
                <h5 class="fw-bold mb-4 border-bottom pb-3">Brand Identity</h5>
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Website Title</label>
                        <input type="text" name="title" class="form-control-admin w-100" value="<?= htmlspecialchars($config['title']) ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Meta Description (SEO)</label>
                        <textarea name="description" class="form-control-admin w-100" rows="3" placeholder="Brief description for search engines..."><?= htmlspecialchars($config['description']) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Logo Image</label>
                        <input type="file" name="logo" class="form-control-admin w-100 bg-light" accept="image/*">
                        <?php if ($config['logo']): ?>
                            <div class="mt-3 p-3 bg-light rounded-4 border text-center d-inline-block">
                                <img src="../<?= $config['logo'] ?>" height="40" class="object-fit-contain">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Favicon (Browser Icon)</label>
                        <input type="file" name="favicon" class="form-control-admin w-100 bg-light" accept="image/x-icon,image/png">
                        <?php if ($config['favicon']): ?>
                            <div class="mt-3 p-3 bg-light rounded-4 border text-center d-inline-block">
                                <img src="../<?= $config['favicon'] ?>" height="32" class="object-fit-contain">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- WhatsApp Order Setting -->
            <div class="card-admin border-0 shadow-sm">
                <h5 class="fw-bold mb-4 border-bottom pb-3">WhatsApp Order Flow</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Target WhatsApp Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fab fa-whatsapp text-success"></i></span>
                            <input type="text" name="whatsapp" class="form-control-admin border-start-0 w-75" value="<?= htmlspecialchars($config['whatsapp']) ?>" placeholder="e.g. 08123456789">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Order Message Template</label>
                        <textarea name="wa_message" class="form-control-admin w-100" rows="3" placeholder="Halo Admin, saya tertarik memesan {{flower_name}}..."><?= htmlspecialchars($config['wa_message']) ?></textarea>
                        <small class="text-muted mt-2 d-block"><i class="fas fa-info-circle me-1"></i> Use <code>{{flower_name}}</code> as a placeholder. The system will automatically replace it with the selected product.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <!-- Social Details -->
            <div class="card-admin border-0 shadow-sm mb-4">
                <h5 class="fw-bold mb-4 border-bottom pb-3">Contact & Socials</h5>
                <div class="mb-4">
                    <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Physical Address</label>
                    <textarea name="address" class="form-control-admin w-100" rows="2" placeholder="e.g. Jl. Slamet Riyadi No.1, Solo"><?= htmlspecialchars($config['address']) ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Instagram URL</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fab fa-instagram text-danger"></i></span>
                        <input type="url" name="instagram" class="form-control-admin border-start-0 w-75" value="<?= htmlspecialchars($config['instagram']) ?>" placeholder="https://instagram.com/...">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label-admin text-muted text-uppercase small letter-spacing-1">Facebook URL</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fab fa-facebook text-primary"></i></span>
                        <input type="url" name="facebook" class="form-control-admin border-start-0 w-75" value="<?= htmlspecialchars($config['facebook']) ?>" placeholder="https://facebook.com/...">
                    </div>
                </div>
                
                <hr class="my-4 border-light">
                
                <button type="submit" class="btn btn-admin btn-admin-primary w-100 py-3 rounded-pill shadow-sm">
                    <i class="fas fa-save me-2"></i> Save All Settings
                </button>
            </div>
        </div>
    </div>
</form>

<?php include 'footer.php'; ?>
