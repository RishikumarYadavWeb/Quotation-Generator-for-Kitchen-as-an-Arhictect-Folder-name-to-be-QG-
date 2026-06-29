<?php
    include('../db.php');
    /** @var mysqli $conn */
    header('Content-Type: application/json');
    if(
        !isset($_POST['client_id']) ||
        empty($_POST['client_id'])
    ){
        echo json_encode(['status'  => false,'message' => 'Client ID Missing']);
        exit;
    }
    $client_id = (int) $_POST['client_id'];
    $query = mysqli_query(
        $conn,
        "
        SELECT
            id,
            client_name,
            phone,
            email,
            gst_number,
            pan_number,
            address,
            shipping_address
        FROM clients
        WHERE id = '$client_id'
        LIMIT 1
        "
    );
    if(!$query){
        echo json_encode(['status'  => false,'message' => 'Database Error']);
        exit;
    }
    $data = mysqli_fetch_assoc($query);
    if(!$data){
        echo json_encode(['status'  => false,'message' => 'Client Not Found']);
        exit;
    }
    echo json_encode(['status' => true,'data'   => $data]);
?>