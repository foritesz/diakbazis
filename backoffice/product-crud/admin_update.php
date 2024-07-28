<?php

@include 'config.php';

$id = $_GET['edit'];

if (isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_leiras = $_POST['product_leiras'];
    $visible_product = isset($_POST['visible_product']) ? 1 : 0;
    $seasonal = isset($_POST['seasonal']) ? 1 : 0;
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image;
    $category_name = $_POST['category_name'];
    $subcategory = $_POST['subcategory'];

    // Initialize the update query
    $update_data = "UPDATE products SET ";

    // Add fields to update only if they are not empty
    $update_fields = [];
    if (!empty($product_name)) {
        $update_fields[] = "product_name='$product_name'";
    }
    if (!empty($product_price)) {
        $update_fields[] = "price='$product_price'";
    }
    if (!empty($product_leiras)) {
        $update_fields[] = "leiras='$product_leiras'";
    }
    $update_fields[] = "visible_product='$visible_product'";
    $update_fields[] = "seasonal='$seasonal'";
    if (!empty($product_image)) {
        $update_fields[] = "kepek='$product_image'";
    }
    if (!empty($category_name)) {
        $update_fields[] = "category_name='$category_name'";
    }
    if (!empty($subcategory)) {
        $update_fields[] = "subcategory='$subcategory'";
    }

    // Combine the fields to the update query
    if (!empty($update_fields)) {
        $update_data .= implode(", ", $update_fields) . " WHERE id = '$id'";

        $upload = mysqli_query($conn, $update_data);

        if ($upload) {
            if (!empty($product_image)) {
                move_uploaded_file($product_image_tmp_name, $product_image_folder);
            }
            $message[] = 'Product updated successfully!';
        } else {
            $message[] = 'Could not update the product. Please try again.' . mysqli_error($conn);
        }
    } else {
        $message[] = 'No fields to update.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Update Product</title>
</head>
<body>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<span class="message">' . $msg . '</span>';
    }
}
?>

<div class="container">
    <div class="admin-product-form-container centered">

    <?php
    $select = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    while ($row = mysqli_fetch_assoc($select)) {
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <h3 class="title">Update the Product</h3>
        <input type="text" class="box" name="product_name" value="<?php echo $row['product_name']; ?>" placeholder="Enter the product name">
        <input type="number" min="0" class="box" name="product_price" value="<?php echo $row['price']; ?>" placeholder="Enter the product price">
        <textarea class="box" name="product_leiras" placeholder="Enter the product description"><?php echo $row['leiras']; ?></textarea>
        <div>
            <input type="checkbox" name="visible_product" id="visible_product" <?php echo $row['visible_product'] ? 'checked' : ''; ?>>
            <label for="visible_product">Visible</label>
        </div>
        <div>
            <input type="checkbox" name="seasonal" id="seasonal" <?php echo $row['seasonal'] ? 'checked' : ''; ?>>
            <label for="seasonal">Seasonal</label>
        </div>
        <input type="file" class="box" name="product_image" accept="image/png, image/jpeg, image/jpg">
        <input type="text" class="box" name="category_name" value="<?php echo $row['category_name']; ?>" placeholder="Enter the category name">
        <input type="text" class="box" name="subcategory" value="<?php echo $row['subcategory']; ?>" placeholder="Enter the subcategory">
        <input type="submit" value="Update Product" name="update_product" class="btn">
        <a href="dashboard.php?cat=product-crud&subcat=admin_page" class="btn">Go Back!</a>
    </form>

    <?php } ?>

    </div>
</div>

</body>
</html>
