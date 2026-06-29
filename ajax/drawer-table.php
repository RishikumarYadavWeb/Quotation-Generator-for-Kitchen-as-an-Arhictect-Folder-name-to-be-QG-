<?php
    require '../db.php';
    /** @var mysqli $conn */
    $categoryQuery = mysqli_query(
        $conn,
        "SELECT id, category_name
        FROM drawer_categories
        WHERE status = 1
        ORDER BY category_name ASC"
    );
?>
<style>.modern-input{min-width:140px;width:100%;font-size:13px;}</style>
<div class="table-responsive drawer-table-wrapper">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Assign Unit</th>
                <th>Qty</th>
                <th>Width MM</th>
                <th>Width FT</th>
                <th>Height MM</th>
                <th>Height FT</th>
                <th>Drawer Category</th>
                <th>Drawer Material</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody class="drawerTableBody">
        </tbody>
    </table>
</div>