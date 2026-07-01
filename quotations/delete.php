<?php
include '../db.php';
/** @var mysqli $conn */
$id = (int)($_GET['id'] ?? 0);
if(!$id){die('Invalid Quotation ID');}
$quotationQuery = mysqli_query(
    $conn,
    "
    SELECT client_id
    FROM quotations
    WHERE id = '$id'
    LIMIT 1
    "
);
$quotation = mysqli_fetch_assoc($quotationQuery);
if(!$quotation){die('Quotation not found');}
$clientId = $quotation['client_id'] ?? 0;
$imageQuery = mysqli_query(
    $conn,
    "
    SELECT eli.image_path
    FROM elevation_line_images eli
    INNER JOIN elevations e
        ON eli.elevation_id = e.id
    WHERE e.quotation_id = '$id'
    "
);
while($image = mysqli_fetch_assoc($imageQuery)){
    if(!empty($image['image_path'])){
        $filePath = "../uploads/line-images/" . $image['image_path'];
        if(file_exists($filePath)){
            unlink($filePath);
        }
    }
}
mysqli_query(
    $conn,
    "
    DELETE eli
    FROM elevation_line_images eli
    INNER JOIN elevations e
        ON eli.elevation_id = e.id
    WHERE e.quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE FROM drawers_data
    WHERE quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE FROM shelves_data
    WHERE quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE FROM quotation_accessories
    WHERE quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE u
    FROM units u
    INNER JOIN elevations e
        ON u.elevation_id = e.id
    WHERE e.quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE FROM elevations
    WHERE quotation_id = '$id'
    "
);
mysqli_query(
    $conn,
    "
    DELETE FROM quotations
    WHERE id = '$id'
    "
);
if($clientId){
    $checkClient = mysqli_query(
        $conn,
        "
        SELECT COUNT(*) AS total
        FROM quotations
        WHERE client_id = '$clientId'
        "
    );
    $clientData = mysqli_fetch_assoc($checkClient);
    if(($clientData['total'] ?? 0) == 0){
        mysqli_query(
            $conn,
            "
            DELETE FROM clients
            WHERE id = '$clientId'
            "
        );
    }
}
header('Location: manage.php');
exit;
?>