<?php
require_once 'auth.php';
require_once '../config/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM regions WHERE id = ?");
$stmt->execute([$id]);
$region = $stmt->fetch(PDO::FETCH_ASSOC);

if ($region) {
    if (!empty($region['main_image']) && file_exists('../uploads/images/' . $region['main_image'])) {
        unlink('../uploads/images/' . $region['main_image']);
    }
    if (!empty($region['gallery_image1']) && file_exists('../uploads/images/' . $region['gallery_image1'])) {
        unlink('../uploads/images/' . $region['gallery_image1']);
    }
    if (!empty($region['gallery_image2']) && file_exists('../uploads/images/' . $region['gallery_image2'])) {
        unlink('../uploads/images/' . $region['gallery_image2']);
    }
    if (!empty($region['gallery_image3']) && file_exists('../uploads/images/' . $region['gallery_image3'])) {
        unlink('../uploads/images/' . $region['gallery_image3']);
    }

    $stmt = $conn->prepare("DELETE FROM regions WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['message'] = 'تم حذف السجل بنجاح';
    $_SESSION['msg_type'] = 'success';
} else {
    $_SESSION['message'] = 'السجل غير موجود';
    $_SESSION['msg_type'] = 'error';
}

header("Location: dashboard.php");
exit();
?>
