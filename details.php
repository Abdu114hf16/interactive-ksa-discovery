<?php
require_once 'config/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: gallery.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM regions WHERE id = ?");
$stmt->execute([$_GET['id']]);
$region = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$region) {
    header("Location: gallery.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($region['name']); ?> - اكتشف السعودية</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="navbar">
    <a href="index.php" class="logo">اكتشف <span>السعودية</span></a>
    <nav>
        <a href="index.php">الرئيسية</a>
        <a href="gallery.php">معرض المناطق</a>
        <a href="about.php">حول</a>
        <a href="admin/login.php">دخول المشرف</a>
        <button class="night-toggle" onclick="toggleNightMode()">&#9790;</button>
    </nav>
</header>

<div class="detail-hero">
    <?php if (!empty($region['main_image'])): ?>
        <img src="uploads/images/<?php echo htmlspecialchars($region['main_image']); ?>" alt="<?php echo htmlspecialchars($region['name']); ?>">
    <?php else: ?>
        <div class="placeholder-img" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem;">🏙️</div>
    <?php endif; ?>
</div>

<div class="detail-content">
    <h1><?php echo htmlspecialchars($region['name']); ?></h1>
    <p class="desc"><?php echo htmlspecialchars($region['description']); ?></p>

    <?php if (!empty($region['facts'])): ?>
    <div class="info-section">
        <h2>حقائق</h2>
        <ul>
            <?php foreach (explode("\n", $region['facts']) as $fact): ?>
                <?php $fact = trim($fact); if ($fact === '') continue; ?>
                <li><?php echo htmlspecialchars($fact); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if (!empty($region['landmarks'])): ?>
    <div class="info-section">
        <h2>أبرز المعالم</h2>
        <ul>
            <?php foreach (explode('.', $region['landmarks']) as $landmark): ?>
                <li><?php echo htmlspecialchars(trim($landmark)); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if (!empty($region['activities'])): ?>
    <div class="info-section">
        <h2>الأنشطة</h2>
        <ul>
            <?php foreach (explode('.', $region['activities']) as $activity): ?>
                <li><?php echo htmlspecialchars(trim($activity)); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if (!empty($region['climate'])): ?>
    <div class="info-section">
        <h2>المناخ</h2>
        <p style="line-height: 1.9;"><?php echo htmlspecialchars($region['climate']); ?></p>
    </div>
    <?php endif; ?>

    <?php
    $gallery_images = [];
    if (!empty($region['gallery_image1'])) $gallery_images[] = $region['gallery_image1'];
    if (!empty($region['gallery_image2'])) $gallery_images[] = $region['gallery_image2'];
    if (!empty($region['gallery_image3'])) $gallery_images[] = $region['gallery_image3'];
    ?>
    <?php if (!empty($gallery_images)): ?>
    <div class="info-section">
        <h2>معرض الصور</h2>
        <div class="detail-gallery">
            <?php foreach ($gallery_images as $img): ?>
                <img src="uploads/images/<?php echo htmlspecialchars($img); ?>" alt="صورة">
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<footer class="footer">
    &copy; اكتشف السعودية &mdash; جامعة الملك سعود.
</footer>

<script src="js/main.js"></script>
</body>
</html>
