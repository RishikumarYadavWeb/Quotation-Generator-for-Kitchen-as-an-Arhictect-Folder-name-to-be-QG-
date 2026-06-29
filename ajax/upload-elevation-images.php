<?php
header('Content-Type: application/json');
$response = [];
$uploadDir = __DIR__ . '/../uploads/line-images/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
if (!isset($_FILES['elevation_images'])) {
    echo json_encode(['status' => true,'images' => []]);
    exit;
}
foreach ($_FILES['elevation_images']['tmp_name'] as $elevationIndex => $images) {
    foreach ($images as $imageIndex => $tmpPath) {
        if (empty($tmpPath)) {continue;}
        $originalName = $_FILES['elevation_images']['name'][$elevationIndex][$imageIndex];
        $extension = strtolower(pathinfo($originalName,PATHINFO_EXTENSION));
        $newFileName ='line_' .time() . '_' .rand(1000, 9999) .'.jpg';
        $targetPath = $uploadDir . $newFileName;
        $source = null;
        if ($extension === 'png') {
            $source = imagecreatefrompng($tmpPath);
        }
        if ($extension === 'jpg' || $extension === 'jpeg') {
            $source = imagecreatefromjpeg($tmpPath);
        }
        if (!$source) {
            continue;
        }
        $canvas = imagecreatetruecolor(imagesx($source),imagesy($source));
        $white = imagecolorallocate($canvas,255,255,255);
        imagefill($canvas,0,0,$white);
        imagecopy($canvas,$source,0,0,0,0,imagesx($source),imagesy($source));
        imagejpeg($canvas,$targetPath,95);
        imagedestroy($source);
        imagedestroy($canvas);
        $response[$elevationIndex][] = $newFileName;
    }
}
echo json_encode(['status' => true,'images' => $response]);