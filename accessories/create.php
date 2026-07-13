<?php
include '../includes/auth.php';
include '../db.php';

if (!can('accessories_create')) {
    die('Access Denied');
}

/** @var mysqli $conn */

include '../includes/header.php';
include '../includes/sidebar.php';

$categories = mysqli_query(
    $conn,
    "
    SELECT id, category_name
    FROM accessory_categories
    WHERE status = 1
    ORDER BY category_name
    "
);

$units = mysqli_query(
    $conn,
    "
    SELECT id, unit_name
    FROM accessory_units
    WHERE status = 1
    ORDER BY unit_name
    "
);
?>

<div class="page-card">

    <div class="page-header">

        <div>
            <h1 class="page-title">Create Accessory Material</h1>
            <p class="page-subtitle">
                Add a new accessory material.
            </p>
        </div>

        <a href="manage.php" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>

    </div>

    <form action="save.php" method="POST">

        <div class="form-grid">

            <div class="form-group">
                <label>Category</label>

                <select
                    name="category_id"
                    id="category_id"
                    class="form-control"
                    required>

                    <option value="">Select Category</option>

                    <?php while($category = mysqli_fetch_assoc($categories)){ ?>

                        <option value="<?= $category['id'] ?>">
                            <?= htmlspecialchars($category['category_name']) ?>
                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="form-group">

                <label>Make</label>

                <select
                    name="make_id"
                    id="make_id"
                    class="form-control"
                    required>

                    <option value="">Select Category First</option>

                </select>

            </div>

            <div class="form-group">

                <label>Material Name</label>

                <input
                    type="text"
                    name="material_name"
                    class="form-control"
                    placeholder="Enter Material Name"
                    required>

            </div>

            <div class="form-group">

                <label>Unit</label>

                <select
                    name="unit_id"
                    class="form-control"
                    required>

                    <option value="">Select Unit</option>

                    <?php while($unit = mysqli_fetch_assoc($units)){ ?>

                        <option value="<?= $unit['id'] ?>">
                            <?= htmlspecialchars($unit['unit_name']) ?>
                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="form-group">

                <label>Price</label>

                <input
                    type="number"
                    name="price"
                    class="form-control"
                    step="0.01"
                    min="0"
                    placeholder="Enter Price"
                    required>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control">

                    <option value="1">Active</option>
                    <option value="0">Inactive</option>

                </select>

            </div>

        </div>

        <div style="margin-top:25px;">

            <button
                type="submit"
                class="btn btn-success">

                <i class="fa-solid fa-floppy-disk"></i>
                Save Material

            </button>

        </div>

    </form>

</div>

<script>

document
.getElementById('category_id')
.addEventListener(
    'change',
    function(){

        let categoryId = this.value;

        fetch(
            'get-makes.php?category_id=' + categoryId
        )
        .then(response => response.text())
        .then(data => {

            document.getElementById('make_id').innerHTML = data;

        });

    }
);

</script>

<?php include '../includes/footer.php'; ?>