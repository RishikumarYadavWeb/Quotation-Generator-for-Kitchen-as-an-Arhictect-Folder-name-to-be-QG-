<?php
    include '../includes/auth.php';
    include '../db.php';
    /** @var mysqli $conn */
    include '../includes/header.php';
    include '../includes/sidebar.php';
    $created_by = $_SESSION['user_id'];
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
    /* ADDITIONAL ACCESSORIES */
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
        $accessoryOptions .= '
            <option value=\"'.$acc['id'].'\" data-price=\"'.$acc['price'].'\">
                '.$acc['accessory_name'].'
            </option>
        ';
    }
    /* STANDARD ACCESSORIES */
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
        ON standard_accessory_categories.id = standard_accessory_materials.category_id
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
    $categoryQuery = mysqli_query(
        $conn,
        "
        SELECT *
        FROM accessory_categories
        WHERE status = 1
        ORDER BY category_name
        "
    );
    $accessoryCategoryOptions = '';
    while($row = mysqli_fetch_assoc($categoryQuery)){
        $accessoryCategoryOptions .=
            '<option value="'.$row['id'].'">'.
            htmlspecialchars($row['category_name']).
            '</option>';
    }
    // $accessoryCategoryOptions .= '<option value="other">Other</option>';
?>
<form  id="quotationForm" enctype="multipart/form-data" novalidate onkeydown="preventEnterSubmit(event)">
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
                            <select name="entity_id" class="form-control" required >
                                <option value=""> Select Entity </option>
                                <?php
                                    $result = mysqli_query( $conn,
                                        "SELECT *
                                        FROM entities
                                        ORDER BY entity_name"
                                    );
                                    while($row = mysqli_fetch_assoc($result)){
                                ?>
                                    <option value="<?= $row['id']; ?>">
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
                    <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Enter Client Name" >
                </div>
                <div class="col-md-6 mb-3">
                    <label>Project Type</label>
                    <select class="modern-input" id="projectType" name="project_type" onchange="toggleOtherInput()">
                        <option value="Kitchen">Kitchen</option>
                        <option value="Wardrobe">Wardrobe</option>
                        <option value="Bar">Bar</option>
                        <option value="Other">Other</option>
                    </select>
                    <input type="text" id="otherProjectInput" name="other_project_type" class="modern-input mt-3" placeholder="Specify other project type" style="display:none;">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Mobile Number</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Mobile Number">
                </div>
                <div class="col-md-6 mb-3">
                    <label>E-mail Address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter E-Mail Address">
                </div>
            </div>
        </div>
        <div class="main-card mb-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>GST Number</label>
                    <input type="text" name="gst_number" id="gst_number" class="form-control" placeholder="Enter GST Number">
                </div>
                <div class="col-md-6 mb-3">
                    <label>PAN Number</label>
                    <input type="text" name="pan_number" id="pan_number" class="form-control" placeholder="Enter Pan Number">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Billing Address</label>
                    <textarea name="address" id="address" class="form-control" placeholder="Enter Billing Address"></textarea>
                    <div class="mt-2 d-flex">
                        <input type="checkbox" id="sameAddress" onchange="toggleShippingAddress()">
                        <label for="sameAddress" class="mt-2 mx-2">Same As Billing Address</label>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Shipping Address</label>
                    <textarea name="shipping_address" id="shippingAddress" class="form-control" placeholder="Enter Shipping Address"></textarea>
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
                        <button type="button" class="generate-btn" onclick="generateElevations()">
                            Add Elevations
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="elevationContainer"></div>

        <div class="main-card" style="margin-top:30px;">
            <div class="page-header mb-0">
                <div>
                    <h2 class="page-title">Visible Panels / Side Panels</h2>
                </div>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Number Of Panels</label>
                    <input type="number" id="panelCount" class="form-control" min="0" placeholder="Add Number of Panels">
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-primary" onclick="generatePanels()">
                    Generate Panels
                </button>
            </div>
            <div id="panelContainer"></div>
            <div class="card mt-4" style="background:#f8fafc;">
                <h5>Panels Total :₹ <span id="panelGrandTotal">0.00</span></h5>
            </div>
        </div>

        <div class="main-card" style="margin-top:30px;">
            <div class="page-header mb-0">
                <div>
                    <h2 class="page-title">Standard Accessories</h2>
                </div>
            </div>
            <div class="form-group">
                <label>Number Of Standard Accessories</label>
                <input type="number" id="standardAccessoryCount" class="form-control" min="0" placeholder="Add Number of Standard Accessories">
            </div>
            <div style="margin-top:20px;">
                <button type="button" class="btn btn-primary" onclick="generateStandardAccessories()">Generate Standard Accessories </button>
            </div>
            <div id="standardAccessoriesContainer" style="margin-top:25px;"></div>
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
                <label>Number Of Accessories</label>
                <input type="number" id="accessoryCount" class="form-control" min="0" placeholder="Add Number of Additional Accessories">
            </div>
            <div style="margin-top:20px;">
                <button type="button" class="btn btn-primary" onclick="generateAccessories()">Generate Accessories</button>
            </div>
            <div id="accessoriesContainer" style="margin-top:25px;">
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
        <div class="col-md-6 mb-4">
            <label class="form-label">Add : Pkg. & Forwarding & Transport</label>
            <input type="number" step="1000" min="0" id="packingCharge" class="form-control modern-input" value="0" oninput="calculateFinalPricing()">
        </div>
        <div class="col-md-6 mb-4">
            <label class="form-label">Add : Installation</label>
            <input type="number" id="installationCharge" min="0" class="form-control modern-input" value="0" readonly>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <label style=" font-size:18px; font-weight:700;margin-bottom:12px; display:block;">Grand Total</label>
            <input type="text" min="0" id="grandTotal" class="modern-input" readonly style=" font-size:22px; font-weight:700; color:#111827; background:#f8fafc;" >
        </div>
        <div class="col-md-6 mb-4">
            <label class="form-label" style="font-size:18px; font-weight:700; margin-bottom:12px; display:block;">Special Discount (%)</label>
            <input type="number" min="0" step="1" id="specialDiscount" class="form-control modern-input" value="0" oninput="calculateFinalPricing()">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <label class="form-label" style=" font-size:22px; font-weight:700; color:#1e293b;">Final Customer Price</label>
            <input type="text" min="0" id="finalCustomerPrice" class="form-control modern-input" readonly style=" height:70px; font-size:28px; font-weight:700; background:#ecfdf5; color:#15803d; border:2px solid #bbf7d0;">
        </div>
    </div>
</div>
<button type="button" class="generate-btn" style=" max-width:220px; " onclick="saveQuotation()" > Save Quotation </button>
<script>
    const IS_EDIT_PAGE = false;
    const COST_MULTLIER = <?= ($_SESSION['entity_id'] == 2) ? 0.5 : 1 ?>;
    function getCostMultiplier(){
        const entityField = document.getElementById('entity_id');
        if(entityField){
            const selectedEntity =
                entityField.value;
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
    // ----------------------
    // Additional Accessories
    // ----------------------
    const accessoryCategoryOptions = `<?= $accessoryCategoryOptions ?>`;
    function generateAccessories(){
        const count = parseInt(document.getElementById('accessoryCount').value) || 0;
        const container = document.getElementById('accessoriesContainer');
        if(
            !container.querySelector('.accessoriesTable')
        ){
            container.innerHTML = `
                <div class="table-responsive">
                    <table class="table table-bordered accessoriesTable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Category</th>
                                <th>Material</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="accessoriesTableBody">
                        </tbody>
                    </table>
                </div>
            `;
        }
        const tbody = container.querySelector('.accessoriesTableBody');
        const existingRows = tbody.querySelectorAll('tr');
        if(count > existingRows.length){
            for(
                let i = existingRows.length;
                i < count;
                i++
            ){
                tbody.insertAdjacentHTML(
                    'beforeend',
                    `
                    <tr class="accessoryRow">
                        <td class="accessorySrNo" style="display:flex;justify-content:center;align-items:center;">${i + 1}</td>
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
                        <td> <input type="number" step="1" min="0" name="accessory_price[]" class="form-control accessoryPrice" readonly></td>
                        <td> <input type="number" name="accessory_qty[]" class="form-control accessoryQty" value="1" min="1"></td>
                        <td> <input type="number" step="1" name="accessory_total[]" class="form-control accessoryTotal" readonly></td>
                    </tr>
                    `
                );
            }
        }
        else if(count < existingRows.length){
            for(
                let i = existingRows.length;
                i > count;
                i--
            ){
                tbody.lastElementChild.remove();
            }
        }
        attachAccessoryEvents();
        calculateAccessoriesGrandTotal();
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
    // --------------------
    // Standard Accessories
    // --------------------
    const standardAccessoryOptions =`<?= $standardAccessoryOptions ?>`;
    const standardAccessoryCategoryOptions =`<?= $standardAccessoryCategoryOptions ?>`;
    function generateStandardAccessories(){
        const count = parseInt(document.getElementById('standardAccessoryCount').value) || 0;
        const container = document.getElementById('standardAccessoriesContainer');
        if(
            !container.querySelector('.standardAccessoriesTable')
        ){
            container.innerHTML = `
                <div class="table-responsive">
                    <table class=" table table-bordered standardAccessoriesTable">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Category</th>
                                <th>Material</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="standardAccessoriesTableBody">
                        </tbody>
                    </table>
                </div>
            `;
        }
        const tbody = container.querySelector('.standardAccessoriesTableBody');
        const existingRows = tbody.querySelectorAll('tr');
        if(count > existingRows.length){
            for(
                let i = existingRows.length;
                i < count;
                i++
            ){
                tbody.insertAdjacentHTML(
                    'beforeend',
                    `
                    <tr class="standardAccessoryRow">
                        <td data-label="Accessory No:" style="display:flex;justify-content:center;align-items:center;">${i + 1}</td>
                        <td data-label="Category:">
                            <select class="form-control standardAccessoryCategory" onchange="loadStandardAccessoryMaterials(this)">
                                <option value="">
                                    Select Category
                                </option>
                                ${standardAccessoryCategoryOptions}
                            </select>
                        </td>
                        <td data-label="Material:">
                            <select name="standard_accessory_id[]" class=" form-control standardAccessoryMaterial">
                                <option value="">Select Material</option>
                            </select>
                        </td>
                        <td data-label="Unit Price:"><input type="number" step="1" name="standard_accessory_price[]" class=" form-control standardAccessoryPrice" readonly></td>
                        <td data-label="Quantity:"><input type="number" name="standard_accessory_qty[]" class="form-control standardAccessoryQty" value="1" min="1"></td>
                        <td data-label="Total:"><input type="number" step="1" name="standard_accessory_total[]" class="form-control standardAccessoryTotal" readonly></td>
                    </tr>
                    `
                );
            }
        }else if(count < existingRows.length){
            for(
                let i = existingRows.length;
                i > count;
                i--
            ){
                tbody.lastElementChild.remove();
            }
        }
        attachStandardAccessoryEvents();
        calculateStandardAccessoriesGrandTotal();
    }
    function attachStandardAccessoryEvents(){
        document
        .querySelectorAll('.standardAccessorySelect')
        .forEach(select => {
            select.onchange = function(){
                const row = this.closest('tr');
                const price = parseFloat(this.options[this.selectedIndex]?.dataset.price) || 0;
                row.querySelector('.standardAccessoryPrice').value = price.toFixed(2);
                calculateStandardAccessoryTotal(row);
            };
        });
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
        const categoryId = select.value;
        const row = select.closest('tr');
        const materialDropdown = row.querySelector('.standardAccessoryMaterial');
        $.ajax({
            url: BASE_URL + 'ajax/get-standard-accessory-materials.php',
            type:'POST',
            data:{category_id: categoryId},
            success:function(response){
                materialDropdown.innerHTML = '<option value="">Select Material</option>' + response;
            },
            error:function(error){
                console.error('Standard Material Error:',error);
            }
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
    // -------------------------
    // Visible Panel / End Panel
    // -------------------------
    function generatePanels(){
        const count = parseInt(document.getElementById('panelCount').value) || 0;
        const container = document.getElementById('panelContainer');
        const panelShutterCategoryOptions = shutterCategories
            .filter(cat => ![4, 9].includes(parseInt(cat.id)))
            .map(cat => `<option value="${cat.id}">${cat.category_name}</option>`)
            .join('');
        let html = `
        <div class="table-responsive panel-table-responsive">
            <table class="table table-bordered panelTable">
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Width (MM)</th>
                        <th>Height (MM)</th>
                        <th>Sq Ft</th>
                        <th>Shutter Category</th>
                        <th>Shutter Material</th>
                        <th>Panel Price</th>
                    </tr>
                </thead>
                <tbody>
        `;
        for(let i = 1; i <= count; i++){
            html += `
                    <tr class="panelRow">
                        <td>${i}</td>
                        <td><input type="number" min="0" step="1" class="form-control panelWidth"></td>
                        <td><input type="number" min="0" step="1" class="form-control panelHeight"></td>
                        <td><input type="number" class="form-control panelSqft" readonly></td>
                        <td>
                            <select class="form-control panelCategory">
                                <option value="">Select Category</option>
                                ${panelShutterCategoryOptions}
                            </select>
                        </td>
                        <td>
                            <select class="form-control panelMaterial">
                                <option value="">Select Material</option>
                            </select>
                        </td>
                        <td><input type="number" class="form-control panelPrice" readonly></td>
                    </tr>
            `;
        }
        html += `
                </tbody>
            </table>
        </div>
        `;
        container.innerHTML = html;
        attachPanelEvents();
    }
    function attachPanelEvents(){
        document
        .querySelectorAll('.panelRow')
        .forEach(row => {
            row
            .querySelectorAll('.panelWidth,.panelHeight')
            .forEach(input => {
                input.addEventListener('input',() => calculatePanelRow(row));
            });
            row
            .querySelector('.panelCategory')
            .addEventListener(
                'change',
                function(){
                    loadPanelMaterials(this.value,row);
                }
            );
            row
            .querySelector('.panelMaterial')
            .addEventListener(
                'change', () => calculatePanelRow(row)
            );
        });
    }
    function loadPanelMaterials(
        categoryId,
        row
    ){
        const materialSelect = row.querySelector('.panelMaterial');
        materialSelect.innerHTML = '<option value="">Select Material</option>';
        shutterMaterials
        .filter(
            mat => mat.category_id == categoryId
        )
        .forEach(mat => {
            materialSelect.innerHTML += `
                <option value="${mat.id}" data-price="${mat.price_per_sqft}">
                    ${mat.material_type}
                </option>
            `;
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
</script>
<?php include '../includes/footer.php'; ?>