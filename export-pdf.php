<?php
    use Dompdf\Dompdf;
    use Dompdf\Options;
    require 'vendor/autoload.php';
    include 'db.php';
    /** @var mysqli $conn */
    $id = (int) ($_GET['id'] ?? 0);
    $show_details = in_array(
    $_GET['details'] ?? '',
    ['yes', 'no'],
    true
    )
    ? $_GET['details']
    : 'yes';
    if($id <= 0){
        die('Invalid Quotation ID');
    }
    $companyQuery = mysqli_query(
        $conn,
        "
        SELECT
            company_name,
            landline_number,
            email,
            registered_address,
            gst_number,
            cin_number,
            gst_number
        FROM company
        LIMIT 1
        "
    );
    
    $company = mysqli_fetch_assoc($companyQuery);
    $query = mysqli_query(
        $conn,
        "
        SELECT
            quotations.id,
            quotations.proforma_no,
            quotations.project_type,
            quotations.total_sqft,
            quotations.grand_total,
            quotations.packing_charge,
            quotations.installation_charge,
            quotations.special_discount,
            quotations.final_customer_price,
            quotations.updated_at,
            quotations.created_at,
            clients.client_name,
            clients.phone,
            clients.email,
            clients.gst_number,
            clients.pan_number,
            clients.address,
            clients.shipping_address,
            users.name AS created_user_name
        FROM quotations
        LEFT JOIN clients
        ON quotations.client_id = clients.id
        LEFT JOIN users
        ON quotations.created_by = users.id
        WHERE quotations.id = '$id'
        LIMIT 1
        "
    );
    $quotation = mysqli_fetch_assoc($query);
    if(!$quotation){
        die('Quotation Not Found');
    }
    $elevationQuery = mysqli_query(
        $conn,
        "
        SELECT
            id,
            elevation_no,
            ceiling_height_mm,
            ceiling_height_ft,
            elevation_note
        FROM elevations
        WHERE quotation_id = '$id'
        ORDER BY id ASC
        "
    );
    
    $elevations = [];
    while($row = mysqli_fetch_assoc($elevationQuery)){
        $elevations[] = $row;
    }
    $accessoriesQuery = mysqli_query(
        $conn,
        "
        SELECT
            qa.qty,
            qa.price,
            qa.total,
            a.accessory_name
        FROM quotation_accessories qa
        LEFT JOIN accessories a
        ON qa.accessory_id = a.id
        WHERE qa.quotation_id = '$id'
        "
    );
    $accessories = [];
    $accessoriesTotal = 0;
    while($row = mysqli_fetch_assoc($accessoriesQuery)){
        $accessories[] = $row;
        $accessoriesTotal += (float) $row['total'];
    }
    $panelQuery = mysqli_query(
        $conn,
        "
        SELECT
            qp.*,
            sc.category_name,
            sm.material_type
        FROM quotation_panels qp
        LEFT JOIN shutter_categories sc
        ON qp.shutter_category_id = sc.id
        LEFT JOIN shutter_materials sm
        ON qp.shutter_material_id = sm.id
        WHERE qp.quotation_id = '$id'
        "
    );
    $panels = [];
    $panelsTotal = 0;
    while($row = mysqli_fetch_assoc($panelQuery)){
        $panels[] = $row;
        $panelsTotal += (float)$row['panel_price'];
    }
    $standardAccessoriesQuery = mysqli_query(
        $conn,
        "
        SELECT
            qsa.qty,
            qsa.unit_price,
            qsa.total_price,
            sam.material_name,
            sam.unit,
            sac.category_name
        FROM quotation_standard_accessories qsa
        LEFT JOIN standard_accessory_materials sam
        ON qsa.standard_accessory_id = sam.id
        LEFT JOIN standard_accessory_categories sac
        ON sam.category_id = sac.id
        WHERE qsa.quotation_id = '$id'
        ORDER BY qsa.id ASC
        "
    );
    $standardAccessories = [];
    $standardAccessoriesTotal = 0;
    while(
        $row = mysqli_fetch_assoc($standardAccessoriesQuery)
    ){
        $standardAccessories[] = $row;
        $standardAccessoriesTotal += (float)$row['total_price'];
    }
    ob_start();
    include 'invoice-template.php';
    $html = ob_get_clean();
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set(
        'fontDir',
        realpath(__DIR__ . 'assets/fonts')
    );
    $options->set(
        'fontCache',
        realpath(__DIR__ . 'assets/fonts')
    );
    $options->set([
        'isRemoteEnabled'      => true,
        'isHtml5ParserEnabled' => true,
        'dpi'                  => 96,
        'defaultFont'          => 'Ginseng'
    ]);
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper(
        'A4',
        'portrait'
    );
    $dompdf->render();
    // $canvas = $dompdf->getCanvas();
    // $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($quotation) {
    //     $canvas->line(20,820,575,820,array(0,0,0),1);
    //     $canvas->text(25,825,"Date: ".date('d-m-Y', strtotime($quotation['updated_at'])),null,8);
    //     $canvas->text(220,825,"Proforma No: ".$quotation['proforma_no'],null,8);
    //     $canvas->text(500,825,"Page ".$pageNumber." of ".$pageCount,null,8);
    // });

    // A3 
    $a4Pdf = $dompdf->output();
    $tempDir = __DIR__ . '/temp/';
    if (!is_dir($tempDir)) {
        mkdir($tempDir, 0777, true);
    }
    $a4Temp = $tempDir . 'quotation_' . time() . '.pdf';
    file_put_contents($a4Temp,$a4Pdf);
    use setasign\Fpdi\Tcpdf\Fpdi;
    $pdf = new Fpdi('P','mm','A4',true,'UTF-8',false);
    $pdf->SetAutoPageBreak(false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    // ======================================================
    // IMPORT A4 QUOTATION PAGES
    // ======================================================
    $pageCount = $pdf->setSourceFile($a4Temp);

    for ($i = 1; $i <= $pageCount; $i++) {

        $tpl = $pdf->importPage($i);

        $size = $pdf->getTemplateSize($tpl);

        $pdf->AddPage(
            $size['orientation'],
            [$size['width'], $size['height']]
        );

        $pdf->useTemplate($tpl);

        // ADD COMMON FOOTER HERE

        $pageWidth  = $pdf->getPageWidth();
        $pageHeight = $pdf->getPageHeight();

        $pdf->Line(
            8,
            $pageHeight - 8,
            $pageWidth - 8,
            $pageHeight - 8
        );

        $pdf->SetFont('dejavusans', '', 8);

        $pdf->Text(
            10,
            $pageHeight - 7,
            'Date: ' . date(
                'd-m-Y',
                strtotime(!empty($quotation['updated_at']) ? $quotation['updated_at'] : $quotation['created_at'])
            )
        );

        $pdf->Text(
            ($pageWidth / 2) - 30,
            $pageHeight - 7,
            'Proforma No: ' . $quotation['proforma_no']
        );

        $pdf->Text(
            $pageWidth - 45,
            $pageHeight - 7,
            'Page ' .
            $pdf->getAliasNumPage() .
            ' of ' .
            $pdf->getAliasNbPages()
        );
    }
    // DELETE TEMP FILE IMMEDIATELY
    if (file_exists($a4Temp)) {
        unlink($a4Temp);
    }
    $alphabet = range('A', 'Z');
    $elevationIndex = 0;
    foreach ($elevations as $elevation) {
        $elevationLetter = $alphabet[$elevationIndex] ?? ($elevationIndex + 1);
        $imageQuery = mysqli_query(
            $conn,
            "
            SELECT *
            FROM elevation_line_images
            WHERE elevation_id = '".$elevation['id']."'
            "
        );
        while ($image = mysqli_fetch_assoc($imageQuery)) {
            $imagePath = realpath(
                __DIR__ .
                '/uploads/line-images/' .
                $image['image_path']
            );
            if (
                !$imagePath ||
                !file_exists($imagePath)
            ) {
                continue;
            }
            // =====================================
            // NEW A3 PAGE
            // =====================================
            $pdf->AddPage('L','A3');
            // =====================================
            // IMAGE
            // =====================================
            list($imgWidth,$imgHeight) = getimagesize($imagePath);
            $maxWidth  = 380;
            $maxHeight = 220;
            $ratio = min(
                $maxWidth / $imgWidth,
                $maxHeight / $imgHeight
            );
            $newWidth  = $imgWidth * $ratio;
            $newHeight = $imgHeight * $ratio;
            $x = (420 - $newWidth) / 2;
            $padding = 10; // 10 mm gap
            $pdf->SetDrawColor(0, 0, 0); // Border color
            $pdf->SetLineWidth(0.5);     // Border thickness
            $pdf->Rect($x - $padding,35 - $padding,$newWidth + ($padding * 2),$newHeight + ($padding * 2));
            $pdf->Image($imagePath,$x,35,$newWidth,$newHeight);
            // =====================================
            // WATERMARK
            // =====================================
            $pdf->SetAlpha(0.2);
            $pdf->StartTransform();
            $pdf->Rotate(33,150,240);
            $pdf->SetFont('times','B',75);
            $pdf->SetTextColor(102,102,102);
            $pdf->Text(30,180,'F&R Kitchen And Wardrobes Pvt Ltd');
            $pdf->StopTransform();
            $pdf->SetAlpha(1);
            $pdf->SetTextColor(0,0,0);
            // =====================================
            // TITLE
            // =====================================
            $pdf->SetFont('times','B',22);
            $pdf->SetXY(0,10);
            $pdf->Cell(0,10,'Elevation '.$elevationLetter,0,1,'C');
            // =====================================
            // FOOTER
            // =====================================
            $pageWidth  = $pdf->getPageWidth();
            $pageHeight = $pdf->getPageHeight();
            $pdf->Line(10,$pageHeight - 10,$pageWidth - 10,$pageHeight - 10);
            $pdf->SetFont('times','',12);
            // DATE
            $pdf->Text(
                10,
                $pageHeight - 7,
                'Date: '.date(
                    'd-m-Y',
                    strtotime(!empty($quotation['updated_at']) ? $quotation['updated_at'] : $quotation['created_at'])
                )
            );
            // PROFORMA
            $pdf->Text(
                ($pageWidth / 2) - 30,
                $pageHeight - 7,
                'Proforma No: '.
                $quotation['proforma_no']
            );
            // PAGE NUMBER
            $pdf->Text(
                $pageWidth - 45,
                $pageHeight - 7,
                'Page ' .
                $pdf->getAliasNumPage() .
                ' of ' .
                $pdf->getAliasNbPages()
            );
        }
        $elevationIndex++;
    }
    if (ob_get_length()) {
    die(
        'Unexpected output: ' .
        ob_get_contents()
    );
}
    $pdf->Output('invoice.pdf','I');
    exit;
