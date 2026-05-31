<?php
require_once 'auth.php';
require_once '../config/db.php';

if (!isset($_GET['id']) && !isset($_POST['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'] ?? $_POST['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $facts = trim($_POST['facts'] ?? '');
    $climate = trim($_POST['climate'] ?? '');
    $activities = trim($_POST['activities'] ?? '');
    $landmarks = trim($_POST['landmarks'] ?? '');

    $stmt = $conn->prepare("SELECT * FROM regions WHERE id = ?");
    $stmt->execute([$id]);
    $old = $stmt->fetch(PDO::FETCH_ASSOC);

    $main_image = $old['main_image'];
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] === 0) {
        $ext = pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION);
        $main_image = 'main_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['main_image']['tmp_name'], '../uploads/images/' . $main_image);
    }

    $gallery1 = $old['gallery_image1'];
    if (isset($_POST['remove_gallery1'])) {
        if (!empty($gallery1) && file_exists('../uploads/images/' . $gallery1)) unlink('../uploads/images/' . $gallery1);
        $gallery1 = '';
    }
    if (isset($_FILES['gallery1']) && $_FILES['gallery1']['error'] === 0) {
        $ext = pathinfo($_FILES['gallery1']['name'], PATHINFO_EXTENSION);
        $gallery1 = 'g1_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['gallery1']['tmp_name'], '../uploads/images/' . $gallery1);
    }

    $gallery2 = $old['gallery_image2'];
    if (isset($_POST['remove_gallery2'])) {
        if (!empty($gallery2) && file_exists('../uploads/images/' . $gallery2)) unlink('../uploads/images/' . $gallery2);
        $gallery2 = '';
    }
    if (isset($_FILES['gallery2']) && $_FILES['gallery2']['error'] === 0) {
        $ext = pathinfo($_FILES['gallery2']['name'], PATHINFO_EXTENSION);
        $gallery2 = 'g2_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['gallery2']['tmp_name'], '../uploads/images/' . $gallery2);
    }

    $gallery3 = $old['gallery_image3'];
    if (isset($_POST['remove_gallery3'])) {
        if (!empty($gallery3) && file_exists('../uploads/images/' . $gallery3)) unlink('../uploads/images/' . $gallery3);
        $gallery3 = '';
    }
    if (isset($_FILES['gallery3']) && $_FILES['gallery3']['error'] === 0) {
        $ext = pathinfo($_FILES['gallery3']['name'], PATHINFO_EXTENSION);
        $gallery3 = 'g3_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['gallery3']['tmp_name'], '../uploads/images/' . $gallery3);
    }

    $stmt = $conn->prepare("UPDATE regions SET name=?, category=?, description=?, facts=?, climate=?, activities=?, landmarks=?, main_image=?, gallery_image1=?, gallery_image2=?, gallery_image3=? WHERE id=?");
    $stmt->execute([$name, $category, $description, $facts, $climate, $activities, $landmarks, $main_image, $gallery1, $gallery2, $gallery3, $id]);

    $_SESSION['message'] = 'تم تحديث السجل بنجاح';
    $_SESSION['msg_type'] = 'success';
    header("Location: dashboard.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM regions WHERE id = ?");
