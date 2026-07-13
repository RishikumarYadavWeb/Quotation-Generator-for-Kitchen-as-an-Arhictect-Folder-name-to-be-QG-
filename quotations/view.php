<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    $id = (int)($_GET['id'] ?? 0);
    $quotationQuery = mysqli_query(
        $conn,
        "
        SELECT
            q.*,
            c.client_name,
            c.phone,
            c.email,
            c.gst_number,
            c.pan_number,
            c.address,
            c.shipping_address,
            e.entity_name,
            u.name AS created_by_name
        FROM quotations q
        LEFT JOIN clients c
        ON q.client_id = c.id
        LEFT JOIN entities e
        ON q.entity_id = e.id
        LEFT JOIN users u
        ON q.created_by = u.id
        WHERE q.id = '$id'
        LIMIT 1
        "
    );
    $quotation = mysqli_fetch_assoc( $quotationQuery );
    $grandTotal = (float)$quotation['grand_total'];
    $packingCharge = (float)$quotation['packing_charge'];
    $installationCharge = (float)$quotation['installation_charge'];
    $specialDiscount = (float)$quotation['special_discount'];
    $finalCustomerPrice = (float)$quotation['final_customer_price'];
    $standardAccessoriesQuery = mysqli_query(
        $conn,
        "
        SELECT
            qsa.*,
            sam.material_name,
            sam.unit,
            sac.category_name
        FROM quotation_standard_accessories qsa
        LEFT JOIN standard_accessory_materials sam
        ON sam.id = qsa.standard_accessory_id
        LEFT JOIN standard_accessory_categories sac
        ON sac.id = sam.category_id
        WHERE qsa.quotation_id = '$id'
        ORDER BY qsa.id ASC
        "
    );
    $projectImages = [];
    $imageQuery = mysqli_query(
        $conn,
        "
        SELECT *
        FROM quotation_images
        WHERE quotation_id = '$id'
        AND image_type IN ('render','floorplan')
        ORDER BY image_type,id
        "
    );
    while($row = mysqli_fetch_assoc($imageQuery)){$projectImages[$row['image_type']][] = $row;}
