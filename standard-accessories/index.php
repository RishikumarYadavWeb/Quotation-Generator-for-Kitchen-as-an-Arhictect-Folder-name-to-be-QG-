<?php

include '../includes/auth.php';
include '../db.php';
/** @var mysqli $conn */
include '../includes/header.php';
include '../includes/sidebar.php';

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM standard_accessory_categories
    ORDER BY id ASC
    "
);

?>

<div class="page-card">

    <div class="page-header">

        <h1>
            Standard Accessory Categories
        </h1>

        <a
            href="create-category.php"
            class="theme-btn"
        >
            Add Category
        </a>

    </div>

    <table class="custom-table">

        <thead>

            <tr>

                <th>Sr No</th>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>

            </tr>

        </thead>

        <tbody>

        <?php

        $srNo=1;

        while(
            $row=
            mysqli_fetch_assoc($query)
        ){

        ?>

            <tr>

                <td><?= $srNo++ ?></td>

                <td>
                    <?= $row['category_name'] ?>
                </td>

                
                        <td>
                            <?php if($row['status'] == 1){ ?>
                                <span class="status-active">Active</span>
                            <?php }else{ ?>
                                <span class="status-inactive">Inactive</span>
                            <?php } ?>
                        </td>

                <td>

                    <a
                        href="edit-category.php?id=<?= $row['id'] ?>"
                        class="edit-btn"
                    >
                        Edit
                    </a>

                    <a
                        href="delete-category.php?id=<?= $row['id'] ?>"
                        class="delete-btn"
                    >
                        Delete
                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

<?php include '../includes/footer.php'; ?>