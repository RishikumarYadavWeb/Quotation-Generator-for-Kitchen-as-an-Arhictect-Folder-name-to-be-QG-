<?php
    include '../db.php';
    /** @var mysqli $conn */
    $id = (int)($_GET['id'] ?? 0);
    if(!$id){
        die('Invalid Quotation ID');
    }
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
    $clientId = $quotation['client_id'] ?? 0;
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
        if($clientData['total'] == 0){
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