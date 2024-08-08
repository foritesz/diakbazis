<style>
/* Reset some basic styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

/* Set the body background color and text color */
body {
    background-color: #f4f4f4;
    color: #333;
    font-size: 16px;
    line-height: 1.6;
}

/* Container for the form */
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

/* Center the form in the middle of the page */
.admin-product-form-container {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 900px;
    width: 100%;
}

/* Style the form title */
.title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    text-align: center;
}

/* Style for labels */
label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

/* Style the input boxes and textarea */
.box {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    resize: vertical; /* Allow vertical resizing, but not horizontal */
}

/* Additional styles for textarea specifically */
textarea.box {
    height: 150px; /* You can adjust the height as needed */
}


/* Style checkboxes and their labels */
input[type="checkbox"] {
    margin-right: 10px;
    transform: scale(1.2);
}

/* Style the submit button */
.btn {
    display: inline-block;
    background-color: #5cb85c;
    color: #fff;
    padding: 10px 20px;
    text-align: center;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    font-size: 16px;
    margin-top: 10px;
    border: none;
    transition: background-color 0.3s ease;
}

/* Hover effect for buttons */
.btn:hover {
    background-color: #4cae4c;
}

/* Message styling */
.message {
    display: block;
    background-color: #5cb85c;
    color: #fff;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
    text-align: center;
}

/* Flexbox for centering checkboxes and labels */
.admin-product-form-container div {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

/* Adjust the form layout for smaller screens */
@media (max-width: 500px) {
    .admin-product-form-container {
        padding: 20px;
    }
    .title {
        font-size: 20px;
    }
    .box, .btn {
        font-size: 14px;
    }
}

</style>
<?php

@include 'config.php';

$menucategory = isset($_GET['menucategory']) ? $_GET['menucategory'] : '';
$alkategoria = isset($_GET['alkategoria']) ? $_GET['alkategoria'] : '';

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
    }/*
    if (!empty($category_name)) {
        $update_fields[] = "category_name='$category_name'";
    }*/
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
    
    <label for="product_name">Product Name</label>
    <input type="text" class="box" id="product_name" name="product_name" value="<?php echo $row['product_name']; ?>" placeholder="Enter the product name">
    
    <label for="product_price">Product Price</label>
    <input type="number" min="0" class="box" id="product_price" name="product_price" value="<?php echo $row['price']; ?>" placeholder="Enter the product price">
    
    <label for="product_leiras">Product Description</label>
    <textarea class="box" id="product_leiras" name="product_leiras" placeholder="Enter the product description"><?php echo $row['leiras']; ?></textarea>
    
    <div>
        <input type="checkbox" id="visible_product" name="visible_product" <?php echo $row['visible_product'] ? 'checked' : ''; ?>>
        <label for="visible_product">Visible</label>
    </div>
    
    <div>
        <input type="checkbox" id="seasonal" name="seasonal" <?php echo $row['seasonal'] ? 'checked' : ''; ?>>
        <label for="seasonal">Seasonal</label>
    </div>
    
    <label for="product_image">Product Image</label>
    <input type="file" class="box" id="product_image" name="product_image" accept="image/png, image/jpeg, image/jpg">
    
    <label for="subcategory">Subcategory</label>
    <input type="text" class="box" id="subcategory" name="subcategory" value="<?php echo $row['subcategory']; ?>" placeholder="Enter the subcategory">
    
    <input type="submit" value="Update Product" name="update_product" class="btn">
    <a href="dashboard.php?cat=product-crud&subcat=admin_page&menucategory=<?php echo urlencode($menucategory); ?>&alkategoria=<?php echo urlencode($alkategoria); ?>" class="btn">Go Back!</a>
</form>


    <?php } ?>

    </div>
</div>

</body>
</html>
