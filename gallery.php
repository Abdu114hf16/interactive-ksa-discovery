<?php
require_once 'config/db.php';

$stmt = $conn->query("SELECT * FROM regions ORDER BY id ASC");
$regions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = [];
foreach ($regions as $r) {
    if (!in_array($r['category'], $categories)) {
        $categories[] = $r['category'];
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معرض المناطق - اكتشف السعودية</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="navbar">
    <a href="index.php" class="logo">اكتشف <span>السعودية</span></a>
    <nav>
        <a href="index.php">الرئيسية</a>
        <a href="gallery.php" class="active">معرض المناطق</a>
        <a href="about.php">حول</a>
        <a href="admin/login.php">دخول المشرف</a>
        <button class="night-toggle" onclick="toggleNightMode()">&#9790;</button>
    </nav>
</header>

<section class="hero" style="padding: 2.5rem 2rem;">
    <h1>معرض المناطق</h1>
    <p>استمتع بتصفح مناطق المملكة او ابحث للوصول السريع</p>
</section>

<section class="section">
    <div class="gallery-controls">
        <input type="text" id="searchInput" class="search-box" placeholder="ابحث عن منطقة أو مدينة..." oninput="filterRegions()">
        <select id="filterSelect" class="filter-select" onchange="filterRegions()">
            <option value="الكل">كل المناطق</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></option>
            <?php endforeach; ?>
        </select>
        <span id="resultsCount" class="results-count">عدد النتائج: <?php echo count($regions); ?></span>
    </div>

    <div class="gallery-grid">
        <?php foreach ($regions as $region): ?>
            <a href="details.php?id=<?php echo $region['id']; ?>" class="region-card"
               data-name="<?php echo htmlspecialchars($region['name']); ?>"
               data-category="<?php echo htmlspecialchars($region['category']); ?>">
                <div class="card-image <?php echo empty($region['main_image']) ? 'placeholder-img' : ''; ?>"
                     style="<?php echo !empty($region['main_image']) ? 'background-image:url(uploads/images/' . htmlspecialchars($region['main_image']) . ')' : ''; ?>">
                    <?php if (empty($region['main_image'])): ?>🏙️<?php endif; ?>
                    <span class="category-badge"><?php echo htmlspecialchars($region['category']); ?></span>
                </div>
                <div class="card-body">
                    <h3><?php echo htmlspecialchars($region['name']); ?></h3>
                    <p><?php echo htmlspecialchars(mb_substr($region['description'], 0, 80)); ?>...</p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<footer class="footer">
    &copy; اكتشف السعودية &mdash; جامعة الملك سعود.
</footer>

<script src="js/main.js"></script>
</body>
</html>