?>
<div class="container-fluid">
    <div class="top-header mb-0 d-flex justify-content-between">
        <div>
            <h2 class="page-title">Quotation Details </h2>
            <p class="page-subtitle"> Complete quotation breakdown</p>
        </div>
        <a href="manage.php" class="generate-btn" style="text-decoration:none; max-width:220px; display:flex; align-items:center; justify-content:center;">Back To Manage</a>
    </div>
    <div class="mb-4 ">
        <a href="../export-pdf.php?id=<?= $quotation['id'] ?>&details=yes" class="export-btn" target="_blank">Export Detailed PDF</a>
        <a href="../export-pdf.php?id=<?= $quotation['id'] ?>&details=no" class="export-btn" target="_blank">Export Simple PDF</a>
    </div>
    <div class="main-card">
        <div class="row">
            <div class="col-md-4">
                <label>Quotation Created By</label>
                <input type="text" class="modern-input" readonly value="<?= $quotation['created_by_name']; ?>" >
            </div>
        </div>
    </div>
    <div class="main-card">
        <div class="generated-title mb-4">Client Information</div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Client Name</label>
                <input type="text" class="modern-input" readonly value="<?= $quotation['client_name']; ?>" >
            </div>
            <div class="col-md-4 mb-3">
                <label>Phone</label>
                <input type="text" class="modern-input" readonly value="<?= $quotation['phone']; ?>" >
            </div>
            <div class="col-md-4 mb-3">
                <label>Email</label>
                <input type="text" class="modern-input" readonly value="<?= $quotation['email']; ?>" >
            </div>
            <div class="col-md-6 mb-3">
                <label>GST Number</label>
                <input type="text" class="modern-input" readonly value="<?= $quotation['gst_number']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label>PAN Number</label>
                <input type="text" class="modern-input" readonly value="<?= $quotation['pan_number']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label>Address</label>
                <textarea class="modern-input" readonly><?= $quotation['address']; ?></textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label>Shipping Address</label>
                <textarea class="modern-input" readonly><?= $quotation['shipping_address']; ?></textarea>
            </div>
        </div>
    </div>
    <div class="main-card mt-4">
        <div class="generated-title mb-4">Quotation Information</div>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label>Proforma No</label>
                <input type="text" class="modern-input" readonly value="<?= $quotation['proforma_no']; ?>" >
            </div>
            <div class="col-md-3 mb-3">
                <label>Entity</label>
                <input type="text" class="modern-input" readonly value="<?= $quotation['entity_name']; ?>" >
            </div>
            <div class="col-md-3 mb-3">
                <label>Project Type</label>
                <input type="text" class="modern-input" readonly value="<?= $quotation['project_type']; ?>" >
            </div>
            <div class="col-md-3 mb-3">
                <label>Total Carpentry Sqft</label>
                <input type="text" class="modern-input" readonly value="<?= $quotation['total_sqft']; ?>" >
            </div>
        </div>
    </div>
    <div class="main-card mt-4">
        <h3 class="mb-4 generated-title">Project Images</h3>
        <?php foreach(['render'=>'1] 3D Render Images','floorplan'=>'2] Floor Plan Images'] as $type=>$title){ ?>
            <?php if(!empty($projectImages[$type])){ ?>
                <h5 class="mt-4"><?= $title; ?></h5>
                <div class="row">
                    <?php foreach($projectImages[$type] as $image){ ?>
                        <div class="col-md-3 mb-3">
                            <div class="card p-2">
                                <img src="../uploads/<?= $image['image_path']; ?>" class="img-fluid rounded projectImage" style="height:180px;width:100%;object-fit:cover;cursor:pointer;" data-image="../uploads/<?= $image['image_path']; ?>">
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <?php
        $elevationsQuery =
        mysqli_query(
            $conn,
            "
            SELECT *
            FROM elevations
            WHERE quotation_id = '$id'
            ORDER BY elevation_no ASC
            "
        );
        while( $elevation = mysqli_fetch_assoc($elevationsQuery)
        ){
        $lineImagesQuery = mysqli_query(
            $conn,
            "
            SELECT *
            FROM elevation_line_images
            WHERE elevation_id = '".$elevation['id']."'
            "
        );
        $projectImagesQuery = mysqli_query(
            $conn,
            "
            SELECT *
            FROM quotation_images
            WHERE quotation_id = '$id'
            AND elevation_id = '".$elevation['id']."'
            AND image_type = 'elevation'
            ORDER BY id ASC
            "
        );
    ?>
        <div class="main-card mt-4">
           <div class="generated-title">
                <?php
                $alphabet = range('A','Z');
                $elevationLabel = $alphabet[$elevation['elevation_no'] - 1] ?? $elevation['elevation_no'];
                ?>
                Elevation <?= $elevationLabel; ?>
                <?php if(
                    !empty($elevation['show_note']) &&
                    !empty($elevation['elevation_note'])
                ){ ?>
                    <span style="margin-left:10px;font-size:18px;font-weight:500;color:#64748b;">
                        | <?= htmlspecialchars($elevation['elevation_note']) ?>
                    </span>
                <?php } ?>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label>Ceiling Height MM</label>
                    <input type="text" class="modern-input" value="<?= $elevation['ceiling_height_mm']; ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Ceiling Height FT</label>
                    <input type="text" class="modern-input" value="<?= $elevation['ceiling_height_ft']; ?>" readonly>
                </div>
            </div>
            <?php
                $unitsQuery = mysqli_query(
                    $conn,
                    "
                    SELECT
                        qu.*,
                        cc.category_name
                        AS carcass_category_name,
                        cm.material_name
                        AS carcass_material_name,
                        sc.category_name
                        AS shutter_category_name,
                        sm.material_type
                        AS shutter_material_name
                    FROM units qu
                    LEFT JOIN carcass_categories cc
                    ON qu.carcass_categories_id = cc.id
                    LEFT JOIN carcass_materials cm
                    ON qu.carcass_materials_id = cm.id
                    LEFT JOIN shutter_categories sc
                    ON qu.shutter_categories_id = sc.id
                    LEFT JOIN shutter_materials sm
                    ON qu.shutter_materials_id = sm.id
                    WHERE qu.elevation_id = '".$elevation['id']."'
                    ORDER BY
                    CASE qu.unit_type
                        WHEN 'Bottom' THEN 1
                        WHEN 'Upper' THEN 2
                        WHEN 'Tall' THEN 3
                        WHEN 'Loft' THEN 4
                        ELSE 5
                    END,
                    qu.id ASC
                    "
                );
            ?>
            <div class="table-responsive">
                <?php $tallCounter = 0;$upperCounter = 0;$bottomCounter = 0;$loftCounter = 0;?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Unit Type</th>
                            <th>Width (MM)</th>
                            <th>Height (MM)</th>
                            <th>Depth (MM)</th>
                            <th>Sqft</th>
                            <th>Carcass Category</th>
                            <th>Carcass Material</th>
                            <th>Carcass Total</th>
                            <th>Shutter Category</th>
                            <th>Shutter Material</th>
                            <th>Shutter Total</th>
                            <th>Unit Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $currentType = '';
                            $bottomCounter = 0;
                            $upperCounter = 0;
                            $tallCounter = 0;
                            $loftCounter = 0;
                            while($unit = mysqli_fetch_assoc($unitsQuery))
                            {
                                if($currentType != $unit['unit_type']){
                                    $currentType = $unit['unit_type'];
                        ?>
                        <tr>
                            <td colspan="13" style="background:#f5f5f5; font-weight:bold; text-align:left;"><?= strtoupper($currentType); ?> UNITS</td>
                        </tr>
                        <?php
                            }
                            switch($unit['unit_type']){
                                case 'Bottom':
                                    $bottomCounter++;
                                    $unitLabel = 'Base Unit '.$bottomCounter;
                                    break;
                                case 'Upper':
                                    $upperCounter++;
                                    $unitLabel = 'Upper Unit '.$upperCounter;
                                    break;
                                case 'Tall':
                                    $tallCounter++;
                                    $unitLabel = 'Tall Unit '.$tallCounter;
                                    break;
                                case 'Loft':
                                    $loftCounter++;
                                    $unitLabel = 'Loft Unit '.$loftCounter;
                                    break;
                                default:
                                    $unitLabel = $unit['unit_type'];
                            }
                        ?>
                        <tr>
                            <td><?= $unitLabel; ?></td>
                            <td><?= $unit['width_mm']; ?></td>
                            <td><?= $unit['height_mm']; ?></td>
                            <td><?= $unit['depth_mm']; ?></td>
                            <td><?= $unit['sqft']; ?></td>
                            <td><?= $unit['carcass_category_name']; ?></td>
                            <td><?= $unit['carcass_material_name']; ?></td>
                            <td>₹ <?= number_format($unit['carcass_total'],2); ?></td>
                            <td><?= $unit['shutter_category_name']; ?></td>
                            <td><?= $unit['shutter_material_name']; ?></td>
                            <td>₹ <?= number_format($unit['shutter_total'],2); ?></td>
                            <td colspan="2">₹ <?= number_format($unit['unit_total'],2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="13">
                            <?php
                                $drawerQuery = mysqli_query(
                                    $conn,
                                    "
                                    SELECT
                                        dd.*,
                                        dc.category_name,
                                        dm.material_name
                                    FROM drawers_data dd
                                    LEFT JOIN drawer_categories dc
                                    ON dd.drawer_categories_id = dc.id
                                    LEFT JOIN drawer_materials dm
                                    ON dd.drawer_materials_id = dm.id
                                    WHERE dd.assigned_unit_id = '".$unit['unit_key']."'
                                    AND dd.quotation_id = '".$quotation['id']."'
                                    "
                                );
                                $drawerCount = 1;
                                if(mysqli_num_rows($drawerQuery) > 0){
                                    echo '<strong>Drawer Details</strong><br>';
                                    while($drawer = mysqli_fetch_assoc($drawerQuery)){
                                        echo '
                                        '.explode('_',$drawer['assigned_unit_id'])[1] . ' Unit ' . explode('_',$drawer['assigned_unit_id'])[2].'
                                        | Qty : '.$drawer['quantity'].' <br>
                                        Category : '.$drawer['category_name'].' | 
                                        Material : '.$drawer['material_name'].'<br>
                                        Size : '.$drawer['width_mm'].' × '.$drawer['height_mm'].' mm<br>
                                        Price: '.$drawer['total'].'<br><br>
                                        ';
                                    }
                                }
                            ?>
                            <?php
                                $shelfQuery = mysqli_query(
                                    $conn,
                                    "
                                    SELECT
                                        sd.*,
                                        sc.category_name,
                                        sm.material_name
                                    FROM shelves_data sd
                                    LEFT JOIN shelf_categories sc
                                    ON sd.shelf_categories_id = sc.id
                                    LEFT JOIN shelf_materials sm
                                    ON sd.shelf_materials_id = sm.id
                                    WHERE sd.assigned_unit_id = '".$unit['unit_key']."'
                                    AND sd.quotation_id = '".$quotation['id']."'
                                    "
                                );
                                $shelfCount = 1;
                                if(mysqli_num_rows($shelfQuery) > 0){
                                    echo '<strong>Shelf Details</strong><br>';
                                    while($shelf = mysqli_fetch_assoc($shelfQuery)){
                                        echo '
                                        '.explode('_',$shelf['assigned_unit_id'])[1] . ' Unit ' . explode('_',$shelf['assigned_unit_id'])[2].'
                                        | Qty : '.$shelf['quantity'].' <br>
                                        Category : '.$shelf['category_name'].' | 
                                        Material : '.$shelf['material_name'].'<br>
                                        Size : '.$shelf['width_mm'].' × '.$shelf['height_mm'].' mm<br>
                                        Price: '.$shelf['total'].'<br><br>
                                        ';
                                    }
                                }
                            ?>     
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if(mysqli_num_rows($lineImagesQuery) > 0): ?>
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Drawings & Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php while($image = mysqli_fetch_assoc($lineImagesQuery)): ?>
                                <div class="col-md-3 mb-3">
                                    <a href="../uploads/line-images/<?php echo $image['image_path']; ?>" target="_blank">
                                        <img src="../uploads/line-images/<?php echo $image['image_path']; ?>" class="img-fluid rounded border shadow-sm" style="width:100%;height:220px;object-fit:cover;">
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(mysqli_num_rows($projectImagesQuery)>0){ ?>
                <div class="mt-4">
                    <h5 class="mb-3">Elevation Images</h5>
                    <div class="row">
                        <?php while($image=mysqli_fetch_assoc($projectImagesQuery)){?>
                            <div class="col-md-3 mb-3">
                                <div class="card p-2">
                                    <img src="../uploads/<?= $image['image_path']; ?>" class="img-fluid rounded projectImage" style="height:180px;width:100%;object-fit:cover;cursor:pointer;" data-image="../uploads/<?= $image['image_path']; ?>">
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <?php
    $visiblePanelQuery = mysqli_query(
        $conn,
        "
        SELECT
            qvp.*,
            vpc.category_name,
            vpm.material_name
        FROM quotation_visible_panels qvp
        LEFT JOIN visible_panel_categories vpc ON vpc.id = qvp.category_id
        LEFT JOIN visible_panel_materials vpm ON vpm.id = qvp.material_id
        WHERE qvp.quotation_id = '$id'
        ORDER BY qvp.id ASC
        "
    );
    if(mysqli_num_rows($visiblePanelQuery) > 0){
    ?>
    <div class="main-card mt-4">
        <div class="generated-title">Visible Panels</div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Width (MM)</th>
                    <th>Height (MM)</th>
                    <th>Sq Ft</th>
                    <th>Category</th>
                    <th>Material</th>
                    <th>Panel Price</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $srNo = 1;
            $panelGrandTotal = 0;
            while($panel = mysqli_fetch_assoc($visiblePanelQuery)){$panelGrandTotal += $panel['panel_price'];
            ?>
                <tr>
                    <td><?= $srNo++ ?></td>
                    <td><?= number_format($panel['width_mm'],2) ?></td>
                    <td><?= number_format($panel['height_mm'],2) ?></td>
                    <td><?= number_format($panel['sqft'],2) ?></td>
                    <td><?= htmlspecialchars($panel['category_name']) ?></td>
                    <td><?= htmlspecialchars($panel['material_name']) ?></td>
                    <td>₹ <?= number_format($panel['panel_price'],2) ?></td>
                </tr>
            <?php } ?>
                <tr>
                    <th colspan="6" style="text-align:center;">Visible Panels Total</th>
                    <th>₹ <?= number_format($panelGrandTotal,2) ?></th>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } ?>
    <?php
    $visibleSidePanelQuery = mysqli_query(
        $conn,
        "
        SELECT
            qvsp.*,
            vsc.category_name,
            vsm.material_name
        FROM quotation_visible_side_panels qvsp
        LEFT JOIN visible_side_categories vsc ON vsc.id = qvsp.category_id
        LEFT JOIN visible_side_materials vsm ON vsm.id = qvsp.material_id
        WHERE qvsp.quotation_id = '$id'
        ORDER BY qvsp.id ASC
        "
    );
    if(mysqli_num_rows($visibleSidePanelQuery) > 0){
    ?>
    <div class="main-card mt-4">
        <div class="generated-title">Visible Side Panels</div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Width (MM)</th>
                    <th>Height (MM)</th>
                    <th>Sq Ft</th>
                    <th>Category</th>
                    <th>Material</th>
                    <th>Panel Price</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $srNo = 1;
            $sidePanelGrandTotal = 0;
            while($panel = mysqli_fetch_assoc($visibleSidePanelQuery)){$sidePanelGrandTotal += $panel['panel_price'];
            ?>
                <tr>
                    <td><?= $srNo++ ?></td>
                    <td><?= number_format($panel['width_mm'],2) ?></td>
                    <td><?= number_format($panel['height_mm'],2) ?></td>
                    <td><?= number_format($panel['sqft'],2) ?></td>
                    <td><?= htmlspecialchars($panel['category_name']) ?></td>
                    <td><?= htmlspecialchars($panel['material_name']) ?></td>
                    <td>₹ <?= number_format($panel['panel_price'],2) ?></td>
                </tr>
            <?php } ?>
                <tr>
                    <th colspan="6" style="text-align:center;">Visible Side Panels Total</th>
                    <th>₹ <?= number_format($sidePanelGrandTotal,2) ?></th>
                </tr>
            </tbody>
        </table>
    </div>
    <?php } ?>
    <?php if(mysqli_num_rows($standardAccessoriesQuery) > 0){ ?>
    <div class="main-card" style="margin-top:30px;">
        <div class="page-header mb-3">
            <div>
                <h2 class="generated-title">Standard Accessories</h2>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr No.</th>
                    <th>Category</th>
                    <th>Material</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $srNo = 1;
                    $grandTotal = 0;
                    while(
                        $row = mysqli_fetch_assoc($standardAccessoriesQuery)
                    ){
                        $grandTotal += $row['total_price'];
                ?>
                    <tr>
                        <td><?= $srNo++ ?></td>
                        <td><?= htmlspecialchars($row['category_name']) ?></td>
                        <td><?= htmlspecialchars($row['material_name']) ?></td>
                        <td><?= htmlspecialchars($row['unit']) ?></td>
                        <td>₹ <?= number_format($row['unit_price'],2) ?></td>
                        <td><?= $row['qty'] ?></td>
                        <td>₹ <?= number_format($row['total_price'],2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" style="text-align:center;">Grand Total</th>
                    <th>₹ <?= number_format($grandTotal,2) ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php } ?>
    <?php
$accessoryQuery = mysqli_query(
    $conn,
    "
    SELECT
        qa.*,
        a.material_name,
        c.category_name,
        m.make_name
    FROM quotation_accessories qa

    LEFT JOIN accessories a
        ON qa.accessory_id = a.id

    LEFT JOIN accessory_categories c
        ON qa.category_id = c.id

    LEFT JOIN accessory_makes m
        ON qa.make_id = m.id

    WHERE qa.quotation_id = '$id'
    "
);

if (mysqli_num_rows($accessoryQuery) > 0) {
?>

<div class="main-card mt-4">

    <div class="generated-title">
        Additional Accessories
    </div>

    <table class="table table-bordered">

        <thead>

            <tr>

                <th>Sr No.</th>
                <th>Category</th>
                <th>Make</th>
                <th>Accessory</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>

            </tr>

        </thead>

        <tbody>

            <?php

            $srNo = 1;
            $accessoryGrandTotal = 0;

            while ($accessory = mysqli_fetch_assoc($accessoryQuery)) {

                $accessoryGrandTotal += $accessory['total'];

            ?>

            <tr>

                <td><?= $srNo++ ?></td>

                <td>
                    <?= htmlspecialchars($accessory['category_name']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($accessory['make_name']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($accessory['material_name']) ?>
                </td>

                <td>
                    ₹ <?= number_format($accessory['price'], 2) ?>
                </td>

                <td>
                    <?= $accessory['qty'] ?>
                </td>

                <td>
                    ₹ <?= number_format($accessory['total'], 2) ?>
                </td>

            </tr>

            <?php } ?>

            <tr>

                <th colspan="6" style="text-align:center;">
                    Accessories Total
                </th>

                <th>
                    ₹ <?= number_format($accessoryGrandTotal, 2) ?>
                </th>

            </tr>

        </tbody>

    </table>

</div>

<?php } ?>
    <div class="main-card mt-4">
        <div class="generated-title">Commercial Summary</div>
        <div class="">
            <table class="-custom-table table-bordered">
                <tbody>
                    <tr>
                        <th>Packing Charge</th>
                        <td>₹ <?= number_format($quotation['packing_charge'],2); ?></td>
                    </tr>
                    <tr>
                        <th>Installation Charge</th>
                        <td> ₹ <?= number_format($quotation['installation_charge'],2); ?></td>
                    </tr>
                    <tr>
                        <th width="70%">Grand Total </th>
                        <td> ₹ <?= number_format($quotation['grand_total'],2); ?> </td>
                    </tr>
                    <tr>
                        <th>Special Discount</th>
                        <td><?= number_format($quotation['special_discount']); ?> %</td>
                    </tr>
                    <tr style=" font-weight:bold; background:#f8f9fa;">
                        <th>Final Customer Price</th>
                        <td>₹ <?= number_format($quotation['final_customer_price'],2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../includes/footer.php' ?>