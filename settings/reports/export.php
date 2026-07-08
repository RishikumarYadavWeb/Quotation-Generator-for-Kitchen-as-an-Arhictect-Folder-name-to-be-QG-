<?php

include '../../includes/auth.php';
include '../../db.php';

if(!can('settings_view')){
    die("Access Denied");
}

$module=$_GET['module'] ?? '';
$format=$_GET['format'] ?? 'csv';

$allowedModules=[

    'users',
    'clients',
    'quotations',
    'materials'

];

if(!in_array($module,$allowedModules)){

    die("Invalid Module");

}

$filename=$module."_".date("Ymd_His");

switch($module){

    /* ==========================================================
       USERS
    ========================================================== */

    case "users":

        $sql="

        SELECT

            u.id,
            u.name,
            u.email,
            r.role_name,
            e.entity_name,
            u.status,
            u.created_at

        FROM users u

        LEFT JOIN roles r
        ON r.id=u.role_id

        LEFT JOIN entities e
        ON e.id=u.entity_id

        ORDER BY u.name

        ";

    break;

    /* ==========================================================
       CLIENTS
    ========================================================== */

    case "clients":

        $sql="

        SELECT

            client_name,
            phone,
            email,
            gst_number,
            pan_number,
            created_at

        FROM clients

        ORDER BY client_name

        ";

    break;

    /* ==========================================================
       QUOTATIONS
    ========================================================== */

    case "quotations":

        $sql="

        SELECT

            proforma_no,
            project_type,
            total_sqft,
            grand_total,
            special_discount,
            final_customer_price,
            created_at

        FROM quotations

        ORDER BY created_at DESC

        ";

    break;

    /* ==========================================================
       MATERIALS
    ========================================================== */

    case "materials":

        $sql="

        SELECT

            material_name,
            price_per_sqft,
            status

        FROM shutter_materials

        ";

    break;

}

$result=mysqli_query($conn,$sql);
/* ==========================================================
   CSV EXPORT
========================================================== */

if($format=="csv"){

    header("Content-Type:text/csv");
    header("Content-Disposition:attachment; filename=".$filename.".csv");

    $output=fopen("php://output","w");

    $first=mysqli_fetch_assoc($result);

    if($first){

        fputcsv(
            $output,
            array_keys($first)
        );

        fputcsv(
            $output,
            $first
        );

        while($row=mysqli_fetch_assoc($result)){

            fputcsv(
                $output,
                $row
            );

        }

    }

    fclose($output);

    exit;

}

/* ==========================================================
   EXCEL EXPORT
========================================================== */

if($format=="excel"){

    require '../../vendor/autoload.php';

    $spreadsheet=new \PhpOffice\PhpSpreadsheet\Spreadsheet();

    $sheet=$spreadsheet->getActiveSheet();

    $rowNumber=1;

    $first=mysqli_fetch_assoc($result);

    if($first){

        $column='A';

        foreach(array_keys($first) as $heading){

            $sheet->setCellValue(
                $column.$rowNumber,
                $heading
            );

            $column++;

        }

        $rowNumber++;

        $column='A';

        foreach($first as $value){

            $sheet->setCellValue(
                $column.$rowNumber,
                $value
            );

            $column++;

        }

        $rowNumber++;

        while($row=mysqli_fetch_assoc($result)){

            $column='A';

            foreach($row as $value){

                $sheet->setCellValue(
                    $column.$rowNumber,
                    $value
                );

                $column++;

            }

            $rowNumber++;

        }

    }

    header("Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");

    header("Content-Disposition:attachment; filename=".$filename.".xlsx");

    $writer=new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    $writer->save("php://output");

    exit;

}
/* ==========================================================
   PDF EXPORT
========================================================== */
/* ==========================================================
   PDF EXPORT
========================================================== */

if($format=="pdf"){

    require '../../vendor/autoload.php';

    $options=new \Dompdf\Options();

    $options->set('isRemoteEnabled',true);

    $dompdf=new \Dompdf\Dompdf($options);

    $html='

    <style>

        body{
            font-family:DejaVu Sans,sans-serif;
            font-size:11px;
        }

        h2{
            margin-bottom:15px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#f3f3f3;
            font-weight:bold;
        }

        th,td{
            border:1px solid #000;
            padding:6px;
        }

    </style>

    ';

    $html.='<h2>'.ucwords($module).' Report</h2>';

    $html.='<table>';

    $first=mysqli_fetch_assoc($result);

    if($first){

        $html.='<thead><tr>';

        foreach(array_keys($first) as $heading){

            $html.='<th>'.htmlspecialchars($heading).'</th>';

        }

        $html.='</tr></thead><tbody>';

        $html.='<tr>';

        foreach($first as $value){

            $html.='<td>'.htmlspecialchars((string)$value).'</td>';

        }

        $html.='</tr>';

        while($row=mysqli_fetch_assoc($result)){

            $html.='<tr>';

            foreach($row as $value){

                $html.='<td>'.htmlspecialchars((string)$value).'</td>';

            }

            $html.='</tr>';

        }

        $html.='</tbody>';

    }else{

        $html.='<tr><td>No Records Found</td></tr>';

    }

    $html.='</table>';

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4','landscape');

    $dompdf->render();

    $dompdf->stream(
        $filename.".pdf",
        [
            "Attachment"=>true
        ]
    );

    exit;

}

die("Invalid Export Format");
?>