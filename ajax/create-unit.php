<?php
    if(
        !isset($_POST['type']) ||
        empty($_POST['type'])
    ){
        exit;
    }
    $type = trim($_POST['type']);
    $units = [
        'Tall'   => '../components/tall-master.php',
        'Upper'  => '../components/upper-master.php',
        'Bottom' => '../components/bottom-master.php',
        'Loft'   => '../components/loft-master.php'
    ];
    if(isset($units[$type])){include $units[$type];}
?>