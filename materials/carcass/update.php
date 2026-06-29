<?php
   include '../../db.php';
   /** @var mysqli $conn */
   $id = (int) ($_POST['id'] ?? 0);
   $category_id = (int) ($_POST['category_id'] ?? 0);
   $material_name = trim($_POST['material_name'] ?? 0);
   $price_per_sqft = (float) ($_POST['price_per_sqft'] ?? 0);
   mysqli_query(
      $conn,
      "UPDATE carcass_materials
      SET
      category_id = '$category_id',
      material_name = '$material_name',
      price_per_sqft = '$price_per_sqft'
      WHERE id = '$id'"
   );
   header('Location: manage.php');
?>