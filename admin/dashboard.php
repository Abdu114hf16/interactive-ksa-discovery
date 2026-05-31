<?php
require_once 'auth.php';
require_once '../config/db.php';

$stmt = $conn->query("SELECT * FROM regions ORDER BY id ASC");
$regions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$message = '';
$msg_type = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $msg_type = $_SESSION['msg_type'] ?? 'success';
    unset($_SESSION['message']);
    unset($_SESSION['msg_type']);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - اكتشف السعودية</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="navbar admin-navbar">
    <a href="dashboard.php" class="logo">لوحة تحكم <span>المشرف</span></a>
    <nav>
        <a href="dashboard.php" class="active">الصفحة الرئيسية</a>
        <a href="logout.php">تسجيل الخروج</a>
        <button class="night-toggle" onclick="toggleNightMode()">&#9790;</button>
    </nav>
</header>

<div class="admin-container">

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $msg_type === 'success' ? 'success' : 'danger'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <h1 class="section-title">إدارة المحتوى</h1>
    <p class="admin-desc">استخدم هذه الصفحة لإدارة محتوى الموقع من خلال عرض السجلات وإضافة أو تعديل أو حذف المحتوى.</p>

    <div class="admin-header">
        <div></div>
        <a href="add.php" class="btn btn-success">إضافة محتوى جديد</a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>المنطقة</th>
                <th>التصنيف</th>
                <th>الوصف</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($regions as $region): ?>
            <tr>
                <td data-label="ID"><?php echo $region['id']; ?></td>
                <td data-label="المنطقة"><?php echo htmlspecialchars($region['name']); ?></td>
                <td data-label="التصنيف"><?php echo htmlspecialchars($region['category']); ?></td>
                <td data-label="الوصف"><?php echo htmlspecialchars(mb_substr($region['description'], 0, 50)); ?>...</td>
                <td data-label="">
                    <div class="actions">
                        <a href="../details.php?id=<?php echo $region['id']; ?>" target="_blank" class="btn btn-sm btn-outline">معاينة</a>
                        <a href="update.php?id=<?php echo $region['id']; ?>" class="btn btn-sm btn-primary">تعديل</a>
                        <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $region['id']; ?>)">حذف</button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="confirm-overlay" id="confirmOverlay">
    <div class="confirm-box">
        <p>هل تريد حذف هذا السجل؟</p>
        <div class="confirm-actions">
            <button class="btn btn-danger" id="confirmDeleteBtn">حذف</button>
            <button class="btn btn-outline" onclick="closeConfirm()">إلغاء</button>
        </div>
    </div>
</div>

<footer class="footer">
    &copy; اكتشف السعودية &mdash; جامعة الملك سعود.
</footer>

<script src="../js/main.js"></script>
</body>
</html>
