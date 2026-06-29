<?php
    include '../db.php';
    /** @var mysqli $conn */
    /* CARCASS CATEGORIES */
    $carcassCategoryQuery = mysqli_query(
        $conn,
        "
        SELECT
            id,
            category_name
        FROM carcass_categories
        WHERE status = 1
        ORDER BY category_name ASC
        "
    );
    $shutterCategoryQuery = mysqli_query(
        $conn,
        "
        SELECT
            id,
            category_name
        FROM shutter_categories
        WHERE status = 1
        ORDER BY category_name ASC
        "
    );
?>
<div class="generated-title mt-4">Material Details</div>
<div class="row">
    <div class="col-md-3 mb-3">
        <label>Carcass Category</label>
        <select class="modern-input carcassCategory" onchange="loadCarcassMaterials(this)">
            <option value="">Select Category</option>
            <?php while($cat = mysqli_fetch_assoc($carcassCategoryQuery)){ ?>
                <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label>Carcass Material</label>
        <select class="modern-input carcassMaterial" onchange="calculateCarcassPrice(this)">
            <option value="">Select Material</option>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label>Carcass Price/Sq.Ft</label>
        <input type="text" class="modern-input carcassPrice" readonly>
    </div>
</div>
<div class="row">
    <div class="col-md-3 mb-3">
        <label>Shutter Category</label>
        <select class="modern-input shutterCategory" onchange="loadShutterMaterials(this)">
            <option value="">Select Category</option>
            <?php while($cat = mysqli_fetch_assoc($shutterCategoryQuery)){ ?>
                <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label>Shutter Material</label>
        <select class="modern-input shutterSubMaterial" onchange="calculateShutterPrice(this)">
            <option value="">Select Material</option>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label>Shutter Price/Sq.Ft</label>
        <input type="text" class="modern-input shutterPrice" readonly>
    </div>
</div>