<?php
/** @var mysqli $conn */
include '../includes/auth.php';
include '../includes/proforma-number.php';
require '../db.php';
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
header('Content-Type: application/json');
$data = json_decode(
    file_get_contents('php://input'),
    true
);
$uploadedLineImages = $data['uploaded_line_images'] ?? [];
mysqli_begin_transaction($conn);
try{ 
    $entityId = (int)($data['entity_id'] ?? 0);
    $clientName = mysqli_real_escape_string( $conn, $data['client_name'] ?? '' );
    $phone = mysqli_real_escape_string( $conn, $data['phone'] ?? '' );
    $email = mysqli_real_escape_string( $conn, $data['email'] ?? '' );
    $gstNumber = mysqli_real_escape_string( $conn, $data['gst_number'] ?? '' );
    $panNumber = mysqli_real_escape_string( $conn, $data['pan_number'] ?? '' );
    $address = mysqli_real_escape_string( $conn, $data['address'] ?? '' );
    $shippingAddress = mysqli_real_escape_string( $conn, $data['shipping_address'] ?? '' );
    $projectType = mysqli_real_escape_string( $conn, $data['project_type'] ?? '' );
    $totalSqft = (float)preg_replace( '/[^0-9.]/', '', $data['total_sqft'] ?? 0 );
    $grandTotal = (float)preg_replace( '/[^0-9.]/', '', $data['grand_total'] ?? 0 );
    $packingCharge = (float)preg_replace( '/[^0-9.]/', '', $data['packing_charge'] ?? 0 );
    $installationCharge = (float)preg_replace( '/[^0-9.]/', '', $data['installation_charge'] ?? 0 );
    $specialDiscount = (float)preg_replace( '/[^0-9.]/', '', $data['special_discount'] ?? 0 );
    $finalCustomerPrice = (float)preg_replace( '/[^0-9.]/', '', $data['final_customer_price'] ?? 0 );
    mysqli_query( $conn,
        "
        INSERT INTO clients(
            client_name,
            address,
            gst_number,
            pan_number,
            email,
            phone,
            shipping_address
        )
        VALUES(
            '$clientName',
            '$address',
            '$gstNumber',
            '$panNumber',
            '$email',
            '$phone',
            '$shippingAddress'
        )
        "
    );
    $clientId = mysqli_insert_id($conn);
    $createdBy = $_SESSION['user_id'];
    $proformaNo = generateProformaNumber($conn);
    mysqli_query($conn,
        "
        INSERT INTO quotations(
            client_id,
            entity_id,
            project_type,
            total_sqft,
            grand_total,
            created_by,
            proforma_no,
            packing_charge,
            installation_charge,
            special_discount,
            final_customer_price
        )
        VALUES(
            '$clientId',
            '$entityId',
            '$projectType',
            '$totalSqft',
            '$grandTotal',
            '$createdBy',
            '$proformaNo',
            '$packingCharge',
            '$installationCharge',
            '$specialDiscount',
            '$finalCustomerPrice'
        )
        "
    );
    $quotationId = mysqli_insert_id($conn);
    if(
        isset($data['elevations']) &&
        is_array($data['elevations'])
    ){
        foreach(
            $data['elevations']
            as $index => $elevation
        ){
            $elevationNo = (int)$elevation['elevation_no'];
            $ceilingHeightMM = (float)$elevation['ceiling_height_mm'];
            $ceilingHeightFT = (float)$elevation['ceiling_height_ft'];
            mysqli_query( $conn,
                "
                INSERT INTO elevations(
                    quotation_id,
                    elevation_no,
                    ceiling_height_mm,
                    ceiling_height_ft
                )
                VALUES(
                    '$quotationId',
                    '$elevationNo',
                    '$ceilingHeightMM',
                    '$ceilingHeightFT'
                )
                "
            );
            $elevationId = mysqli_insert_id($conn);
            if (isset($uploadedLineImages[$index])) {
                foreach ($uploadedLineImages[$index] as $imageName) {
                    $imageName = mysqli_real_escape_string($conn,$imageName);
                    mysqli_query(
                        $conn,
                        "
                        INSERT INTO elevation_line_images(
                            elevation_id,
                            image_path
                        )
                        VALUES(
                            '$elevationId',
                            '$imageName'
                        )
                        "
                    );
                }
            }
            foreach(
                $elevation['units']
                as $unit
            ){
                $widthMM = (float)($unit['width_mm'] ?: 0);
                $widthFT = (float)($unit['width_ft'] ?: 0);
                $heightMM = (float)($unit['height_mm'] ?: 0);
                $heightFT = (float)($unit['height_ft'] ?: 0);
                $depthMM = (float)($unit['depth_mm'] ?: 0);
                $sqft = (float)($unit['sqft'] ?: 0);
                $carcassCategory = (int)($unit['carcass_categories_id'] ?: 0);
                $carcassMaterial = (int)($unit['carcass_materials_id'] ?: 0);
                $shutterCategory = (int)($unit['shutter_categories_id'] ?: 0);
                $shutterMaterial = (int)($unit['shutter_materials_id'] ?: 0);
                $carcassTotal = (float)preg_replace( '/[^0-9.]/','',$unit['carcass_total'] ?? 0 );
                $shutterTotal = (float)preg_replace( '/[^0-9.]/','',$unit['shutter_total'] ?? 0 );
                $unitTotal = (float)preg_replace( '/[^0-9.]/','',$unit['unit_total'] ?? 0 );
                $shutterCategoryId = !empty($unit['shutter_categories_id']) ? (int)$unit['shutter_categories_id'] : 0;
                $shutterMaterialId = !empty($unit['shutter_materials_id']) ? (int)$unit['shutter_materials_id'] : 0;
                mysqli_query(
                    $conn,
                    "
                    INSERT INTO units(
                        elevation_id,
                        unit_type,
                        unit_key,
                        width_mm,
                        width_ft,
                        height_mm,
                        height_ft,
                        depth_mm,
                        sqft,
                        carcass_categories_id,
                        carcass_materials_id,
                        carcass_total,
                        shutter_categories_id,
                        shutter_materials_id,
                        shutter_total,
                        unit_total
                    )
                    VALUES(
                        '".$elevationId."',
                        '".$unit['unit_type']."',
                        '".$unit['unit_key']."',
                        '$widthMM',
                        '$widthFT',
                        '$heightMM',
                        '$heightFT',
                        '$depthMM',
                        '$sqft',
                        '".$unit['carcass_categories_id']."',
                        '".$unit['carcass_materials_id']."',
                        '".preg_replace('/[^0-9.]/','',$unit['carcass_total'])."',
                        '$shutterCategoryId',
                        '$shutterMaterialId',
                        '".preg_replace('/[^0-9.]/','',$unit['shutter_total'])."',
                        '".preg_replace('/[^0-9.]/','',$unit['unit_total'])."'
                    )
                    "
                );
            }        
        }
    }
    if(
        isset($data['accessories']) &&
        is_array($data['accessories'])
    ){
        foreach(
            $data['accessories']
            as $accessory
        ){
            $accessoryId = (int)($accessory['accessory_id'] ?? 0);
            $qty = (float)($accessory['qty'] ?? 0);
            $price = (float)preg_replace( '/[^0-9.]/', '', $accessory['price'] ?? 0 );
            $total = (float)preg_replace( '/[^0-9.]/', '', $accessory['total'] ?? 0 );
            mysqli_query($conn,
                "
                INSERT INTO quotation_accessories(
                    quotation_id,
                    accessory_id,
                    qty,
                    price,
                    total
                )
                VALUES(
                    '$quotationId',
                    '$accessoryId',
                    '$qty',
                    '$price',
                    '$total'
                )
                "
            );
        }
    }
    if(
        isset($data['drawers']) &&
        is_array($data['drawers'])
    ){
        foreach(
            $data['drawers']
            as $drawer
        ){
            $drawerPrice = (float)preg_replace( '/[^0-9.]/', '', $drawer['price'] ?? 0 );
            $drawerTotal = (float)preg_replace( '/[^0-9.]/', '', $drawer['total'] ?? 0 );
            $assignedUnitId = $drawer['assigned_unit_id'] ?? '';
            $quantity = (int)($drawer['quantity'] ?? 1);
            mysqli_query($conn,
                "
                INSERT INTO drawers_data(
                    quotation_id,
                    assigned_unit_id,
                    quantity,
                    drawer_categories_id,
                    drawer_materials_id,
                    width_mm,
                    width_ft,
                    height_mm,
                    height_ft,
                    sqft,
                    price,
                    total
                )
                VALUES(
                    '$quotationId',
                    '$assignedUnitId',
                    '$quantity',
                    '".(int)($drawer['drawer_categories_id'] ?? 0)."',
                    '".(int)($drawer['drawer_materials_id'] ?? 0)."',
                    '".(float)($drawer['width_mm'] ?? 0)."',
                    '".(float)($drawer['width_ft'] ?? 0)."',
                    '".(float)($drawer['height_mm'] ?? 0)."',
                    '".(float)($drawer['height_ft'] ?? 0)."',
                    '".(float)($drawer['sqft'] ?? 0)."',
                    '$drawerPrice',
                    '$drawerTotal'
                )
                "
            );
        }
    }
    if(
        isset($data['shelves']) &&
        is_array($data['shelves'])
    ){
        foreach(
            $data['shelves']
            as $shelf
        ){
            $shelfCategory = (int)($shelf['shelf_categories_id'] ?? 0);
            $shelfMaterial = (int)($shelf['shelf_materials_id'] ?? 0);
            $widthMM = (float)($shelf['width_mm'] ?? 0);
            $widthFT = (float)($shelf['width_ft'] ?? 0);
            $heightMM = (float)($shelf['height_mm'] ?? 0);
            $heightFT = (float)($shelf['height_ft'] ?? 0);
            $price = (float)preg_replace( '/[^0-9.]/', '', $shelf['price'] ?? 0 );
            $total = (float)preg_replace( '/[^0-9.]/', '', $shelf['total'] ?? 0 );
            $assignedUnitId = $shelf['assigned_unit_id'] ?? '';
            $quantity = (int)($shelf['quantity'] ?? 1);
            mysqli_query($conn,
                "
                INSERT INTO shelves_data(
                    quotation_id,
                    assigned_unit_id,
                    quantity,
                    shelf_categories_id,
                    shelf_materials_id,
                    width_mm,
                    width_ft,
                    height_mm,
                    height_ft,
                    price,
                    total
                )
                VALUES(
                    '$quotationId',
                    '$assignedUnitId',
                    '$quantity',
                    '$shelfCategory',
                    '$shelfMaterial',
                    '$widthMM',
                    '$widthFT',
                    '$heightMM',
                    '$heightFT',
                    '$price',
                    '$total'
                )
                "
            );
        }
    }
    mysqli_commit($conn); mysqli_report(
        MYSQLI_REPORT_ERROR |
        MYSQLI_REPORT_STRICT
    );
    echo json_encode([
        'status' => true,
        'quotation_id' => $quotationId
    ]);
}catch(Exception $e){
    mysqli_rollback($conn);
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}