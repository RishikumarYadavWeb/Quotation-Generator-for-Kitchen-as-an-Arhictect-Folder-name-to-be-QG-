<?php
    include '../db.php';
    /** @var mysqli $conn */
    $id = (int) ($_GET['id'] ?? 0);
    $quotationQuery = mysqli_query(
        $conn,
        "
        SELECT
            id,
            client_id,
            quotation_no,
            grand_total,
            final_customer_price,
            created_at
        FROM quotations
        WHERE id = '$id'
        LIMIT 1
        "
    );
    $quotation = mysqli_fetch_assoc($quotationQuery);
    if(!$quotation){
        echo json_encode([]);
        exit;
    }
    $elevationQuery = mysqli_query(
        $conn,
        "
        SELECT
            id,
            quotation_id,
            elevation_no,
            ceiling_height_mm,
            ceiling_height_ft
        FROM elevations
        WHERE quotation_id = '$id'
        ORDER BY id ASC
        "
    );
    $quotation['elevations'] = [];
    while($elevation = mysqli_fetch_assoc($elevationQuery)){
        $elevationId = (int) $elevation['id'];
        $unitQuery = mysqli_query(
            $conn,
            "
            SELECT
                id,
                elevation_id,
                unit_type,
                width_mm,
                width_ft,
                height_mm,
                height_ft,
                depth_mm,
                sqft,
                unit_total
            FROM units
            WHERE elevation_id = '$elevationId'
            ORDER BY id ASC
            "
        );
        $elevation['units'] = [];
        while($unit = mysqli_fetch_assoc($unitQuery)){
            $unitId = (int) $unit['id'];
            $drawerQuery = mysqli_query(
                $conn,
                "
                SELECT
                    id,
                    unit_id,
                    drawer_categories_id,
                    drawer_materials_id,
                    width_mm,
                    width_ft,
                    height_mm,
                    height_ft,
                    price,
                    total
                FROM drawers_data
                WHERE unit_id = '$unitId'
                ORDER BY id ASC
                "
            );
            $unit['drawers'] = [];
            while($drawer = mysqli_fetch_assoc($drawerQuery)){
                $unit['drawers'][] = $drawer;
            }
            $shelfQuery = mysqli_query(
                $conn,
                "
                SELECT
                    id,
                    unit_id,
                    shelf_categories_id,
                    shelf_materials_id,
                    width_mm,
                    width_ft,
                    height_mm,
                    height_ft,
                    sqft,
                    price,
                    total
                FROM shelves_data
                WHERE unit_id = '$unitId'
                ORDER BY id ASC
                "
            );
            $unit['shelves'] = [];
            while($shelf = mysqli_fetch_assoc($shelfQuery)){
                $unit['shelves'][] = $shelf;
            }
            $elevation['units'][] = $unit;
        }
        $quotation['elevations'][] = $elevation;
    }
    header('Content-Type: application/json');
    echo json_encode($quotation);
?>