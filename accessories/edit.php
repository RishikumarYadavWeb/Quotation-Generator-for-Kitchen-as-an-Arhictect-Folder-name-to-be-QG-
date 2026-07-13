<?php
include '../includes/auth.php';
include '../db.php';

/** @var mysqli $conn */

if (!can('accessories_edit')) {
    die('Access Denied');
}

$id = (int)($_GET['id'] ?? 0);

$get = mysqli_query(
    $conn,
    "
    SELECT *
    FROM accessories
    WHERE id = '$id'
    LIMIT 1
    "
);

$data = mysqli_fetch_assoc($get);

if (!$data) {
    die('Accessory Not Found');
}

$categories = mysqli_query(
    $conn,
    "
    SELECT *
    FROM accessory_categories
    WHERE status = 1
    ORDER BY category_name ASC
    "
);

$makes = mysqli_query(
    $conn,
    "
    SELECT *
    FROM accessory_makes
    WHERE
        category_id = '{$data['category_id']}'
        AND status = 1
    ORDER BY make_name ASC
    "
);

$units = mysqli_query(
    $conn,
    "
    SELECT *
    FROM accessory_units
    WHERE status = 1
    ORDER BY unit_name ASC
    "
);

include '../includes/header.php';
include '../includes/sidebar.php';
?>

<div class="page-card">

    <div class="page-header">

        <div>
            <h1 class="page-title">Edit Accessory</h1>
            <p class="page-subtitle">
                Update accessory details.
            </p>
        </div>

        <a href="manage.php" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>

    </div>

    <form action="update.php" method="POST">

        <input
            type="hidden"
            name="id"
            value="<?= $data['id'] ?>">

        <div class="form-grid">

            <div class="form-group">

                <label>Category</label>

                <select
                    name="category_id"
                    id="category_id"
                    class="form-control"
                    required>

                    <option value="">Select Category</option>

                    <?php while($category=mysqli_fetch_assoc($categories)){ ?>

                        <option
                            value="<?= $category['id'] ?>"
                            <?= $category['id']==$data['category_id'] ? 'selected' : '' ?>>

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

                    <?php while($make=mysqli_fetch_assoc($makes)){ ?>

                        <option
                            value="<?= $make['id'] ?>"
                            <?= $make['id']==$data['make_id'] ? 'selected' : '' ?>>

                            <?= htmlspecialchars($make['make_name']) ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="form-group">

                <label>Accessory Name</label>

                <input
                    type="text"
                    name="material_name"
                    class="form-control"
                    value="<?= htmlspecialchars($data['material_name']) ?>"
                    required>

            </div>

            <div class="form-group">

                <label>Unit</label>

                <select
                    name="unit_id"
                    class="form-control"
                    required>

                    <?php while($unit=mysqli_fetch_assoc($units)){ ?>

                        <option
                            value="<?= $unit['id'] ?>"
                            <?= $unit['id']==$data['unit_id'] ? 'selected' : '' ?>>

                            <?= htmlspecialchars($unit['unit_name']) ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="form-group">

                <label>Price</label>

                <input
                    type="number"
                    step="0.01"
                    name="price"
                    class="form-control"
                    value="<?= $data['price'] ?>"
                    required>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control">

                    <option
                        value="1"
                        <?= $data['status']==1 ? 'selected' : '' ?>>
                        Active
                    </option>

                    <option
                        value="0"
                        <?= $data['status']==0 ? 'selected' : '' ?>>
                        Inactive
                    </option>

                </select>

            </div>

        </div>

        <div style="margin-top:25px;">

            <button
                type="submit"
                class="btn btn-success">

                <i class="fa-solid fa-pen-to-square"></i>

                Update Accessory

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

        fetch(
            'get-makes.php?category_id=' + this.value
        )
        .then(response => response.text())
        .then(data => {

            document.getElementById('make_id').innerHTML = data;

        });

    }
);

</script>

<?php include '../includes/footer.php'; ?>