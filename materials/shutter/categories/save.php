
<?php
    include '../../../db.php';
    /** @var mysqli $conn */
    $category_name = trim($_POST['category_name'] ?? '');
    /* CHECK DUPLICATE */
    $checkQuery = "SELECT id FROM shutter_categories WHERE category_name='$category_name'";
    $checkResult = mysqli_query($conn, $checkQuery);
    if(mysqli_num_rows($checkResult) > 0){
        echo "
        <script>
            alert('Category already exists');
            window.location='category.php';
        </script>
        ";
        exit;
    }
    /* INSERT */
    $query =
    "INSERT INTO shutter_categories
    (
        category_name
    )
    VALUES
    (
        '$category_name'
    )";
    mysqli_query($conn, $query);
    header("Location: manage.php");
?>