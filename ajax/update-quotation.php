<?php
/** @var mysqli $conn */
include '../includes/auth.php';
include '../includes/proforma-number.php';
require '../db.php';
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'),true);
$quotation_id = intval($data['quotation_id']);
$uploadedLineImages = $data['uploaded_line_images'] ?? [];
$projectImages = $data['project_images'] ?? [];
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
    $clientId = (int)$data['client_id'];
    $standardAccessories = $data['standard_accessories'] ?? [];
    mysqli_query($conn,"
        UPDATE clients
        SET
            client_name = '$clientName',
            address = '$address',
            gst_number = '$gstNumber',
            pan_number = '$panNumber',
            email = '$email',
            phone = '$phone',
            shipping_address = '$shippingAddress'
        WHERE id = '$clientId'
    ");
    $createdBy = $_SESSION['user_id'];
    $proformaNo = generateProformaNumber($conn);
    $quotationId = $quotation_id;
    mysqli_query($conn,"
        UPDATE quotations
        SET
            entity_id = '$entityId',
            project_type = '$projectType',
            total_sqft = '$totalSqft',
            grand_total = '$grandTotal',
            packing_charge = '$packingCharge',
            installation_charge = '$installationCharge',
            special_discount = '$specialDiscount',
            final_customer_price = '$finalCustomerPrice',
            updated_at = NOW()
        WHERE id = '$quotationId'
    ");
    mysqli_query($conn,"DELETE FROM quotation_accessories WHERE quotation_id = '$quotationId'");
    mysqli_query($conn,"DELETE FROM quotation_standard_accessories WHERE quotation_id = '$quotationId'");
    mysqli_query($conn,"DELETE FROM drawers_data WHERE quotation_id = '$quotationId'");
    mysqli_query($conn,"DELETE FROM shelves_data WHERE quotation_id = '$quotationId'");
    mysqli_query($conn,"DELETE FROM elevation_line_images WHERE elevation_id IN (SELECT id FROM elevations WHERE quotation_id = '$quotationId')");
    mysqli_query($conn,"DELETE FROM units WHERE elevation_id IN (SELECT id FROM elevations WHERE quotation_id = '$quotationId')");
    mysqli_query($conn,"DELETE FROM elevations WHERE quotation_id = '$quotationId'");
    mysqli_query($conn,"DELETE FROM quotation_panels WHERE quotation_id = '$quotationId'");
    $deletedProjectImages = $data['deleted_project_images'] ?? [];
    if(!is_array($deletedProjectImages)){
        $deletedProjectImages = [];
    }
    foreach($deletedProjectImages as $imageId){
        $imageId = (int)$imageId;
        $imageResult = mysqli_query(
            $conn,
            "
            SELECT image_path
            FROM quotation_images
            WHERE id = '$imageId'
            LIMIT 1
            "
        );
        if($img = mysqli_fetch_assoc($imageResult)){
            $file = dirname(__DIR__) . "/uploads/" . $img['image_path'];
            if(is_file($file)){
                unlink($file);
            }
            mysqli_query(
                $conn,
                "
                DELETE
                FROM quotation_images
                WHERE id = '$imageId'
                "
            );
        }
    }
    $quotationFolder = dirname(__DIR__) . "/uploads/quotations/" . preg_replace('/[^A-Za-z0-9_-]/','_',$proformaNo);
    $renderFolder = $quotationFolder . "/render";
    $floorFolder = $quotationFolder . "/floorplan";
    if(!is_dir($renderFolder)){
        mkdir($renderFolder,0775,true);
    }
    if(!is_dir($floorFolder)){
        mkdir($floorFolder,0775,true);
    }
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
            $showNote = (int)($elevation['show_note']?? 0);
            $elevationNote = mysqli_real_escape_string($conn,$elevation['elevation_note'] ?? '');
            mysqli_query(
                $conn,
                "
                INSERT INTO elevations(
                    quotation_id,
                    elevation_no,
                    ceiling_height_mm,
                    ceiling_height_ft,
                    show_note,
                    elevation_note
                )
                VALUES(
                    '$quotationId',
                    '$elevationNo',
                    '$ceilingHeightMM',
                    '$ceilingHeightFT',
                    '$showNote',
                    '$elevationNote'
                )
                "
            );
            $elevationId = mysqli_insert_id($conn);
            if(
                isset($uploadedLineImages[$elevationNo])
            ){
                foreach(
                    $uploadedLineImages[$elevationNo]
                    as $imageName
                ){
                    $imageName = mysqli_real_escape_string($conn,$imageName);
                    mysqli_query(
                        $conn,
                        "
                        INSERT INTO
                            elevation_line_images(
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
            $oldImages = mysqli_query(
                $conn,
                "
                SELECT *
                FROM quotation_images
                WHERE
                    quotation_id = '$quotationId'
                    AND image_type = 'elevation'
                    AND elevation_no = '".($index + 1)."'
                "
            );
            while($old = mysqli_fetch_assoc($oldImages)){
                mysqli_query(
                    $conn,
                    "
                    INSERT INTO quotation_images(
                        quotation_id,
                        elevation_id,
                        elevation_no,
                        image_type,
                        original_name,
                        stored_name,
                        image_path,
                        enhanced_path,
                        file_size,
                        mime_type,
                        image_width,
                        image_height,
                        is_enhanced
                    )
                    VALUES(
                        '$quotationId',
                        '$elevationId',
                        '".($index + 1)."',
                        'elevation',
                        '".mysqli_real_escape_string($conn,$old['original_name'])."',
                        '".mysqli_real_escape_string($conn,$old['stored_name'])."',
                        '".mysqli_real_escape_string($conn,$old['image_path'])."',
                        '".mysqli_real_escape_string($conn,$old['enhanced_path'])."',
                        '".$old['file_size']."',
                        '".mysqli_real_escape_string($conn,$old['mime_type'])."',
                        '".$old['image_width']."',
                        '".$old['image_height']."',
                        '".$old['is_enhanced']."'
                    )
                    "
                );

            }
            if(!empty($projectImages['elevations'][$index])){
                foreach($projectImages['elevations'][$index] as $image){
                    $imagePath = mysqli_real_escape_string($conn,$image['image_path']);
                    $originalName = mysqli_real_escape_string($conn,$image['original_name']);
                    $storedName = mysqli_real_escape_string($conn,$image['stored_name']);
                    $fileSize = (int)$image['file_size'];
                    $mimeType = mysqli_real_escape_string($conn,$image['mime_type']);
                    $imageWidth = (int)$image['image_width'];
                    $imageHeight = (int)$image['image_height'];
                    $letter = chr(65 + $index);
                    $elevationFolder = $quotationFolder."/elevation_".$letter;
                    if(!is_dir($elevationFolder)){
                        mkdir($elevationFolder,0775,true);
                    }
                    $tempPath = dirname(__DIR__)."/uploads/temp/".$imagePath;
                    $newPath  = $elevationFolder."/".$storedName;
                    if(file_exists($tempPath)){
                        rename($tempPath,$newPath);
                    }
                    $imagePath = "quotations/".preg_replace('/[^A-Za-z0-9_-]/','_',$proformaNo)."/elevation_".$letter."/".$storedName;
                    mysqli_query(
                        $conn,
                        "
                        INSERT INTO quotation_images(
                            quotation_id,
                            elevation_id,
                            elevation_no,
                            image_type,
                            original_name,
                            stored_name,
                            image_path,
                            file_size,
                            mime_type,
                            image_width,
                            image_height
                        )
                        VALUES(
                            '$quotationId',
                            '$elevationId',
                            '".($index + 1)."',
                            'elevation',
                            '$originalName',
                            '$storedName',
                            '$imagePath',
                            '$fileSize',
                            '$mimeType',
                            '$imageWidth',
                            '$imageHeight'
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
        isset($data['visiblePanels']) &&
        is_array($data['visiblePanels'])
    ){
        foreach($data['visiblePanels'] as $panel){
            $width = (float)($panel['width_mm'] ?? 0);
            $height = (float)($panel['height_mm'] ?? 0);
            $sqft = (float)($panel['sqft'] ?? 0);
            $categoryId = (int)($panel['category_id'] ?? 0);
            $materialId = (int)($panel['material_id'] ?? 0);
            $price = (float)($panel['panel_price'] ?? 0);
            mysqli_query(
                $conn,
                "
                INSERT INTO quotation_visible_panels(
                    quotation_id,
                    width_mm,
                    height_mm,
                    sqft,
                    category_id,
                    material_id,
                    panel_price
                )
                VALUES(
                    '$quotationId',
                    '$width',
                    '$height',
                    '$sqft',
                    '$categoryId',
                    '$materialId',
                    '$price'
                )
                "
            );
        }
    }
    if(
        isset($data['visibleSidePanels']) &&
        is_array($data['visibleSidePanels'])
    ){
        foreach($data['visibleSidePanels'] as $panel){
            $width = (float)($panel['width_mm'] ?? 0);
            $height = (float)($panel['height_mm'] ?? 0);
            $sqft = (float)($panel['sqft'] ?? 0);
            $categoryId = (int)($panel['category_id'] ?? 0);
            $materialId = (int)($panel['material_id'] ?? 0);
            $price = (float)($panel['panel_price'] ?? 0);
            mysqli_query(
                $conn,
                "
                INSERT INTO quotation_visible_side_panels(

                    quotation_id,
                    width_mm,
                    height_mm,
                    sqft,
                    category_id,
                    material_id,
                    panel_price

                )
                VALUES(
                    '$quotationId',
                    '$width',
                    '$height',
                    '$sqft',
                    '$categoryId',
                    '$materialId',
                    '$price'
                )
                "
            );
        }
    }
    if(
    isset($data['standard_accessories']) &&
    is_array($data['standard_accessories'])
    ){
        foreach(
            $data['standard_accessories']
            as $accessory
        ){
            $standardAccessoryId = (int)($accessory['standard_accessory_id'] ?? 0);
            $qty = (float)($accessory['qty'] ?? 0);
            $unitPrice = (float)($accessory['unit_price'] ?? 0);
            $totalPrice = (float)($accessory['total_price'] ?? 0);
            mysqli_query(
                $conn,
                "
                INSERT INTO quotation_standard_accessories(
                    quotation_id,
                    standard_accessory_id,
                    qty,
                    unit_price,
                    total_price
                )
                VALUES(
                    '$quotationId',
                    '$standardAccessoryId',
                    '$qty',
                    '$unitPrice',
                    '$totalPrice'
                )
                "
            );
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
            $categoryId = (int)($accessory['category_id'] ?? 0);
            $accessoryId = (int)($accessory['accessory_id'] ?? 0);
            $otherMaterial = mysqli_real_escape_string($conn,trim($accessory['other_material'] ?? ''));
            $qty = (float)($accessory['qty'] ?? 0);
            $price = (float)preg_replace('/[^0-9.]/','',$accessory['price'] ?? 0);
            $total = (float)preg_replace('/[^0-9.]/','',$accessory['total'] ?? 0);
            mysqli_query(
                $conn,
                "
                INSERT INTO quotation_accessories(
                    quotation_id,
                    accessory_id,
                    category_id,
                    other_material,
                    qty,
                    price,
                    total
                )
                VALUES(
                    '$quotationId',
                    '$accessoryId',
                    '$categoryId',
                    '$otherMaterial',
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
    if(!empty($projectImages['render'])){
        foreach($projectImages['render'] as $image){
            $imagePath = mysqli_real_escape_string($conn,$image['image_path']);
            $originalName = mysqli_real_escape_string($conn,$image['original_name']);
            $storedName = mysqli_real_escape_string($conn,$image['stored_name']);
            $fileSize = (int)$image['file_size'];
            $mimeType = mysqli_real_escape_string($conn,$image['mime_type']);
            $imageWidth = (int)$image['image_width'];
            $imageHeight = (int)$image['image_height'];
            $tempPath = dirname(__DIR__)."/uploads/temp/".$imagePath;
            $newPath = $renderFolder."/".$storedName;
            if(file_exists($tempPath)){
                rename($tempPath,$newPath);
            }
            $imagePath = "quotations/".preg_replace('/[^A-Za-z0-9_-]/','_',$proformaNo)."/render/".$storedName;
            mysqli_query(
                $conn,
                "
                INSERT INTO quotation_images(
                    quotation_id,
                    elevation_id,
                    image_type,
                    original_name,
                    stored_name,
                    image_path,
                    file_size,
                    mime_type,
                    image_width,
                    image_height
                )
                VALUES(
                    '$quotationId',
                    NULL,
                    'render',
                    '$originalName',
                    '$storedName',
                    '$imagePath',
                    '$fileSize',
                    '$mimeType',
                    '$imageWidth',
                    '$imageHeight'
                )
                "
            );
        }
    }
    if(!empty($projectImages['floorplan'])){
        foreach($projectImages['floorplan'] as $image){
            $imagePath = mysqli_real_escape_string($conn,$image['image_path']);
            $originalName = mysqli_real_escape_string($conn,$image['original_name']);
            $storedName = mysqli_real_escape_string($conn,$image['stored_name']);
            $fileSize = (int)$image['file_size'];
            $mimeType = mysqli_real_escape_string($conn,$image['mime_type']);
            $imageWidth = (int)$image['image_width'];
            $imageHeight = (int)$image['image_height'];
            $tempPath = dirname(__DIR__)."/uploads/temp/".$imagePath;
            $newPath = $floorFolder."/".$storedName;
            if(file_exists($tempPath)){
                rename($tempPath,$newPath);
            }
            $imagePath = "quotations/".preg_replace('/[^A-Za-z0-9_-]/','_',$proformaNo)."/floorplan/".$storedName;
            mysqli_query(
                $conn,
                "
                INSERT INTO quotation_images(
                    quotation_id,
                    elevation_id,
                    image_type,
                    original_name,
                    stored_name,
                    image_path,
                    file_size,
                    mime_type,
                    image_width,
                    image_height
                )
                VALUES(
                    '$quotationId',
                    NULL,
                    'floorplan',
                    '$originalName',
                    '$storedName',
                    '$imagePath',
                    '$fileSize',
                    '$mimeType',
                    '$imageWidth',
                    '$imageHeight'
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
}
catch(Exception $e){
    mysqli_rollback($conn);
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}
?>