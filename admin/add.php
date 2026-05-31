<?php
require_once 'auth.php';
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $facts = trim($_POST['facts'] ?? '');
    $climate = trim($_POST['climate'] ?? '');
    $activities = trim($_POST['activities'] ?? '');
    $landmarks = trim($_POST['landmarks'] ?? '');

    $main_image = '';
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === 0) {
        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $main_image = 'main_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['main_image']['tmp_name'], '../uploads/images/' . $main_image);
    }

    $gallery1 = '';
    if (isset($_FILES['gallery1']) && $_FILES['gallery1']['error'] === 0) {
        $ext = pathinfo($_FILES['gallery1']['name'], PATHINFO_EXTENSION);
        $gallery1 = 'g1_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['gallery1']['tmp_name'], '../uploads/images/' . $gallery1);
    }

    $gallery2 = '';
    if (isset($_FILES['gallery2']) && $_FILES['gallery2']['error'] === 0) {
        $ext = pathinfo($_FILES['gallery2']['name'], PATHINFO_EXTENSION);
        $gallery2 = 'g2_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['gallery2']['tmp_name'], '../uploads/images/' . $gallery2);
    }

    $gallery3 = '';
    if (isset($_FILES['gallery3']) && $_FILES['gallery3']['error'] === 0) {
        $ext = pathinfo($_FILES['gallery3']['name'], PATHINFO_EXTENSION);
        $gallery3 = 'g3_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['gallery3']['tmp_name'], '../uploads/images/' . $gallery3);
    }

    $stmt = $conn->prepare("INSERT INTO regions (name, category, description, facts, climate, activities, landmarks, main_image, gallery_image1, gallery_image2, gallery_image3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $category, $description, $facts, $climate, $activities, $landmarks, $main_image, $gallery1, $gallery2, $gallery3]);

    $_SESSION['message'] = 'تم إضافة السجل بنجاح';
    $_SESSION['msg_type'] = 'success';
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة محتوى - اكتشف السعودية</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header class="navbar admin-navbar">
    <a href="dashboard.php" class="logo">لوحة تحكم <span>المشرف</span></a>
    <nav>
        <a href="dashboard.php">لوحة التحكم</a>
        <a href="logout.php">تسجيل الخروج</a>
        <button class="night-toggle" onclick="toggleNightMode()">&#9790;</button>
    </nav>
</header>

<div class="form-container">
    <div class="form-box">
        <h2>إضافة مكان جديد</h2>

        <form method="POST" enctype="multipart/form-data" onsubmit="return validateContentForm(this)">
            <div class="form-group">
                <label>اسم المكان <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="مثال: الرياض">
                <div class="error-text"></div>
            </div>

            <div class="form-group">
                <label>الصورة الرئيسية للمكان <span class="required">*</span></label>
                <input type="file" id="main_image" name="main_image" class="form-control" accept="image/*" required>
                <div class="error-text"></div>
            </div>

            <div class="form-group">
                <label>الوصف <span class="required">*</span></label>
                <textarea id="description" name="description" class="form-control" placeholder="اكتب وصفاً للمنطقة..."></textarea>
                <div class="error-text"></div>
            </div>

            <div class="form-group">
                <label>الموقع <span class="required">*</span></label>
                <select id="category" name="category" class="form-control">
                    <option value="">اختر المنطقة...</option>
                    <option value="وسطى">وسطى</option>
                    <option value="غربية">غربية</option>
                    <option value="شرقية">شرقية</option>
                    <option value="شمالية">شمالية</option>
                    <option value="جنوبية">جنوبية</option>
                </select>
                <div class="error-text"></div>
            </div>

            <div class="form-group">
                <label>حقائق (كل حقيقة في سطر جديد)</label>
                <textarea name="facts" class="form-control" rows="5" placeholder="اكتب كل حقيقة في سطر منفصل..."></textarea>
            </div>

            <div class="form-group">
                <label>المناخ</label>
                <textarea name="climate" class="form-control" rows="3" placeholder="وصف مناخ المنطقة..."></textarea>
            </div>

            <div class="form-group">
                <label>الأنشطة (افصل بينها بنقطة)</label>
                <input type="text" name="activities" class="form-control" placeholder="مثال: زيارة المتاحف. التسوق. استكشاف الأحياء">
            </div>

            <div class="form-group">
                <label>المعالم (افصل بينها بنقطة)</label>
                <input type="text" name="landmarks" class="form-control" placeholder="مثال: برج المملكة, قلعة المصمك">
            </div>

            <h3 style="margin: 1.5rem 0 1rem; font-size: 1.1rem; color: var(--primary);">صور المعرض</h3>

            <div class="form-group">
                <label>صورة المعرض الأولى</label>
                <input type="file" name="gallery1" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label>صورة المعرض الثانية (اختياري)</label>
                <input type="file" name="gallery2" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label>صورة المعرض الثالثة (اختياري)</label>
                <input type="file" name="gallery3" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-success btn-block">إضافة المكان</button>
        </form>
    </div>
</div>

<footer class="footer">
    &copy; اكتشف السعودية &mdash; جامعة الملك سعود.
</footer>

<script src="../js/main.js"></script>
</body>
</html>
