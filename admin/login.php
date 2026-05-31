<?php
session_start();
require_once '../config/db.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username !== '' && $password !== '') {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = 'اسم المستخدم أو كلمة المرور غير صحيحة';
        }
    } else {
        $error = 'يرجى ملء جميع الحقول';
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول المشرف - اكتشف السعودية</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="navbar admin-navbar">
    <a href="../index.php" class="logo">لوحة <span>المشرف</span></a>
    <nav>
        <a href="../index.php">زيارة الموقع</a>
        <button class="night-toggle" onclick="toggleNightMode()">&#9790;</button>
    </nav>
</header>

<div class="login-container">
    <div class="login-box">
        <h2>تسجيل دخول المشرف</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" onsubmit="return validateLoginForm(this)">
            <div class="form-group">
                <label>اسم المستخدم</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="مثال: admin">
                <div class="error-text"></div>
            </div>
            <div class="form-group">
                <label>كلمة المرور</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••">
                <div class="error-text"></div>
            </div>
            <button type="submit" class="btn btn-success btn-block">دخول</button>
        </form>
    </div>
</div>

<footer class="footer">
    &copy; اكتشف السعودية &mdash; جامعة الملك سعود.
</footer>

<script src="../js/main.js"></script>
</body>
</html>
