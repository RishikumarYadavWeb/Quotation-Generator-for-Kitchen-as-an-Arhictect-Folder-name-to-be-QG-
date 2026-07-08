<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    $created_by = $_SESSION['user_id'];
    $quotation_id = intval($_GET['id']);
    $sql = "SELECT * FROM quotations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $quotation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $quotation = $result->fetch_assoc();
    if (!$quotation) {die("Quotation not found.");}
    // CLIENT
    $client_id = $quotation['client_id'];
    $client_sql = "SELECT * FROM clients WHERE id = ?";
    $client_stmt = $conn->prepare($client_sql);
    $client_stmt->bind_param("i", $client_id);
    $client_stmt->execute();
    $client_result = $client_stmt->get_result();
    $client = $client_result->fetch_assoc();
    $elevations = [];
    $elevation_sql = "
        SELECT *
        FROM elevations
        WHERE quotation_id = ?
        ORDER BY id ASC
    ";
    // ELEVATION
    $stmt = $conn->prepare($elevation_sql);
    $stmt->bind_param("i", $quotation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {$elevations[] = $row;}
    $units = [];
    $unit_sql = "
        SELECT u.*
        FROM units u
        INNER JOIN elevations e
            ON u.elevation_id = e.id
        WHERE e.quotation_id = ?
        ORDER BY u.elevation_id, u.id
    ";
    $stmt = $conn->prepare($unit_sql);
    $stmt->bind_param("i", $quotation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {$units[$row['elevation_id']][] = $row;}
    // DRAWERS
    $quotationDrawers = [];
    $drawerQuery = mysqli_query(
        $conn,
        "SELECT * FROM drawers_data
        WHERE quotation_id = '$quotation_id'"
    );
    $EDIT_DRAWERS = [];
    while($row = mysqli_fetch_assoc($drawerQuery)){$EDIT_DRAWERS[] = $row;}
    // SHELVES
    $shelves_data = [];
    $shelfQuery = mysqli_query(
        $conn,
        "SELECT * FROM shelves_data
        WHERE quotation_id = '$quotation_id'"
    );
    $EDIT_SHELVES = [];
    while($row = mysqli_fetch_assoc($shelfQuery)){$EDIT_SHELVES[] = $row;}
    // ACCESSORIES
    $accessories = [];
    $sql = "
    SELECT
        qa.*,
        a.category_id
    FROM quotation_accessories qa
    LEFT JOIN accessories a
    ON qa.accessory_id = a.id
    WHERE qa.quotation_id = '$quotation_id'
    ";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){$accessories[] = $row;}
    $accessoryCategoryOptions = '';
    $categoryQuery = mysqli_query(
        $conn,
        "
        SELECT *
        FROM accessory_categories
        WHERE status = 1
        ORDER BY category_name ASC
        "
    );
    while($category = mysqli_fetch_assoc($categoryQuery)){
    $accessoryCategoryOptions .= '<option value="'.$category['id'].'">'. htmlspecialchars($category['category_name']). '</option>';}
    $accessoryCategoryOptions .= '<option value="other">Other</option>';
    // IMAGE
    $elevationImages = [];
    $sql = "
        SELECT
            e.quotation_id,
            i.elevation_id,
            i.image_path
        FROM elevation_line_images i
        INNER JOIN elevations e
            ON i.elevation_id = e.id
        WHERE e.quotation_id = '$quotation_id'
    ";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){$elevationImages[$row['elevation_id']][] = $row['image_path'];}
    $projectImages = ['render' => [],'floorplan' => [],'elevations' => []];
    $result = mysqli_query(
        $conn,
        "
        SELECT *
        FROM quotation_images
        WHERE quotation_id = '$quotation_id'
        ORDER BY id ASC
        "
    );
    while($row = mysqli_fetch_assoc($result)){
        switch($row['image_type']){
            case 'render':
                $projectImages['render'][] = $row;
            break;
            case 'floorplan':
                $projectImages['floorplan'][] = $row;
            break;
            case 'elevation':
                $projectImages['elevations'][$row['elevation_id']][] = $row;
            break;
        }
    }
    include '../includes/header.php';
    include '../includes/sidebar.php';
    /* CARCASS MATERIALS */
    $carcassMaterials = [];
    $carcassQuery = "
            SELECT
                id,
                category_id,
                material_name,
                price_per_sqft
            FROM carcass_materials
            WHERE status='1'
            ORDER BY material_name ASC
        ";
    $carcassResult = mysqli_query($conn, $carcassQuery);
    while($row = mysqli_fetch_assoc($carcassResult)){
        $carcassMaterials[] = $row;
    }
    /* SHUTTER CATEGORIES */
    $shutterCategories = [];
    $categoryQuery = "
            SELECT
                id,
                category_name
            FROM shutter_categories
            WHERE status='1'
            ORDER BY category_name ASC
        ";
    $categoryResult = mysqli_query($conn, $categoryQuery);
    while($row = mysqli_fetch_assoc($categoryResult)){
        $shutterCategories[] = $row;
    }
    /* SHUTTER MATERIALS */
    $shutterMaterials = [];
    $materialQuery = "
            SELECT
                shutter_materials.id,
                shutter_materials.category_id,
                shutter_materials.material_type,
                shutter_materials.price_per_sqft,
                shutter_categories.category_name
            FROM shutter_materials
            LEFT JOIN shutter_categories
            ON shutter_materials.category_id = shutter_categories.id
            WHERE shutter_materials.status='1'
            ORDER BY shutter_materials.material_type ASC
        ";
    $materialResult = mysqli_query($conn, $materialQuery);
    while($row = mysqli_fetch_assoc($materialResult)){
        $shutterMaterials[] = $row;
    }
    /* DRAWERS */
    $drawers = [];
    $drawerQuery = "
            SELECT
                id,
                category_id,
                material_name,
                price_per_sqft
            FROM drawer_materials
            WHERE status='1'
            ORDER BY material_name ASC
        ";
    $drawerResult = mysqli_query($conn, $drawerQuery);
    while($row = mysqli_fetch_assoc($drawerResult)){
        $drawers[] = $row;
    }
    /* SHELVES */
    $shelves = [];
    $shelfQuery = "
            SELECT
                id,
                category_id,
                material_name,
                price_per_sqft
            FROM shelf_materials
            WHERE status='1'
            ORDER BY material_name ASC
        ";
    $shelfResult = mysqli_query($conn, $shelfQuery);
    while($row = mysqli_fetch_assoc($shelfResult)){
        $shelves[] = $row;
    }
    /* ACCESSORIES */
    $getAccessories = mysqli_query($conn, "
            SELECT
                id,
                accessory_name,
                price
            FROM accessories
            WHERE status='active'
            ORDER BY accessory_name ASC
        ");
    $accessoryOptions = '';
    while($acc = mysqli_fetch_assoc($getAccessories)){
        $accessoryOptions .= '<option value=\"'.$acc['id'].'\" data-price=\"'.$acc['price'].'\">'.$acc['accessory_name'].'</option>';
    }
    // STANDARD ACCESSORIES
    $standardAccessoriesQuery = mysqli_query(
    $conn,
        "
        SELECT
            qsa.*,
            sam.category_id
        FROM quotation_standard_accessories qsa
        LEFT JOIN standard_accessory_materials sam
        ON sam.id = qsa.standard_accessory_id
        WHERE qsa.quotation_id = '$quotation_id'
        ORDER BY qsa.id ASC
        "
    );
    $EDIT_STANDARD_ACCESSORIES = [];
    while(
        $row = mysqli_fetch_assoc($standardAccessoriesQuery)
    ){
        $EDIT_STANDARD_ACCESSORIES[] = $row;
    }
    $standardAccessoryOptions = '';
    $standardAccessories = mysqli_query(
        $conn,
        "
        SELECT
            standard_accessory_materials.id,
            standard_accessory_materials.material_name,
            standard_accessory_materials.price,
            standard_accessory_materials.unit,
            standard_accessory_categories.category_name
        FROM standard_accessory_materials
        LEFT JOIN standard_accessory_categories
        ON standard_accessory_categories.id =
        standard_accessory_materials.category_id
        WHERE standard_accessory_materials.status = 1
        ORDER BY standard_accessory_materials.id ASC
        "
    );
    while($row = mysqli_fetch_assoc($standardAccessories)){
        $standardAccessoryOptions .=
        '<option value="'.$row['id'].'" data-price="'.$row['price'].'">'
            .$row['category_name'].' - '
            .$row['material_name'].' ('.$row['unit'].')'
        .'</option>';
    }
    $standardAccessoryCategoryOptions = '';
    $categories = mysqli_query(
        $conn,
        "
        SELECT *
        FROM standard_accessory_categories
        WHERE status = 1
        ORDER BY category_name DESC
        "
    );
    while($row = mysqli_fetch_assoc($categories)){
        $standardAccessoryCategoryOptions .=
        '<option value="'.$row['id'].'">'.
        $row['category_name'].
        '</option>';
    }
    // VISIBLE PANEL
    $visiblePanelCategories = mysqli_fetch_all(
        mysqli_query(
            $conn,
            "
            SELECT * 
            FROM visible_panel_categories 
            WHERE status=1
            "
        ),
        MYSQLI_ASSOC
    );
    $visiblePanelMaterials = mysqli_fetch_all(
        mysqli_query(
            $conn,
            "
            SELECT * 
            FROM visible_panel_materials 
            WHERE status=1
            "
        ),
        MYSQLI_ASSOC
    );
    $visiblePanels = [];
    $query = mysqli_query(
        $conn,
        "
        SELECT *
        FROM quotation_visible_panels
        WHERE quotation_id = '$quotation_id'
        ORDER BY id ASC
        "
    );
    while($row = mysqli_fetch_assoc($query)){
        $visiblePanels[] = $row;
    }
    // VISIBLE SIDE PANEL
    $visibleSidePanels = [];
    $query = mysqli_query(
        $conn,
        "
        SELECT *
        FROM quotation_visible_side_panels
        WHERE quotation_id = '$quotation_id'
        ORDER BY id ASC
        "
    );
    while($row = mysqli_fetch_assoc($query)){
        $visibleSidePanels[] = $row;
    }
    $visibleSideCategories = mysqli_fetch_all(
        mysqli_query(
            $conn,
            "
            SELECT * 
            FROM visible_side_categories
            WHERE status = 1
            ORDER BY category_name
            "
        ),
        MYSQLI_ASSOC
    );
    $visibleSideMaterials = mysqli_fetch_all(
        mysqli_query(
            $conn,
            "
            SELECT * 
            FROM visible_side_materials
            WHERE status = 1
            ORDER BY material_name
            "
        ),
        MYSQLI_ASSOC
    );
?>
<form id="quotationForm" novalidate onkeydown="preventEnterSubmit(event)">
    <div class="container-fluid">
        <div class="top-header">
            <div>
                <h2 class="page-title">New Project</h2>
                <p class="page-subtitle">
                    <?php
                        $entityResult = mysqli_query($conn,
                            "SELECT * FROM entities
                            WHERE status='active'
                            ORDER BY entity_name"
                        );
                    ?>
                    <div class="col-md-12 mb-3">
                        <label class="form-label"> Entity </label>
                        <?php if($_SESSION['role_id'] == 1){ ?>
                            <select name="entity_id" class="form-control" required>
                                <option value="">Select Entity</option>
                                <?php
                                $result = mysqli_query($conn,"SELECT * FROM entities ORDER BY entity_name");
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <option value="<?= $row['id']; ?>" <?= ($quotation['entity_id'] == $row['id']) ? 'selected' : ''; ?>>
                                        <?= $row['entity_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <?php
                                $entityId = $_SESSION['entity_id'];
                                $entityQuery = mysqli_query($conn,
                                        "
                                        SELECT *
                                        FROM entities
                                        WHERE id='$entityId'
                                        LIMIT 1
                                        "
                                    );
                                $entity = mysqli_fetch_assoc($entityQuery);
                            ?>
                            <input type="hidden" name="entity_id"  value="<?= $entity['id']; ?>">
                            <input type="text" class="form-control" value="<?= $entity['entity_name']; ?>" readonly>
                        <?php } ?>
                    </div>
                </p>  
            </div>
        </div>
        <div class="main-card mb-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Client Name</label>
                    <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Enter Client Name" value="<?= htmlspecialchars($client['client_name']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Project Type</label>
                    <select class="modern-input" id="projectType" name="project_type" onchange="toggleOtherInput()">
                        <option value="Kitchen" <?= ($quotation['project_type'] == 'Kitchen') ? 'selected' : ''; ?>>Kitchen</option>
                        <option value="Wardrobe" <?= ($quotation['project_type'] == 'Wardrobe') ? 'selected' : ''; ?>>Wardrobe</option>
                        <option value="Bar" <?= ($quotation['project_type'] == 'Bar') ? 'selected' : ''; ?>>Bar</option>
                        <option value="Other" <?= ($quotation['project_type'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                    <input type="text" id="otherProjectInput" name="other_project_type" class="modern-input mt-3" placeholder="Specify other project type" style="display:none;">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Mobile Number</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Mobile Number" value="<?= htmlspecialchars($client['phone']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>E-mail Address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter E-Mail Address" value="<?= htmlspecialchars($client['email']); ?>">
                </div>
            </div>
        </div>
        <div class="main-card mb-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>GST Number</label>
                    <input type="text" name="gst_number" id="gst_number" class="form-control" placeholder="Enter GST Number" value="<?= htmlspecialchars($client['gst_number']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>PAN Number</label>
                    <input type="text" name="pan_number" id="pan_number" class="form-control" placeholder="Enter Pan Number" value="<?= htmlspecialchars($client['pan_number']); ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Billing Address</label>
                    <textarea
                        name="address"
                        id="address"
                        class="form-control"
                        placeholder="Enter Billing Address"><?= htmlspecialchars($client['address']); ?>
                    </textarea>
                    <div class="mt-2 d-flex">
                        <input type="checkbox" id="sameAddress" onchange="toggleShippingAddress()">
                        <label for="sameAddress" class="mt-2 mx-2">Same As Billing Address</label>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Shipping Address</label>
                    <textarea name="shipping_address" id="shippingAddress" class="form-control" placeholder="Enter Shipping Address"><?= htmlspecialchars($client['shipping_address']); ?></textarea>
                </div>
            </div>
        </div>
        <div class="main-card mb-4">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label>Total Carpentry Sq.Ft</label>
                    <input type="text" id="totalSqft" name="total_sqft" class="modern-input" readonly>
                </div>
                <div class="row mb-4 align-items-end">
                    <div class="col-md-4">
                        <label>Number Of Elevations</label>
                        <input type="number" id="elevationCount" class="modern-input" value="1" min="1">
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="generate-btn" onclick="generateElevations()">Add Elevations</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="elevationContainer"></div>
        <div class="main-card" style="margin-top:30px;">
            <div class="page-header mb-0">
                <h2 class="page-title">Visible Panels</h2>
            </div>
            <div class="form-group">
                <label>Visible Panels</label>
                <div class="panel-radio-group">
                    <label class="panel-radio">
                        <input type="radio" name="hasPanels" value="1">
                        <span>Yes</span>
                    </label>
                    <label class="panel-radio">
                        <input type="radio" name="hasPanels" value="0" checked>
                        <span>No</span>
                    </label>
                </div>
                <style>.panel-radio-group{display:flex;gap:20px;margin-top:10px;}.panel-radio{display:flex;align-items:center;gap:8px;cursor:pointer;font-weight:500;}.panel-radio input[type="radio"]{width:16px;height:16px;margin:0;cursor:pointer;}</style>
            </div>
            <div id="panelSection" style="display:none;">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Width (MM)</th>
                                <th>Height (MM)</th>
                                <th>Sq Ft</th>
                                <th>Category</th>
                                <th>Material</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="panelContainer"></tbody>
                    </table>
                </div>
                <div style="margin:15px 0;">
                    <button type="button" class="btn btn-primary" onclick="addPanelRow()">+ Add Panel</button>
                </div>
            </div>
            <div class="card mt-4" style="background:#f8fafc;">
                <h5>Visible Panels Total : ₹ <span id="panelGrandTotal">0.00</span></h5>
            </div>
        </div>
        <div class="main-card" style="margin-top:30px;">
            <div class="page-header mb-0">
                <h2 class="page-title">Visible Side Panels</h2>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Visible Side Panels</label>
                    <div class="panel-radio-group">
                        <label class="panel-radio">
                            <input type="radio" name="hasSidePanels" value="1">
                            <span>Yes</span>
                        </label>
                        <label class="panel-radio">
                            <input type="radio" name="hasSidePanels" value="0" checked>
                            <span>No</span>
                        </label>
                    </div>
                </div>
            </div>
            <div id="sidePanelSection" style="display:none;">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Width (MM)</th>
                                <th>Height (MM)</th>
                                <th>Sq Ft</th>
                                <th>Category</th>
                                <th>Material</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="sidePanelContainer"></tbody>
                    </table>
                </div>
                <div style="margin:15px 0;">
                    <button type="button" class="btn btn-primary" onclick="addSidePanelRow()">+ Add Side Panel</button>
                </div>
            </div>
            <div class="card mt-4" style="background:#f8fafc;">
                <h5>Visible Side Total : ₹ <span id="sidePanelGrandTotal">0.00</span></h5>
            </div>
        </div>
        <div class="main-card" style="margin-top:30px;">
            <div class="page-header mb-0">
                <div>
                    <h2 class="page-title">Standard Accessories</h2>
                </div>
            </div>
            <div class="form-group">
                <label>Standard Accessories</label>
                <div class="panel-radio-group">
                    <label class="panel-radio">
                        <input type="radio" name="hasStandardAccessories" value="1" checked>
                        <span>Yes</span>
                    </label>
                    <label class="panel-radio">
                        <input type="radio" name="hasStandardAccessories" value="0">
                        <span>No</span>
                    </label>
                </div>
            </div>
            <div id="standardAccessorySection">
                <div style="margin:15px 0;">
                    <div id="standardAccessoriesContainer"></div>
                    <button type="button" class="btn btn-primary" onclick="addStandardAccessoryRow()">+ Add Standard Accessory</button>
                </div>
            </div>
            <div class="card" style="background:#f8fafc;">
                <h5>Standard Accessories Total : ₹ <span id="standardAccessoriesGrandTotal"> 0.00</span></h5>
            </div>
        </div>
        <div class="main-card" style="margin-top:30px;">
            <div class="page-header mb-0">
                <div>
                    <h2 class="page-title">Additional Accessories </h2>
                </div>
            </div>
            <div class="form-group">
                <label>Additional Accessories</label>
                <div class="panel-radio-group">
                    <label class="panel-radio">
                        <input type="radio" name="hasAccessories" value="1" checked>
                        <span>Yes</span>
                    </label>
                    <label class="panel-radio">
                        <input type="radio" name="hasAccessories" value="0">
                        <span>No</span>
                    </label>
                </div>
            </div>
            <div id="accessorySection">
                <div id="accessoriesContainer"></div>
                <div style="margin:15px 0;">
                    <button type="button" class="btn btn-primary" onclick="addAccessoryRow()">+ Add Accessory</button>
                </div>
            </div>
            <div class="card" style="background:#f8fafc;">
                <h5>Additional Accessories Total : ₹ <span id="accessoriesGrandTotal">0.00</span></h5>
            </div>
        </div>
        <?php include '../components/project-images.php'; ?>
    </div>
</form>
<div class="main-card mt-4">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label">Add : Pkg. & Forwarding & Transport</label>
            <input type="number" step="1000" min="0" id="packingCharge" class="form-control modern-input" value="0" oninput="calculateFinalPricing()">
        </div>
        <div class="col-md-6">
            <label class="form-label">Add : Installation</label>
            <input type="number" id="installationCharge" min="0" class="form-control modern-input" value="0" readonly>
        </div>
    </div>
</div>
<div class="main-card mt-4">
    <div class="row">
        <div class="col-md-6 mb-4">
            <label style=" font-size:18px; font-weight:700;margin-bottom:12px; display:block;">Grand Total</label>
            <input type="text" min="0" id="grandTotal" class="modern-input" readonly style=" font-size:22px; font-weight:700; color:#111827; background:#f8fafc;" >
        </div>
        <div class="col-md-6 mb-4">
            <label class="form-label" min="0" style="font-size:18px; font-weight:700; margin-bottom:12px; display:block;">Special Discount (%)</label>
            <input type="number" step="1" id="specialDiscount" class="form-control modern-input" min="0" value="0" oninput="calculateFinalPricing()">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label class="form-label" style=" font-size:22px; font-weight:700; color:#1e293b;">Final Customer Price</label>
            <input type="text" min="0" id="finalCustomerPrice" class="form-control modern-input" readonly style=" height:70px; font-size:28px; font-weight:700; background:#ecfdf5; color:#15803d; border:2px solid #bbf7d0;">
        </div>
    </div>
</div>
<button type="button" class="generate-btn" style=" max-width:220px; " onclick="updateQuotation()" > Update Quotation </button>
<script>
    const IS_EDIT_PAGE = true;
    const QUOTATION_ID = <?= $quotation_id ?>;
    const CLIENT_ID = <?= $quotation['client_id'] ?>;
    const EDIT_ELEVATIONS = <?= json_encode($elevations); ?>;
    const EDIT_UNITS =<?= json_encode($units); ?>;
    const EDIT_DRAWERS = <?= json_encode($EDIT_DRAWERS); ?>;
    const EDIT_SHELVES = <?= json_encode($EDIT_SHELVES); ?>;
    const EDIT_ACCESSORIES = <?= json_encode($accessories); ?>;
    const QUOTATION = <?= json_encode($quotation); ?>;
    const EDIT_IMAGES = <?= json_encode($elevationImages); ?>;
    const EDIT_STANDARD_ACCESSORIES = <?= json_encode($EDIT_STANDARD_ACCESSORIES ?? []) ?>;
    const visiblePanelCategories = <?= json_encode($visiblePanelCategories); ?>;
    const visiblePanelMaterials = <?= json_encode($visiblePanelMaterials); ?>;
    const EDIT_VISIBLE_PANELS = <?= json_encode($visiblePanels); ?>;
    const EDIT_VISIBLE_SIDE_PANELS = <?= json_encode($visibleSidePanels); ?>;
    const visibleSideCategories = <?= json_encode($visibleSideCategories); ?>;
    const visibleSideMaterials = <?= json_encode($visibleSideMaterials); ?>;
    const EDIT_PROJECT_IMAGES = <?= json_encode($projectImages); ?>;
    window.oldElevationImages = {};
    window.deletedImages = [];
    window.oldProjectImages = {
        render: [],
        floorplan: [],
        elevations: {}
    };
    window.deletedProjectImages = [];
        document.addEventListener(
        'DOMContentLoaded',
        async function(){
            document.getElementById('elevationCount').value = EDIT_ELEVATIONS.length;
            if(
                EDIT_PROJECT_IMAGES.render &&
                EDIT_PROJECT_IMAGES.render.length
            ){
                window.oldProjectImages.render = [...EDIT_PROJECT_IMAGES.render];
                PROJECT_IMAGES.render = [...EDIT_PROJECT_IMAGES.render];
            }
            if(
                EDIT_PROJECT_IMAGES.floorplan &&
                EDIT_PROJECT_IMAGES.floorplan.length
            ){
                window.oldProjectImages.floorplan = [...EDIT_PROJECT_IMAGES.floorplan];
                PROJECT_IMAGES.floorplan = [...EDIT_PROJECT_IMAGES.floorplan];
            }
            renderPreview("render","renderPreview");
            renderPreview("floorplan","floorPreview");
            await generateElevations();
            const cards = document.querySelectorAll('.elevation-card');
            for(
                let index = 0;
                index < EDIT_ELEVATIONS.length;
                index++
            ){
                const elevation = EDIT_ELEVATIONS[index];
                const card = cards[index];
                if(!card) continue;
                const noteToggle = card.querySelector('.elevationNoteToggle');
                const noteField = card.querySelector('.elevationNote');
                const noteWrapper = card.querySelector('.elevationNoteWrapper');
                if(noteToggle){
                    noteToggle.value = elevation.show_note || 0;
                    if(
                        elevation.show_note == 1
                    ){
                        noteWrapper.style.display = 'block';
                        if(noteField){
                            noteField.value = elevation.elevation_note || '';
                        }
                    }
                }
                const previewContainer = card.querySelector('.line-image-preview');
                if(
                    previewContainer &&
                    EDIT_IMAGES[elevation.id]
                ){
                    if(
                        typeof window.oldElevationImages === 'undefined'
                    ){
                        window.oldElevationImages = {};
                    }
                    window.oldElevationImages[index + 1] = [...EDIT_IMAGES[elevation.id]];
                    EDIT_IMAGES[elevation.id]
                    .forEach(image => {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'position-relative d-inline-block me-2 mb-2';
                        wrapper.innerHTML = `
                            <img src="/QG/uploads/line-images/${image}" class="preview-image preview-card" style="width:140px;height:140px;border-radius:10px;overflow:hidden;border:1px solid #ddd;box-shadow:0 2px 8px rgba(0,0,0,.08);">
                            <button type="button" class="btn btn-danger btn-sm remove-preview remove-old-image" data-image="${image}" data-elevation="${elevation.id}">x</button>
                        `;
                        previewContainer.appendChild(
                            wrapper
                        );
                    });
                }
                if(
                    EDIT_PROJECT_IMAGES.elevations[elevation.id]
                ){
                    PROJECT_IMAGES.elevations[index] = [...EDIT_PROJECT_IMAGES.elevations[elevation.id]];
                    renderElevationPreview(index);
                }
                // ELEVATION Height
                card.querySelector('.ceilingHeightMM').value = elevation.ceiling_height_mm;
                card.querySelector('.ceilingHeightFT').value = elevation.ceiling_height_ft;
                // Units
                const units = EDIT_UNITS[elevation.id] || [];
                const tallUnits = units.filter(u => u.unit_type === 'Tall');
                const upperUnits = units.filter(u => u.unit_type === 'Upper');
                const bottomUnits = units.filter(u => u.unit_type === 'Bottom');
                const loftUnits = units.filter(u => u.unit_type === 'Loft');
                // Set Counts
                card.querySelector('.tallUnitCount').value = tallUnits.length;
                card.querySelector('.upperUnitCount').value = upperUnits.length;
                card.querySelector('.bottomUnitCount').value = bottomUnits.length;
                card.querySelector('.loftUnitCount').value = loftUnits.length;
                // Generate Rows
                if(tallUnits.length > 0){
                    await generateUnits(
                        card.querySelector('.tallUnitCount')
                        .closest('.unit-wrapper')
                        .querySelector('.generate-btn'),
                        'Tall'
                    );
                }
                if(upperUnits.length > 0){
                    await generateUnits(
                        card.querySelector('.upperUnitCount')
                        .closest('.unit-wrapper')
                        .querySelector('.generate-btn'),
                        'Upper'
                    );
                }
                if(bottomUnits.length > 0){
                    await generateUnits(
                        card.querySelector('.bottomUnitCount')
                        .closest('.unit-wrapper')
                        .querySelector('.generate-btn'),
                        'Bottom'
                    );
                }
                if(loftUnits.length > 0){
                    await generateUnits(
                        card.querySelector('.loftUnitCount')
                        .closest('.unit-wrapper')
                        .querySelector('.generate-btn'),
                        'Loft'
                    );
                }
                // Tall Rows
                const tallRows = card.querySelectorAll('.tallRow');
                for(let rowIndex = 0; rowIndex < tallRows.length; rowIndex++){
                    const row = tallRows[rowIndex];
                    const unit = tallUnits[rowIndex];
                    if(!unit) continue;
                    if(row.querySelector('.widthMM')){
                        row.querySelector('.widthMM').value = unit.width_mm;
                    }
                    if(row.querySelector('.heightMM')){
                        row.querySelector('.heightMM').value = unit.height_mm;
                    }
                    if(row.querySelector('.depthMM')){
                        row.querySelector('.depthMM').value = unit.depth_mm;
                    }
                    const carcassCategory = row.querySelector('.carcassCategory');
                    if(carcassCategory){
                        carcassCategory.value = unit.carcass_categories_id;
                        await loadCarcassMaterials(carcassCategory);
                        await new Promise(resolve => setTimeout(resolve, 50));
                        const carcassMaterial =row.querySelector('.carcassMaterial');
                        if(carcassMaterial){
                            carcassMaterial.value = unit.carcass_materials_id;
                        }
                    }
                    const shutterCategory = row.querySelector('.shutterCategory');
                    if(shutterCategory){
                        shutterCategory.value = unit.shutter_categories_id;
                        await loadShutterMaterials(shutterCategory);
                        await new Promise(resolve => setTimeout(resolve, 50));
                        const shutterMaterial = row.querySelector('.shutterSubMaterial');
                        if(shutterMaterial){
                            shutterMaterial.value = unit.shutter_materials_id;
                        }
                    }
                    if(row.querySelector('.widthMM')){
                        row.querySelector('.widthMM')
                            .dispatchEvent(new Event('input'));
                    }
                    if(row.querySelector('.heightMM')){
                        row.querySelector('.heightMM')
                            .dispatchEvent(new Event('input'));
                    }
                    if(row.querySelector('.depthMM')){
                        row.querySelector('.depthMM')
                            .dispatchEvent(new Event('input'));
                    }
                    if(row.querySelector('.carcassMaterial')){
                        row.querySelector('.carcassMaterial')
                            .dispatchEvent(new Event('change'));
                    }
                    if(row.querySelector('.material_type')){
                        row.querySelector('.material_type')
                            .dispatchEvent(new Event('change'));
                    }
                    if(typeof updateRowTotal === 'function'){updateRowTotal(row);}
                    if(typeof calculateGrandUnitTotal === 'function'){
                        const unitContainer = row.closest('.tall-master') || row.closest('.upper-master') || row.closest('.bottom-master') || row.closest('.loft-master');
                        calculateGrandUnitTotal(unitContainer);
                    }
                    if(typeof updateGrandTotal === 'function'){updateGrandTotal();}
                }
                // Upper Rows
                const upperRows = card.querySelectorAll('.upperRow');
                for(let rowIndex = 0; rowIndex < upperRows.length; rowIndex++){
                    const row = upperRows[rowIndex];
                    const unit = upperUnits[rowIndex];
                    if(!unit) continue;
                    if(row.querySelector('.widthMM')){
                        row.querySelector('.widthMM').value = unit.width_mm;
                    }
                    if(row.querySelector('.heightMM')){
                        row.querySelector('.heightMM').value = unit.height_mm;
                    }
                    if(row.querySelector('.depthMM')){
                        row.querySelector('.depthMM').value = unit.depth_mm;
                    }
                    const carcassCategory = row.querySelector('.carcassCategory');
                    if(carcassCategory){
                        carcassCategory.value = unit.carcass_categories_id;
                        await loadCarcassMaterials(carcassCategory);
                        await new Promise(resolve => setTimeout(resolve, 50));
                        const carcassMaterial = row.querySelector('.carcassMaterial');
                        if(carcassMaterial){
                            carcassMaterial.value = unit.carcass_materials_id;
                        }
                    }
                    const shutterCategory = row.querySelector('.shutterCategory');
                    if(shutterCategory){
                        shutterCategory.value = unit.shutter_categories_id;
                        await loadShutterMaterials(shutterCategory);
                        await new Promise(resolve => setTimeout(resolve, 50));
                        const shutterMaterial = row.querySelector('.shutterSubMaterial');
                        if(shutterMaterial){
                            shutterMaterial.value = unit.shutter_materials_id;
                        }
                    }
                    if(typeof updateRowTotal === 'function'){updateRowTotal(row);}
                    if(row.querySelector('.widthMM')){
                        row.querySelector('.widthMM')
                            .dispatchEvent(new Event('input'));
                    }
                    if(row.querySelector('.heightMM')){
                        row.querySelector('.heightMM')
                            .dispatchEvent(new Event('input'));
                    }
                    if(row.querySelector('.depthMM')){
                        row.querySelector('.depthMM')
                            .dispatchEvent(new Event('input'));
                    }
                    if(row.querySelector('.carcassMaterial')){
                        row.querySelector('.carcassMaterial')
                            .dispatchEvent(new Event('change'));
                    }
                    if(row.querySelector('.material_type')){
                        row.querySelector('.material_type')
                            .dispatchEvent(new Event('change'));
                    }
                    if(typeof updateRowTotal === 'function'){updateRowTotal(row);}
                    if(typeof calculateGrandUnitTotal === 'function'){
                        const unitContainer = row.closest('.tall-master') || row.closest('.upper-master') || row.closest('.bottom-master') || row.closest('.loft-master');
                        calculateGrandUnitTotal(unitContainer);
                    }
                    if(typeof updateGrandTotal === 'function'){updateGrandTotal();}
                }
                // Bottom Rows
                const bottomRows = card.querySelectorAll('.bottomRow');
                for(let rowIndex = 0; rowIndex < bottomRows.length; rowIndex++){
                    const row = bottomRows[rowIndex];
                    const unit = bottomUnits[rowIndex];
                    if(!unit) continue;
                    if(row.querySelector('.widthMM')){
                        row.querySelector('.widthMM').value = unit.width_mm;
                    }
                    if(row.querySelector('.heightMM')){
                        row.querySelector('.heightMM').value = unit.height_mm;
                    }
                    if(row.querySelector('.depthMM')){
                        row.querySelector('.depthMM').value = unit.depth_mm;
                    }
                    const carcassCategory =  row.querySelector('.carcassCategory');
                    if(carcassCategory){
                        carcassCategory.value = unit.carcass_categories_id;
                        await loadCarcassMaterials(carcassCategory);
                        await new Promise(resolve => setTimeout(resolve, 50));
                        const carcassMaterial = row.querySelector('.carcassMaterial');
                        if(carcassMaterial){
                            carcassMaterial.value = unit.carcass_materials_id;
                        }
                    }
                    const shutterCategory = row.querySelector('.shutterCategory');
                    if(shutterCategory){
                        shutterCategory.value = unit.shutter_categories_id;
                        await loadShutterMaterials(shutterCategory);
                        await new Promise(resolve => setTimeout(resolve, 50));
                        const shutterMaterial = row.querySelector('.shutterSubMaterial');
                        if(shutterMaterial){
                            shutterMaterial.value = unit.shutter_materials_id;
                        }
                    }
                    if(row.querySelector('.widthMM')){
                        row.querySelector('.widthMM')
                            .dispatchEvent(new Event('input'));
                    }
                    if(row.querySelector('.heightMM')){
                        row.querySelector('.heightMM')
                            .dispatchEvent(new Event('input'));
                    }
                    if(row.querySelector('.depthMM')){
                        row.querySelector('.depthMM')
                            .dispatchEvent(new Event('input'));
                    }
                    if(row.querySelector('.carcassMaterial')){
                        row.querySelector('.carcassMaterial')
                            .dispatchEvent(new Event('change'));
                    }
                    if(row.querySelector('.material_type')){
                        row.querySelector('.material_type')
                            .dispatchEvent(new Event('change'));
                    }
                    if(typeof updateRowTotal === 'function'){updateRowTotal(row);}
                    if(typeof calculateGrandUnitTotal === 'function'){
                        const unitContainer = row.closest('.tall-master') || row.closest('.upper-master') || row.closest('.bottom-master') || row.closest('.loft-master');
                        calculateGrandUnitTotal(unitContainer);
                    }
                    if(typeof updateGrandTotal === 'function'){updateGrandTotal();}
                }
                // Loft Rows
                const loftRows = card.querySelectorAll('.loftRow');
                for(let rowIndex = 0; rowIndex < loftRows.length; rowIndex++){
                    const row = loftRows[rowIndex];
                    const unit = loftUnits[rowIndex];
                    if(!unit) continue;
                    if(row.querySelector('.widthMM')){
                        row.querySelector('.widthMM').value = unit.width_mm;
                    }
                    if(row.querySelector('.heightMM')){
                        row.querySelector('.heightMM').value = unit.height_mm;
                    }
                    if(row.querySelector('.depthMM')){
                        row.querySelector('.depthMM').value = unit.depth_mm;
                    }
                    const carcassCategory = row.querySelector('.carcassCategory');
                    if(carcassCategory){
                        carcassCategory.value = unit.carcass_categories_id;
                        await loadCarcassMaterials(carcassCategory);
                        await new Promise(resolve => setTimeout(resolve, 50));
                        const carcassMaterial = row.querySelector('.carcassMaterial');
                        if(carcassMaterial){
                            carcassMaterial.value = unit.carcass_materials_id;
                        }
                    }
                    const shutterCategory = row.querySelector('.shutterCategory');
                    if(shutterCategory){
                        shutterCategory.value = unit.shutter_categories_id;
                        await loadShutterMaterials(shutterCategory);
                        await new Promise(resolve => setTimeout(resolve, 50));
                        const shutterMaterial = row.querySelector('.shutterSubMaterial');
                        if(shutterMaterial){
                            shutterMaterial.value = unit.shutter_materials_id;
                        }
                    }
                    if(row.querySelector('.widthMM')){
                        row.querySelector('.widthMM')
                            .dispatchEvent(new Event('input'));
                    }
                    if(row.querySelector('.heightMM')){
                        row.querySelector('.heightMM')
                            .dispatchEvent(new Event('input'));
                    }
                    if(row.querySelector('.depthMM')){
                        row.querySelector('.depthMM')
                            .dispatchEvent(new Event('input'));
                    }
                    if(row.querySelector('.carcassMaterial')){
                        row.querySelector('.carcassMaterial')
                            .dispatchEvent(new Event('change'));
                    }
                    if(row.querySelector('.material_type')){
                        row.querySelector('.material_type')
                            .dispatchEvent(new Event('change'));
                    }
                    if(typeof updateRowTotal === 'function'){updateRowTotal(row);}
                    if(typeof calculateGrandUnitTotal === 'function'){
                        const unitContainer = row.closest('.tall-master') || row.closest('.upper-master') || row.closest('.bottom-master') || row.closest('.loft-master');
                        calculateGrandUnitTotal(unitContainer);
                    }
                    if(typeof updateGrandTotal === 'function'){updateGrandTotal();}
                }
                // Drawers
                if (
                    typeof EDIT_DRAWERS !== 'undefined' &&
                    EDIT_DRAWERS.length > 0
                ) {
                    const groupedDrawers = {};
                    EDIT_DRAWERS.forEach(drawer => {
                        const parts = drawer.assigned_unit_id.split('_');
                        const elevationNo = parseInt(parts[0].replace('E', ''));
                        const unitType = parts[1].toLowerCase();
                        const key = `${elevationNo}_${unitType}`;
                        if (!groupedDrawers[key]) {
                            groupedDrawers[key] = [];
                        }
                        groupedDrawers[key].push(drawer);
                    });
                    for (const key in groupedDrawers) {
                        const [elevationNo, unitType] = key.split('_');
                        const elevationCard = document.querySelectorAll('.elevation-card')[elevationNo - 1];
                        if (!elevationCard) continue;
                        const master = elevationCard.querySelector(`.${unitType}-master`);
                        if (!master) continue;
                        const yesRadio = master.querySelector('input[name="drawerOption"][value="yes"]');
                        if (yesRadio) {
                            yesRadio.checked = true;
                            toggleDrawerSection(yesRadio);
                        }
                        const drawerCount = master.querySelector('.drawerCount');
                        if (drawerCount) {
                            drawerCount.value = groupedDrawers[key].length;
                        }
                        const button = master.querySelector('.drawer-section .generate-btn' );
                        if (!button) continue;
                        await generateDrawers(button);
                        await new Promise(resolve => setTimeout(resolve, 50));
                        const rows = master.querySelectorAll('.drawerTableBody tr');
                        for (
                            let i = 0;
                            i < groupedDrawers[key].length;
                            i++
                        ) {
                            const drawer = groupedDrawers[key][i];
                            const row = rows[i];
                            if (!row) continue;
                            row.querySelector('.drawerAssignedUnit').value = drawer.assigned_unit_id;
                            row.querySelector('.drawerQty').value = drawer.quantity;
                            row.querySelector('.drawerWidthMM').value = drawer.width_mm;
                            row.querySelector('.drawerWidthFT').value = drawer.width_ft;
                            row.querySelector('.drawerHeightMM').value = drawer.height_mm;
                            row.querySelector('.drawerHeightFT').value = drawer.height_ft;
                            const category = row.querySelector('.drawerCategory');
                            category.value = drawer.drawer_categories_id;
                            await loadDrawerMaterials(category);
                            await new Promise(resolve => setTimeout(resolve, 50));
                            row.querySelector('.drawerMaterial').value = drawer.drawer_materials_id;
                            row.querySelector('.drawerPrice').value = drawer.price;
                            row.querySelector('.drawerTotal').value = '₹ ' + drawer.total;
                        }
                    }
                }
                // Shelves
                if (
                    typeof EDIT_SHELVES !== 'undefined' &&
                    EDIT_SHELVES.length > 0
                ) {
                    const groupedShelves = {};
                    EDIT_SHELVES.forEach(shelf => {
                        const parts = shelf.assigned_unit_id.split('_');
                        const elevationNo = parseInt(parts[0].replace('E', ''));
                        const unitType = parts[1].toLowerCase();
                        const key = `${elevationNo}_${unitType}`;
                        if (!groupedShelves[key]) {
                            groupedShelves[key] = [];
                        }
                        groupedShelves[key].push(shelf);
                    });
                    for (const key in groupedShelves) {
                        const [elevationNo, unitType] = key.split('_');
                        const elevationCard = document.querySelectorAll('.elevation-card')[elevationNo - 1];
                        if (!elevationCard) continue;
                        const master = elevationCard.querySelector(`.${unitType}-master`);
                        if (!master) continue;
                        const yesRadio = master.querySelector('input[name="shelfOption"][value="yes"]');
                        if (yesRadio) {
                            yesRadio.checked = true;
                            toggleShelfSection(yesRadio);
                        }
                        const shelfCount = master.querySelector('.shelfCount');
                        if (shelfCount) {
                            shelfCount.value = groupedShelves[key].length;
                        }
                        const button = master.querySelector('.shelf-section .generate-btn');
                        if (!button) continue;
                        await generateShelves(button);
                        await new Promise(resolve => setTimeout(resolve, 50));
                        const rows = master.querySelectorAll('.shelfTableBody tr');
                        for (
                            let i = 0;
                            i < groupedShelves[key].length;
                            i++
                        ) {
                            const shelf = groupedShelves[key][i];
                            const row = rows[i];
                            if (!row) continue;
                            row.querySelector('.shelfAssignedUnit').value = shelf.assigned_unit_id;
                            row.querySelector('.shelfQty').value = shelf.quantity;
                            row.querySelector('.shelfWidthMM').value = shelf.width_mm;
                            row.querySelector('.shelfWidthFT').value = shelf.width_ft;
                            row.querySelector('.shelfHeightMM').value = shelf.height_mm;
                            row.querySelector('.shelfHeightFT').value = shelf.height_ft;
                            const category = row.querySelector('.shelfCategory');
                            category.value = shelf.shelf_categories_id;
                            await loadShelfMaterials(category);
                            await new Promise(resolve => setTimeout(resolve, 50));
                            row.querySelector('.shelfMaterial').value =shelf.shelf_materials_id;
                            row.querySelector('.shelfPrice').value =shelf.price;
                            row.querySelector('.shelfTotal').value ='₹ ' + shelf.total;
                            if(typeof calculateShelfTotal === 'function'){
                                calculateShelfTotal(row);
                            }
                        }
                    }
                }
                // Visible panel
                if(
                    EDIT_VISIBLE_PANELS &&
                    EDIT_VISIBLE_PANELS.length > 0
                ){
                    document.querySelector('input[name="hasPanels"][value="1"]').checked = true;
                    document.getElementById("panelSection").style.display = "block";
                    EDIT_VISIBLE_PANELS.forEach(panel=>{
                        addPanelRow();
                        const rows = document.querySelectorAll(".panelRow");
                        const row = rows[rows.length-1];
                        row.querySelector(".panelWidth").value = panel.width_mm;
                        row.querySelector(".panelHeight").value = panel.height_mm;
                        row.querySelector(".panelCategory").value = panel.category_id;
                        loadPanelMaterials(panel.category_id,row);
                        setTimeout(()=>{
                            row.querySelector(".panelMaterial").value = panel.material_id;
                            calculatePanelRow(row);
                        },100);
                    });
                }
                // Visible Side panel
                if(
                    EDIT_VISIBLE_SIDE_PANELS &&
                    EDIT_VISIBLE_SIDE_PANELS.length > 0
                ){
                    document.querySelector('input[name="hasSidePanels"][value="1"]').checked = true;
                    document.getElementById("sidePanelSection").style.display = "block";
                    EDIT_VISIBLE_SIDE_PANELS.forEach(panel => {
                        addSidePanelRow();
                        const rows = document.querySelectorAll(".sidePanelRow");
                        const row = rows[rows.length - 1];
                        row.querySelector(".sidePanelWidth").value = panel.width_mm;
                        row.querySelector(".sidePanelHeight").value = panel.height_mm;
                        row.querySelector(".sidePanelCategory").value = panel.category_id;
                        loadSidePanelMaterials(panel.category_id,row);
                        setTimeout(() => {
                            row.querySelector(".sidePanelMaterial").value = panel.material_id;
                            calculateSidePanelRow(row);
                        },100);
                    });
                }
                // Accessories
                if(
                    EDIT_ACCESSORIES &&
                    EDIT_ACCESSORIES.length > 0
                ){
                    document.querySelector('input[name="hasAccessories"][value="1"]').checked = true;
                    document.getElementById("accessorySection").style.display = "block";
                    document.getElementById("accessoriesContainer").innerHTML = "";
                    for(const accessory of EDIT_ACCESSORIES){
                        addAccessoryRow();
                        const rows = document.querySelectorAll(".accessoryRow");
                        const row = rows[rows.length - 1];
                        const category = row.querySelector(".accessoryCategory");
                        const material = row.querySelector(".accessorySelect");
                        category.value = accessory.category_id;
                        await new Promise((resolve,reject)=>{
                            $.ajax({
                                url: BASE_URL + 'ajax/get-accessory-materials.php',
                                type: 'POST',
                                data: {category_id: accessory.category_id},
                                success: function(response){
                                    material.innerHTML = '<option value="">Select Material</option>' + response;
                                    resolve();
                                },
                                error: function(error){
                                    reject(error);
                                }
                            });
                        });
                        material.value = accessory.accessory_id;
                        material.dispatchEvent(new Event("change"));
                        row.querySelector(".accessoryQty").value = accessory.qty;
                        row.querySelector(".accessoryPrice").value = accessory.price;
                        calculateAccessoryTotal(row);
                    }
                    calculateAccessoriesGrandTotal();
                }
                if(
                    EDIT_STANDARD_ACCESSORIES &&
                    EDIT_STANDARD_ACCESSORIES.length > 0
                ){
                    document.querySelector('input[name="hasStandardAccessories"][value="1"]').checked = true;
                    document.getElementById("standardAccessorySection").style.display = "block";
                    document.getElementById("standardAccessoriesContainer").innerHTML = "";
                    for(const accessory of EDIT_STANDARD_ACCESSORIES){
                        addStandardAccessoryRow();
                        const rows = document.querySelectorAll(".standardAccessoryRow");
                        const row = rows[rows.length - 1];
                        const category = row.querySelector(".standardAccessoryCategory");
                        category.value = accessory.category_id;
                        await loadStandardAccessoryMaterials(category);
                        const material = row.querySelector(".standardAccessoryMaterial");
                        material.value = accessory.standard_accessory_id;
                        material.dispatchEvent(new Event("change"));
                        row.querySelector(".standardAccessoryQty").value = accessory.qty;
                        row.querySelector(".standardAccessoryPrice").value = accessory.unit_price;
                        calculateStandardAccessoryTotal(row);
                    }
                    calculateStandardAccessoriesGrandTotal();
                }
                for(
                    let index = 0;
                    index < EDIT_ELEVATIONS.length;
                    index++
                )
                document.getElementById('packingCharge').value = QUOTATION.packing_charge;
                document.getElementById('installationCharge').value = QUOTATION.installation_charge;
                document.getElementById('specialDiscount').value = QUOTATION.special_discount;
                document.getElementById('finalCustomerPrice').value = QUOTATION.final_customer_price;
                if(typeof updateGrandTotal === 'function'){
                    updateGrandTotal();
                }
            }
        }
    );
    function waitForUnits(callback){
        const interval = setInterval(() => {
            const totalUnits = document.querySelectorAll('.tallRow, .upperRow, .bottomRow, .loftRow').length;
            if(totalUnits > 0){
                clearInterval(interval);
                callback();
            }
        },300);
    }
    setTimeout(() => {calculateStandardAccessoriesGrandTotal(); updateGrandTotal();},300);
</script>
<script>
    const COST_MULTLIER = <?= ($_SESSION['entity_id'] == 2) ? 0.5 : 1 ?>;
    function getCostMultiplier(){
        const entityField = document.getElementById('entity_id');
        if(entityField){
            const selectedEntity = entityField.value;
            if(selectedEntity == '2'){
                return 0.5;
            }
            return 1;
        }
        return COST_MULTLIER;
    }
    const carcassMaterials = <?= json_encode($carcassMaterials); ?>;
    const shutterCategories = <?= json_encode($shutterCategories); ?>;
    const shutterMaterials = <?= json_encode($shutterMaterials); ?>;
    const drawers = <?= json_encode($drawers); ?>;
    const shelves = <?= json_encode($shelves); ?>;
    function toggleOtherInput(){
        const projectType = document.getElementById('projectType');
        const otherInput = document.getElementById('otherProjectInput');
        const isOther = projectType.value === 'Other';
        otherInput.style.display = isOther ? 'block' : 'none';
        otherInput.disabled = !isOther;
        otherInput.required = isOther;
        if(!isOther){
            otherInput.value = '';
        }
    }
    function syncShippingAddress(){
        const billing = document.getElementById('address');
        const shipping = document.getElementById('shippingAddress');
        shipping.value = billing.value;
    }
    function toggleShippingAddress(){
        const checkbox = document.getElementById('sameAddress');
        const shipping = document.getElementById('shippingAddress');
        if(checkbox.checked){
            syncShippingAddress();
            shipping.readOnly = true;
            shipping.style.backgroundColor = '#f5f5f5';
        }else{
            shipping.readOnly = false;
            shipping.style.backgroundColor = '#ffffff';
        }
    }
    function preventEnterSubmit(event){
        if(event.key === 'Enter'){
            const target = event.target;
            if(
                target &&
                target.tagName !== 'TEXTAREA' &&
                target.type !== 'submit' &&
                target.type !== 'button'
            ){
                event.preventDefault();
                return false;
            }
        }
    }
    // Visible Panel
    function addPanelRow(){
        const tbody = document.getElementById("panelContainer");
        const srNo = tbody.querySelectorAll(".panelRow").length + 1;
        const panelCategoryOptions = visiblePanelCategories
            .map(cat => `<option value="${cat.id}">${cat.category_name}</option>`)
            .join("");
        const row = document.createElement("tr");
        row.className = "panelRow";
        row.innerHTML = `
            <td class="panelSr">${srNo}</td>
            <td><input type="number" class="form-control panelWidth" min="0"></td>
            <td><input type="number" class="form-control panelHeight" min="0"></td>
            <td><input type="number" class="form-control panelSqft" readonly></td>
            <td>
                <select class="form-control panelCategory">
                    <option value="">Select Category</option>
                    ${panelCategoryOptions}
                </select>
            </td>
            <td>
                <select class="form-control panelMaterial">
                    <option value="">Select Material</option>
                </select>
            </td>
            <td><input type="number" class="form-control panelPrice" readonly></td>
            <td><button type="button" class="delete-btn removePanel">✕</button></td>
        `;
        tbody.appendChild(row);
        attachPanelEvents();
    }
    function attachPanelEvents(){
        document.querySelectorAll(".panelRow")
        .forEach(row=>{
            row.querySelectorAll(".panelWidth,.panelHeight")
            .forEach(input=>{
                input.oninput = function(){
                    calculatePanelRow(row);
                };
            });
            row.querySelector(".panelCategory")
            .onchange = function(){
                loadPanelMaterials(this.value,row);
            };
            row.querySelector(".panelMaterial")
            .onchange = function(){
                calculatePanelRow(row);
            };
        });
    }
    function loadPanelMaterials(categoryId,row){
        const materialSelect = row.querySelector(".panelMaterial");
        materialSelect.innerHTML = '<option value="">Select Material</option>';
        visiblePanelMaterials
        .filter(mat => mat.category_id == categoryId)
        .forEach(mat => {
            materialSelect.innerHTML += `
                <option value="${mat.id}" data-price="${mat.price_per_sqft}">
                    ${mat.material_name}
                </option>
            `;
        });
    }
    document.querySelectorAll('input[name="hasPanels"]')
        .forEach(radio => {
        radio.addEventListener('change', function(){
            const panelSection = document.getElementById('panelSection');
            if(this.value == "1"){
                panelSection.style.display = "block";
                if(document.querySelectorAll('.panelRow').length === 0){
                    addPanelRow();
                }
            }else{
                panelSection.style.display = "none";
                document.getElementById('panelContainer').innerHTML = "";
                document.getElementById('panelGrandTotal').innerText = "0.00";
                updateGrandTotal();
            }
        });
    });
    document.addEventListener("click", function(e){
        if(!e.target.classList.contains("removePanel")) return;
        const row = e.target.closest("tr");
        row.remove();
        updatePanelSerialNumbers();
        calculatePanelsGrandTotal();
        updateGrandTotal();
    });
    function updatePanelSerialNumbers(){
        document.querySelectorAll("#panelContainer .panelRow")
        .forEach((row,index)=>{
            row.querySelector(".panelSr").innerText = index + 1;
        });
    }
    function calculatePanelRow(row){
        const width = parseFloat(row.querySelector('.panelWidth').value) || 0;
        const height = parseFloat(row.querySelector('.panelHeight').value) || 0;
        const sqft = (width / 304.8) * (height / 304.8);
        row.querySelector('.panelSqft').value = sqft.toFixed(2);
        const material = row.querySelector('.panelMaterial');
        const pricePerSqft = parseFloat(material.selectedOptions[0] ?.dataset.price) || 0;
        const total = sqft * pricePerSqft;
        row.querySelector('.panelPrice').value = total.toFixed(2);
        calculatePanelsGrandTotal();
        updateGrandTotal();
    }
    function calculatePanelsGrandTotal(){
        let total = 0;
        document
        .querySelectorAll('.panelPrice')
        .forEach(input => {total += parseFloat(input.value) || 0;});
        document.getElementById('panelGrandTotal').innerText = total.toFixed(2);
    }
    // Standard Accessories
    const standardAccessoryOptions =`<?= $standardAccessoryOptions ?>`;
    const standardAccessoryCategoryOptions =`<?= $standardAccessoryCategoryOptions ?>`;
    function addStandardAccessoryRow(){
        const container = document.getElementById('standardAccessoriesContainer');
        if(!container.querySelector('.standardAccessoriesTable')){
            container.innerHTML = `
                <div class="table-responsive">
                    <table class="table table-bordered standardAccessoriesTable">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Category</th>
                                <th>Material</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="standardAccessoriesTableBody"></tbody>
                    </table>
                </div>
            `;
        }
        const tbody = container.querySelector('.standardAccessoriesTableBody');
        const srNo = tbody.querySelectorAll('tr').length + 1;
        tbody.insertAdjacentHTML(
            'beforeend',
            `
            <tr class="standardAccessoryRow">
                <td class="standardAccessorySrNo">${srNo}</td>
                <td>
                    <select class="form-control standardAccessoryCategory" onchange="loadStandardAccessoryMaterials(this)">
                        <option value="">Select Category</option>
                        ${standardAccessoryCategoryOptions}
                    </select>
                </td>
                <td>
                    <select class="form-control standardAccessoryMaterial">
                        <option value="">Select Material</option>
                    </select>
                </td>
                <td><input type="number" class="form-control standardAccessoryPrice" readonly></td>
                <td><input type="number" class="form-control standardAccessoryQty" value="1" min="1"></td>
                <td><input type="number" class="form-control standardAccessoryTotal" readonly></td>
                <td><button type="button" class="delete-btn removeStandardAccessory">✕</button></td>
            </tr>
            `
        );
        attachStandardAccessoryEvents();
    }
    function attachStandardAccessoryEvents(){
        document
        .querySelectorAll('.standardAccessoryMaterial')
        .forEach(select => {
            select.onchange = function(){
                const row = this.closest('tr');
                const price = parseFloat(this.options[this.selectedIndex]?.dataset.price) || 0;
                row.querySelector('.standardAccessoryPrice').value = price.toFixed(2);
                calculateStandardAccessoryTotal(row);
            };
        });
        document
        .querySelectorAll('.standardAccessoryQty')
        .forEach(input => {
            input.oninput = function(){
                calculateStandardAccessoryTotal(this.closest('tr'));
            };
        });
    }
    function loadStandardAccessoryMaterials(select){

        return new Promise((resolve,reject)=>{

            const categoryId = select.value;

            const row = select.closest('tr');

            const materialDropdown =
            row.querySelector('.standardAccessoryMaterial');

            $.ajax({

                url: BASE_URL + 'ajax/get-standard-accessory-materials.php',

                type:'POST',

                data:{
                    category_id: categoryId
                },

                success:function(response){

                    materialDropdown.innerHTML =
                        '<option value="">Select Material</option>' +
                        response;

                    resolve();

                },

                error:function(error){

                    console.error(error);

                    reject(error);

                }

            });

        });

    }
    function calculateStandardAccessoryTotal(row){
        const qty = parseFloat(row.querySelector('.standardAccessoryQty').value) || 0;
        const price = parseFloat(row.querySelector('.standardAccessoryPrice').value) || 0;
        const total = qty * price;
        row.querySelector('.standardAccessoryTotal').value = total.toFixed(2);
        calculateStandardAccessoriesGrandTotal();
    }
    function calculateStandardAccessoriesGrandTotal(){
        let grand = 0;
        document
        .querySelectorAll('.standardAccessoryTotal')
        .forEach(input => {
            grand += parseFloat(input.value) || 0;
        });
        const grandField = document.getElementById('standardAccessoriesGrandTotal');
        if(grandField){
            grandField.innerText = grand.toFixed(2);
        }
        updateGrandTotal();
    }
    document.querySelectorAll('input[name="hasStandardAccessories"]')
    .forEach(radio => {
        radio.addEventListener('change', function(){
            const section = document.getElementById('standardAccessorySection');
            if(this.value == "1"){
                section.style.display = "block";
                if(document.querySelectorAll('.standardAccessoryRow').length === 0){
                    addStandardAccessoryRow();
                }
            }else{
                section.style.display = "none";
                document.getElementById('standardAccessoriesContainer').innerHTML = "";
                document.getElementById('standardAccessoriesGrandTotal').innerText = "0.00";
                updateGrandTotal();
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function(){
        if(document.querySelectorAll(".standardAccessoryRow").length === 0){
            addStandardAccessoryRow();
        }
    });
    document.addEventListener("click", function(e){
        if(!e.target.classList.contains("removeStandardAccessory")) return;
        const row = e.target.closest("tr");
        row.remove();
        updateStandardAccessorySerialNumbers();
        calculateStandardAccessoriesGrandTotal();
        updateGrandTotal();
    });
    function updateStandardAccessorySerialNumbers(){
        document
        .querySelectorAll(".standardAccessorySrNo")
        .forEach((td,index)=>{
            td.innerText = index + 1;
        });
    }
    // Additional Accessories
    const accessoryCategoryOptions = `<?= $accessoryCategoryOptions ?>`;
    function addAccessoryRow(){
        const container = document.getElementById('accessoriesContainer');
        if(!container.querySelector('.accessoriesTable')){
            container.innerHTML = `
                <div class="table-responsive">
                    <table class="table accessoriesTable">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Category</th>
                                <th>Material</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="accessoriesTableBody"></tbody>
                    </table>
                </div>
            `;
        }
        const tbody = container.querySelector('.accessoriesTableBody');
        const srNo = tbody.querySelectorAll('tr').length + 1;
        tbody.insertAdjacentHTML(
            'beforeend',
            `
            <tr class="accessoryRow">
                <td class="accessorySrNo">${srNo}</td>
                <td>
                    <select class="form-control accessoryCategory" onchange="loadAccessoryMaterials(this)">
                        <option value="">Select Category</option>
                        ${accessoryCategoryOptions}
                    </select>
                </td>
                <td>
                    <select class="form-control accessorySelect">
                        <option value="">Select Material</option>
                    </select>
                </td>
                <td><input type="number" class="form-control accessoryPrice" readonly></td>
                <td><input type="number" class="form-control accessoryQty" value="1" min="1"></td>
                <td><input type="number" class="form-control accessoryTotal" readonly></td>
                <td><button type="button" class="delete-btn removeAccessory">✕</button></td>
            </tr>
            `
        );
        attachAccessoryEvents();
    }
    function loadAccessoryMaterials(category){
        const row = category.closest('tr');
        const materialSelect = row.querySelector('.accessorySelect');
        const priceField = row.querySelector('.accessoryPrice');
        materialSelect.innerHTML = '<option value="">Select Material</option>';
        priceField.value = '';
        $.ajax({
            url:'/QG/ajax/get-accessory-materials.php',
            type:'POST',
            data:{category_id: category.value},
            success:function(response){
                materialSelect.innerHTML = '<option value="">Select Material</option>' + response;
            }
        });
    }
    function attachAccessoryEvents(){
        document
        .querySelectorAll('.accessorySelect')
        .forEach(select=>{
            select.onchange = function(){
                const row = this.closest('tr');
                const option = this.options[this.selectedIndex];
                const price = parseFloat(option.dataset.price) || 0;
                row.querySelector('.accessoryPrice').value = price.toFixed(2);
                calculateAccessoryTotal(row);
            };
        });
        document
        .querySelectorAll('.accessoryQty')
        .forEach(input=>{
            input.oninput=function(){
                calculateAccessoryTotal(this.closest('tr'));
            };
        });
        document
        .querySelectorAll('.accessoryPrice')
        .forEach(input=>{
            input.oninput=function(){
                calculateAccessoryTotal(this.closest('tr'));
            };
        });
    }
    function calculateAccessoryTotal(row){
        const qty = parseFloat(row.querySelector('.accessoryQty').value) || 0;
        const price = parseFloat(row.querySelector('.accessoryPrice').value) || 0;
        const total = qty * price;
        row.querySelector('.accessoryTotal').value =total.toFixed(2);
        calculateAccessoriesGrandTotal();
    }
    function calculateAccessoriesGrandTotal(){
        let grand = 0;
        const totals = document.querySelectorAll( '.accessoryTotal');
        totals.forEach(input => {
            grand += parseFloat(input.value) || 0;
        });
        const grandField = document.getElementById('accessoriesGrandTotal');
        if(grandField){
            grandField.innerText = grand.toFixed(2);
        }
        updateGrandTotal();
    }
    document.querySelectorAll('input[name="hasAccessories"]')
        .forEach(radio=>{
            radio.addEventListener('change',function(){
                const section = document.getElementById('accessorySection');
                if(this.value=="1"){
                    section.style.display="block";
                    if(document.querySelectorAll('.accessoryRow').length===0){
                        addAccessoryRow();
                    }
                }else{
                    section.style.display="none";
                    document.getElementById('accessoriesContainer').innerHTML="";
                    document.getElementById('accessoriesGrandTotal').innerText="0.00";
                    updateGrandTotal();
                }
            });
        }
    );
    document.addEventListener("click", function(e){
        if(!e.target.classList.contains("removeAccessory")) return;
        const row = e.target.closest("tr");
        row.remove();
        updateAccessorySerialNumbers();
        calculateAccessoriesGrandTotal();
        updateGrandTotal();
    });
    function updateAccessorySerialNumbers(){
        document.querySelectorAll(".accessorySrNo")
        .forEach((td,index)=>{td.innerText = index + 1;});
    }
    document.addEventListener("DOMContentLoaded", function(){
        if(document.querySelectorAll(".accessoryRow").length === 0){
            addAccessoryRow();
        }
    });
    // Visible side panel
    document.querySelectorAll('input[name="hasSidePanels"]')
        .forEach(radio => {
            radio.addEventListener('change', function(){
                const section = document.getElementById('sidePanelSection');
                if(this.value == "1"){
                    section.style.display = "block";
                    if(document.querySelectorAll('.sidePanelRow').length === 0){
                        addSidePanelRow();
                    }
                }else{
                    section.style.display = "none";
                    document.getElementById('sidePanelContainer').innerHTML = "";
                    document.getElementById('sidePanelGrandTotal').innerText = "0.00";
                    updateGrandTotal();
                }
            });
        }
    );
    function addSidePanelRow(){
        const tbody = document.getElementById('sidePanelContainer');
        const srNo = tbody.querySelectorAll('tr').length+1;
        const options = visibleSideCategories
            .map(cat=>`<option value="${cat.id}">${cat.category_name}</option>`)
            .join('');
        const row=document.createElement('tr');
        row.className="sidePanelRow";
        row.innerHTML=`
            <td class="sidePanelSr">${srNo}</td>
            <td><input type="number" class="form-control sidePanelWidth"></td>
            <td><input type="number" class="form-control sidePanelHeight"></td>
            <td><input type="number" class="form-control sidePanelSqft" readonly></td>
            <td>
                <select class="form-control sidePanelCategory">
                    <option value="">Select Category</option>
                    ${options}
                </select>
            </td>
            <td>
                <select class="form-control sidePanelMaterial">
                    <option value="">Select Material</option>
                </select>
            </td>
            <td><input type="number" class="form-control sidePanelPrice" readonly></td>
            <td><button type="button" class="delete-btn removeSidePanel">✕</button>
            </td>
        `;
        tbody.appendChild(row);
        attachSidePanelEvents();
    }
    function attachSidePanelEvents(){
        document
        .querySelectorAll('.sidePanelRow')
        .forEach(row=>{
            row.querySelectorAll('.sidePanelWidth,.sidePanelHeight')
            .forEach(input=>{
                input.oninput=()=>{
                    calculateSidePanelRow(row);
                };
            });
            row.querySelector('.sidePanelCategory')
            .onchange=function(){
                loadSidePanelMaterials(this.value,row);
            };
            row.querySelector('.sidePanelMaterial')
            .onchange=()=>{
                calculateSidePanelRow(row);
            };
        });
    }
    function loadSidePanelMaterials(categoryId,row){
        const material=row.querySelector('.sidePanelMaterial');
        material.innerHTML='<option value="">Select Material</option>';
        visibleSideMaterials
        .filter(mat=>mat.category_id==categoryId)
        .forEach(mat=>{
            material.innerHTML+=`
                <option value="${mat.id}" data-price="${mat.price_per_sqft}">
                    ${mat.material_name}
                </option>
            `;
        });
    }
    function calculateSidePanelRow(row){
        const width=parseFloat(row.querySelector('.sidePanelWidth').value)||0;
        const height=parseFloat(row.querySelector('.sidePanelHeight').value)||0;
        const sqft=(width/304.8)*(height/304.8);
        row.querySelector('.sidePanelSqft').value=sqft.toFixed(2);
        const material=row.querySelector('.sidePanelMaterial');
        const rate=parseFloat(material.selectedOptions[0]?.dataset.price)||0;
        row.querySelector('.sidePanelPrice').value=(sqft*rate).toFixed(2);
        calculateSidePanelGrandTotal();
        updateGrandTotal();
    }
    function calculateSidePanelGrandTotal(){
        let total=0;
        document.querySelectorAll('.sidePanelPrice')
        .forEach(input=>{
            total+=parseFloat(input.value)||0;
        });
        document.getElementById('sidePanelGrandTotal').innerText=total.toFixed(2);
    }
    document.addEventListener('click',function(e){
        if(!e.target.classList.contains('removeSidePanel')) return;
        e.target.closest('tr').remove();
        document.querySelectorAll('.sidePanelSr')
        .forEach((td,index)=>{
            td.innerText=index+1;
        });
        calculateSidePanelGrandTotal();
        updateGrandTotal();
    });
</script>
<?php
$getAccessoryCategories = mysqli_query(
    $conn,
    "
    SELECT *
    FROM accessory_categories
    WHERE status=1
    ORDER BY category_name
    "
);
$accessoryCategoryOptions='';
while($cat=mysqli_fetch_assoc($getAccessoryCategories)){
    $accessoryCategoryOptions .= '<option value="'.$cat['id'].'">' .$cat['category_name']. '</option>';
}
$accessoryCategoryOptions .= '<option value="other">Other</option>'; ?>
<?php include '../includes/footer.php'; ?>