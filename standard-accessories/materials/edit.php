<?php
include '../../includes/auth.php';
include '../../db.php';
/** @var mysqli $conn */
include '../../includes/header.php';
include '../../includes/sidebar.php';


$id = (int)($_GET['id'] ?? 0);

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM standard_accessory_materials
    WHERE id='$id'
    "
);

$row = mysqli_fetch_assoc($query);

$categories = mysqli_query(
    $conn,
    "
    SELECT *
    FROM standard_accessory_categories
    WHERE status = 1
    ORDER BY category_name ASC
    "
);
?>

<div class="page-card">

    <div class="page-header">
        <h1>Edit Standard Accessory Material</h1>
    </div>

    <form action="update.php" method="POST">

        <input
            type="hidden"
            name="id"
            value="<?= $row['id'] ?>"
        >

        <div class="form-grid">

            <div class="form-group">

                <label>Category</label>

                <select
                    name="category_id"
                    class="form-control"
                    required
                >

                    <option value="">
                        Select Category
                    </option>

                    <?php while($category = mysqli_fetch_assoc($categories)){ ?>

                        <option
                            value="<?= $category['id'] ?>"
                            <?= $category['id'] == $row['category_id']
                                ? 'selected'
                                : '' ?>
                        >
                            <?= htmlspecialchars(
                                $category['category_name']
                            ) ?>
                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="form-group">

                <label>Material Name</label>

                <input
                    type="text"
                    name="material_name"
                    class="form-control"
                    value="<?= htmlspecialchars(
                        $row['material_name']
                    ) ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label>Unit</label>

                <select
                    name="unit"
                    class="form-control"
                    required
                >

                    <option
                        value="Nos"
                        <?= $row['unit'] == 'Nos'
                            ? 'selected'
                            : '' ?>
                    >
                        Nos
                    </option>

                    <option
                        value="Meter"
                        <?= $row['unit'] == 'Meter'
                            ? 'selected'
                            : '' ?>
                    >
                        Meter
                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>Price</label>

                <input
                    type="number"
                    step=".01"
                    name="price"
                    class="form-control"
                    value="<?= $row['price'] ?>"
                    required
                >

            </div>

        </div>

        <button class="theme-btn">
            Update Material
        </button>

    </form>

</div>

<?php include '../../includes/footer.php'; ?>