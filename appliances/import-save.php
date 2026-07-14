<?php
include '../includes/auth.php';
include '../db.php';
/** @var mysqli $conn */
if (!can('appliances_import')) {
    die('Access Denied');
}
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die('Invalid Request');
}
if (
    !isset($_FILES['csv_file']) ||
    $_FILES['csv_file']['error'] != 0
) {
    die('Please select a CSV file.');
}
$file = $_FILES['csv_file']['tmp_name'];
$replaceAll = isset($_POST['replace_all']) ? 1 : 0;
if ($replaceAll == 1) {
    mysqli_query($conn, " SET FOREIGN_KEY_CHECKS = 0 ");
    mysqli_query($conn, " TRUNCATE TABLE appliances ");
    mysqli_query($conn, " SET FOREIGN_KEY_CHECKS = 1 ");
}
$handle = fopen($file, "r");
if (!$handle) {
    die("Unable to read CSV.");
}
/* Skip Header */
$header = fgetcsv($handle);
$inserted = 0;
$updated = 0;
$failed = 0;
$failedRows = [];
$rowNumber = 1;
while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
    $rowNumber++;
    if (count($data) < 5) {
        $failed++;
        $failedRows[] = [
            'row' => $rowNumber,
            'appliance' => $data[0] ?? '',
            'company' => $data[1] ?? '',
            'description' => $data[2] ?? '',
            'unit' => $data[3] ?? '',
            'price' => $data[4] ?? '',
            'reason' => 'Invalid Column Count'
        ];
        continue;
    }
    $applianceName = ucfirst(trim($data[0]));
    $companyName = ucfirst(trim($data[1]));
    $description = trim($data[2]);
    $applianceName = mysqli_real_escape_string($conn,$applianceName);
    $companyName = mysqli_real_escape_string($conn,$companyName);
    $description = mysqli_real_escape_string($conn,$description);
    $unit = mysqli_real_escape_string($conn,trim($data[3]));
    $price = (float)$data[4];
    if (empty($applianceName)) {
        $failed++;
        $failedRows[] = [
            'row' => $rowNumber,
            'appliance' => '',
            'company' => $companyName,
            'description' => $description,
            'unit' => $unit,
            'price' => $price,
            'reason' => 'Appliance Name Missing'
        ];
        continue;
    }
    if (empty($companyName)) {
        $failed++;
        $failedRows[] = [
            'row' => $rowNumber,
            'appliance' => $applianceName,
            'company' => '',
            'description' => $description,
            'unit' => $unit,
            'price' => $price,
            'reason' => 'Company Name Missing'
        ];
        continue;
    }
    if (empty($description)) {
        $failed++;
        $failedRows[] = [
            'row' => $rowNumber,
            'appliance' => $applianceName,
            'company' => $companyName,
            'description' => '',
            'unit' => $unit,
            'price' => $price,
            'reason' => 'Description Missing'
        ];
        continue;
    }
    if (empty($unit)) {
        $failed++;
        $failedRows[] = [
            'row' => $rowNumber,
            'appliance' => $applianceName,
            'company' => $companyName,
            'description' => $description,
            'unit' => '',
            'price' => $price,
            'reason' => 'Unit Missing'
        ];
        continue;
    }
    if ($price <= 0) {
        $failed++;
        $failedRows[] = [
            'row' => $rowNumber,
            'appliance' => $applianceName,
            'company' => $companyName,
            'description' => $description,
            'unit' => $unit,
            'price' => $price,
            'reason' => 'Invalid Price'
        ];
        continue;
    }
    /* CHECK EXISTING */
    $check = mysqli_query(
        $conn,
        "
        SELECT id
        FROM appliances
        WHERE
            appliance_name = '$applianceName'
            AND company_name = '$companyName'
            AND description = '$description'
        LIMIT 1
        "
    );
    if (mysqli_num_rows($check) > 0) {
        $existingId = mysqli_fetch_assoc($check)['id'];
        mysqli_query(
            $conn,
            "
            UPDATE appliances
            SET
                unit = '$unit',
                price = '$price',
                status = 1
            WHERE id = '$existingId'
            "
        );
        $updated++;
    } else {
        mysqli_query(
            $conn,
            "
            INSERT INTO appliances
            (
                appliance_name,
                company_name,
                description,
                unit,
                price,
                status
            )
            VALUES
            (
                '$applianceName',
                '$companyName',
                '$description',
                '$unit',
                '$price',
                '1'
            )
            "
        );
        $inserted++;
    }
}
fclose($handle);
include '../includes/header.php';
include '../includes/sidebar.php';
?>
<style>.import-summary{max-width:900px;margin:60px auto;background:#fff;border-radius:18px;padding:35px;box-shadow:0 10px 30px rgba(0,0,0,.08);}.import-icon{width:90px;height:90px;border-radius:50%;background:#22c55e;color:#fff;display:flex;align-items:center;justify-content:center;font-size:40px;margin:0 auto 25px;}.summary-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin:35px 0;}.summary-card{border:1px solid #e5e7eb;border-radius:12px;padding:20px;text-align:center;}.summary-card h2{margin:0;font-size:32px;}.summary-card p{margin:8px 0 0;color:#666;}.failed-box{margin-top:30px;border:1px solid #e5e7eb;border-radius:12px;max-height:300px;overflow:auto;}.failed-box table{width:100%;border-collapse:collapse;}.failed-box th,.failed-box td{padding:12px;border-bottom:1px solid #eee;}.import-actions{text-align:center;margin-top:35px;}</style>
<div class="import-summary">
    <div class="import-icon">✓</div>
    <h2 style="text-align:center;margin-bottom:10px;">Import Completed Successfully</h2>
    <p style="text-align:center;color:#666;">Appliance catalogue has been processed.</p>
    <div class="summary-grid">
        <div class="summary-card">
            <h2 style="color:#16a34a;"><?= $inserted ?></h2>
            <p>Inserted</p>
        </div>
        <div class="summary-card">
            <h2 style="color:#2563eb;"><?= $updated ?></h2>
            <p>Updated</p>
        </div>
        <div class="summary-card">
            <h2 style="color:#dc2626;"><?= $failed ?></h2>
            <p>Failed</p>
        </div>
    </div>
    <?php if($failed > 0){ ?>
    <div class="failed-box">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Row</th>
                    <th>Appliance</th>
                    <th>Company</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Reason</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($failedRows as $row){ ?>
                <tr>
                    <td><?= $row['row'] ?></td>
                    <td><?= htmlspecialchars($row['appliance']) ?></td>
                    <td><?= htmlspecialchars($row['company']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['unit']) ?></td>
                    <td><?= $row['price'] == '' ? '-' : number_format((float)$row['price'],2) ?></td>
                    <td><span style="color:#dc2626;font-weight:600;"><?= htmlspecialchars($row['reason']) ?></span></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php }else{ ?>
    <div style="margin-top:30px;padding:20px;background:#ecfdf5;border:1px solid #86efac;border-radius:12px;text-align:center;font-weight:600;color:#15803d;">🎉 No failed records. All appliances imported successfully.</div>
    <style>.back-btn-wrapper{display:flex;justify-content:flex-end;margin-top:30px;}.back-btn{display:inline-flex;align-items:center;gap:10px;padding:12px 22px;background:#1f2937;color:#fff;text-decoration:none;border-radius:10px;font-weight:600;transition:all .3s ease;box-shadow:0 4px 12px rgba(0,0,0,.12);}.back-btn:hover{background:#111827;transform:translateY(-2px);color:#fff;box-shadow:0 8px 18px rgba(0,0,0,.18);}.back-btn i{font-size:14px;}</style>
    <div class="back-btn-wrapper">
        <a href="manage.php" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Appliances
        </a>
    </div>
    <?php } ?>
</div>