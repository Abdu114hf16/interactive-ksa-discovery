<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حول الموقع - اكتشف السعودية</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="navbar">
    <a href="index.php" class="logo">اكتشف <span>السعودية</span></a>
    <nav>
        <a href="index.php">الرئيسية</a>
        <a href="gallery.php">معرض المناطق</a>
        <a href="about.php" class="active">حول</a>
        <a href="admin/login.php">دخول المشرف</a>
        <button class="night-toggle" onclick="toggleNightMode()">&#9790;</button>
    </nav>
</header>

<section class="hero" style="padding: 2.5rem 2rem;">
    <h1>حول الموقع</h1>
    <p>تعرّف على الموقع والغرض منه</p>
</section>

<div class="about-container">
    <div class="about-box">
        <h2>عن المشروع</h2>
        <p>موقع "اكتشف السعودية" هو مشروع أكاديمي تم تطويره ضمن متطلبات مقرر CSC457 - تقنيات الإنترنت في جامعة الملك سعود. يهدف الموقع إلى تقديم تجربة تفاعلية للتعريف بمناطق المملكة العربية السعودية من خلال عرض معلومات ثقافية وجغرافية وسياحية عن أبرز المدن والمعالم.</p>

        <h2>الغرض</h2>
        <p>تطبيق عملي لتقنيات تطوير الويب الأساسية المدروسة في المقرر، ويشمل ذلك: بناء واجهات المستخدم باستخدام HTML وCSS، إضافة التفاعلية عبر JavaScript، وبرمجة الخادم باستخدام PHP مع قاعدة بيانات MySQL لإدارة المحتوى ديناميكياً.</p>

        <h2>مميزات الموقع</h2>
        <p>يتضمن الموقع صفحات عامة لعرض المناطق ومعرض الصور والتفاصيل، بالإضافة إلى لوحة تحكم للمشرف تتيح إضافة وتعديل وحذف المحتوى. كما يدعم الوضع الليلي وخاصية البحث والتصفية.</p>

        <div class="contact-info">
            <h2 style="border: none; padding: 0; margin-bottom: 0.8rem;">المطور</h2>
            <p><strong>الاسم:</strong> عبدالله الشمري</p>
            <p><strong>البريد الإلكتروني:</strong> <a href="mailto:abdu114hf16@gmail.com">abdu114hf16@gmail.com</a></p>
            <p><strong>الجامعة:</strong> جامعة الملك سعود</p>
            <p><strong>المقرر:</strong> CSC457 - تقنيات الإنترنت</p>
        </div>
    </div>
</div>

<footer class="footer">
    &copy; اكتشف السعودية &mdash; جامعة الملك سعود.
</footer>

<script src="js/main.js"></script>
</body>
</html>
