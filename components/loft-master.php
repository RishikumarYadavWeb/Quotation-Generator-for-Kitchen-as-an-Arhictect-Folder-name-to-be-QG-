<?php
    include '../db.php';
    /** @var mysqli $conn */
    $carcassCategoryQuery = mysqli_query(
        $conn,
        "SELECT id, category_name
        FROM carcass_categories
        WHERE status = 1
        ORDER BY category_name ASC"
    );

    $shutterCategoryQuery = mysqli_query(
        $conn,
        "SELECT id, category_name
        FROM shutter_categories
        WHERE status = 1
        ORDER BY category_name ASC"
    );
?>
<style>
.table-responsive{overflow-x:auto}.generated-unit table{min-width:2200px}.generated-unit thead{background:linear-gradient(135deg,#f97316,#ea580c)}.generated-unit th{color:#fff;white-space:nowrap;text-align:center;padding:12px;font-size:13px}.generated-unit td{padding:8px;vertical-align:middle}.generated-unit .modern-input{min-width:140px;width:100%;font-size:13px}.generated-unit select{min-width:220px}
</style>
<div class="generated-unit loft-master">
    <div class="generated-title">Loft Units</div>
    <div id="loftCategoryTemplates" style="display:none;">
        <!-- Loft -->

    <select id="loftCarcassCategoryTemplate">

        <option value="">Select Category</option>

        <?php

        $query = mysqli_query(
            $conn,
            "
            SELECT *
            FROM carcass_categories
            WHERE status=1
            AND category_name LIKE 'Loft%'
            "
        );

        while($row=mysqli_fetch_assoc($query)){

        ?>

            <option value="<?= $row['id'] ?>">
                <?= $row['category_name'] ?>
            </option>

        <?php } ?>

    </select>

        <select id="loftShutterCategoryTemplate">
            <option value="">Select Category</option>
            <?php while($cat = mysqli_fetch_assoc($shutterCategoryQuery)){ ?>
                <option value="<?= $cat['id'] ?>"><?= $cat['category_name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Description</th>
                    <th>Width MM</th>
                    <th>Height MM</th>
                    <th>Depth MM</th>
                    <th>Total Sq.Ft</th>
                    <th>Carcass Category</th>
                    <th>Carcass Material</th>
                    <th>Carcass Amount</th>
                    <th>Shutter Category</th>
                    <th>Shutter Material</th>
                    <th>Shutter Amount</th>
                </tr>
            </thead>
            <tbody class="loftRows">
            </tbody>
        </table>
    </div>

    <?php  include __DIR__ . '/shelf-section.php'; ?>
    <div class="row mt-4">
        <div class="col-md-4">
            <label>Unit Grand Total</label>
            <input type="text" class="modern-input unitGrandTotal" readonly>
        </div>
    </div>
</div>