<?php
include '../includes/auth.php';
include '../db.php';
if(!can('appliances_export')){
    die('Access Denied');
}
/** @var mysqli $conn */
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=appliances_'.date('Ymd_His').'.csv');
$output = fopen('php://output', 'w');
fputcsv(
    $output,
    [
        'Appliance Name',
        'Company Name',
        'Description',
        'Unit',
        'Price'
    ]
);
$query = mysqli_query(
    $conn,
    "
    SELECT appliance_name,company_name,description,unit,price
    FROM appliances
    WHERE status = 1
    ORDER BY appliance_name,company_name,description
    "
);
while($row = mysqli_fetch_assoc($query)){
    fputcsv(
        $output,
        [
            $row['appliance_name'],
            $row['company_name'],
            $row['description'],
            $row['unit'],
            $row['price']
        ]
    );
}
fclose($output);
exit;