$stmt->execute([$id]);
$region = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$region) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحديث محتوى - اكتشف السعودية</title>
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
        <h2>تحديث مكان</h2>

        <form method="POST" enctype="multipart/form-data" onsubmit="return validateContentForm(this)">
            <input type="hidden" name="id" value="<?php echo $region['id']; ?>">

            <div class="form-group">
                <label>اسم المكان <span class="required">*</span></label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($region['name']); ?>">
                <div class="error-text"></div>
            </div>

            <div class="form-group">
                <label>تحديث الصورة الرئيسية (اختياري)</label>
                <input type="file" name="main_image" class="form-control" accept="image/*">
                <?php if (!empty($region['main_image'])): ?>
                <div class="current-image">
                    <span>الصورة الرئيسية الحالية</span>
                    <img src="../uploads/images/<?php echo htmlspecialchars($region['main_image']); ?>" alt="الصورة الحالية">
                </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>الوصف <span class="required">*</span></label>
                <textarea id="description" name="description" class="form-control"><?php echo htmlspecialchars($region['description']); ?></textarea>
                <div class="error-text"></div>
            </div>

            <div class="form-group">
                <label>الموقع <span class="required">*</span></label>
                <select id="category" name="category" class="form-control">
                    <option value="">اختر المنطقة...</option>
                    <option value="وسطى" <?php echo $region['category'] === 'وسطى' ? 'selected' : ''; ?>>وسطى</option>
                    <option value="غربية" <?php echo $region['category'] === 'غربية' ? 'selected' : ''; ?>>غربية</option>
                    <option value="شرقية" <?php echo $region['category'] === 'شرقية' ? 'selected' : ''; ?>>شرقية</option>
                    <option value="شمالية" <?php echo $region['category'] === 'شمالية' ? 'selected' : ''; ?>>شمالية</option>
                    <option value="جنوبية" <?php echo $region['category'] === 'جنوبية' ? 'selected' : ''; ?>>جنوبية</option>
                </select>
                <div class="error-text"></div>
            </div>

            <div class="form-group">
                <label>حقائق (كل حقيقة في سطر جديد)</label>
                <textarea name="facts" class="form-control" rows="5"><?php echo htmlspecialchars($region['facts'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>المناخ</label>
                <textarea name="climate" class="form-control" rows="3"><?php echo htmlspecialchars($region['climate'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>الأنشطة (افصل بينها بنقطة)</label>
                <input type="text" name="activities" class="form-control" value="<?php echo htmlspecialchars($region['activities']); ?>">
            </div>

            <div class="form-group">
                <label>المعالم (افصل بينها بنقطة)</label>
                <input type="text" name="landmarks" class="form-control" value="<?php echo htmlspecialchars($region['landmarks']); ?>">
            </div>

            <h3 style="margin: 1.5rem 0 1rem; font-size: 1.1rem; color: var(--primary);">صور المعرض</h3>

            <?php
            $slots = [
                1 => ['field' => 'gallery_image1', 'name' => 'gallery1', 'label' => 'صورة المعرض الأولى'],
                2 => ['field' => 'gallery_image2', 'name' => 'gallery2', 'label' => 'صورة المعرض الثانية'],
                3 => ['field' => 'gallery_image3', 'name' => 'gallery3', 'label' => 'صورة المعرض الثالثة'],
            ];
            ?>
            <?php foreach ($slots as $num => $slot): ?>
            <div class="form-group" style="background: var(--bg); padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                <label><?php echo $slot['label']; ?></label>
                <?php if (!empty($region[$slot['field']])): ?>
                    <div style="display: flex; align-items: center; gap: 1rem; margin: 0.5rem 0;">
                        <img src="../uploads/images/<?php echo htmlspecialchars($region[$slot['field']]); ?>" alt="صورة" style="width:120px;height:80px;object-fit:cover;border-radius:6px;border:1px solid var(--border);">
                        <div>
                            <span style="font-size: 0.85rem; color: var(--success); display: block;">صورة موجودة</span>
                            <label style="font-size: 0.85rem; color: var(--danger); cursor: pointer;">
                                <input type="checkbox" name="remove_gallery<?php echo $num; ?>" value="1"> حذف هذه الصورة
                            </label>
                        </div>
                    </div>
                    <label style="font-size: 0.85rem; color: var(--text-light); margin-top: 0.5rem; display: block;">استبدال بصورة جديدة:</label>
                <?php else: ?>
                    <span style="font-size: 0.85rem; color: var(--text-light); display: block; margin: 0.3rem 0;">لا توجد صورة</span>
                <?php endif; ?>
                <input type="file" name="<?php echo $slot['name']; ?>" class="form-control" accept="image/*">
            </div>
            <?php endforeach; ?>

            <button type="submit" class="btn btn-success btn-block">حفظ التعديلات</button>
        </form>
    </div>
</div>

<footer class="footer">
    &copy; اكتشف السعودية &mdash; جامعة الملك سعود.
</footer>

<script src="../js/main.js"></script>
</body>
</html>
