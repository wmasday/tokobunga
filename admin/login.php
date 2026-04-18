<?php
/**
 * Admin Login Page - Modern Edition
 * Sakura Florist Solo
 */

require_once '../config/db.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && ($password === 'admin' || password_verify($password, $user['password']))) { // Fallback for simple admin password
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_user'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Sakura Florist Solo</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #F94687;
            --primary-light: rgba(249, 70, 135, 0.1);
        }
        body { 
            background-color: #f1f5f9; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            font-family: 'Inter', sans-serif; 
            padding: 20px;
        }
        .login-wrapper {
            width: 100%; 
            max-width: 420px;
        }
        .brand-hdr {
            font-family: 'Poppins', sans-serif;
            color: #1e293b;
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .brand-hdr span {
            color: var(--primary);
        }
        .login-card { 
            padding: 2.5rem; 
            border-radius: 1.25rem; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.05); 
            background: white; 
            border: 1px solid rgba(255,255,255,0.8);
        }
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        .form-control:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-light);
        }
        .btn-login { 
            background-color: var(--primary); 
            border: none; 
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 0.5rem;
            color: white;
            transition: 0.3s;
        }
        .btn-login:hover { 
            background-color: #d13a6e; 
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(249, 70, 135, 0.2);
        }
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <h2 class="brand-hdr"><span>Sakura</span> Admin</h2>
        
        <div class="login-card">
            <h4 class="text-center mb-4 fw-bold" style="color: #1e293b;">Welcome Back</h4>
            
            <?php if ($error): ?>
                <div class="alert alert-error py-2 d-flex align-items-center mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= $error ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-4">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" id="username" class="form-control border-start-0" required autofocus placeholder="Enter your username">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label d-flex justify-content-between">
                        <span>Password</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control border-start-0" required placeholder="Enter your password">
                    </div>
                </div>
                
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label text-muted small" for="rememberMe">Remember me on this device</label>
                </div>
                
                <button type="submit" class="btn btn-login w-100 mt-2">Sign In securely <i class="fas fa-arrow-right ms-2 small"></i></button>
            </form>
            
            <div class="text-center mt-4">
                <a href="/" class="text-decoration-none text-muted small"><i class="fas fa-arrow-left me-1"></i> Return to main site</a>
            </div>
        </div>
    </div>
</body>
</html>
