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
    background-color: #007bff;
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
    background-color: #00007bff;
}

/* Message styling */
.message {
    display: block;
    background-color: #007bff;
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
$_SESSION['menucategory']=$menucategory;
$alkategoria = isset($_GET['alkategoria']) ? $_GET['alkategoria'] : '';
$_SESSION['alkategoria']=$alkategoria ;

// Include the resizeImage function
function resizeImage($source_image, $destination, $width, $height) {
    list($source_width, $source_height, $source_type) = getimagesize($source_image);
    switch ($source_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_image);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_image);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_image);
            break;
        default:
            return false;
    }
    if ($source_gd_image === false) {
        return false;
    }
    $destination_gd_image = imagecreatetruecolor($width, $height);
    imagecopyresampled($destination_gd_image, $source_gd_image, 0, 0, 0, 0, $width, $height, $source_width, $source_height);
    // Ensure the directory exists and is writable
    if (!is_dir(dirname($destination))) {
        mkdir(dirname($destination), 0755, true);
    }
    if (imagejpeg($destination_gd_image, $destination, 90) === false) {
        return false;
    }
    imagedestroy($source_gd_image);
    imagedestroy($destination_gd_image);
    return true;
}

$id = $_GET['edit'];

if (isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'] ?? '';
    $product_price = $_POST['product_price'] ?? '';
    $product_leiras = $_POST['product_leiras'] ?? '';
    $visible_product = isset($_POST['visible_product']) ? 1 : 0;
    $seasonal = isset($_POST['seasonal']) ? 1 : 0;
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'] ;
    $category_name = $_POST['category_name'] ?? '';  // Check if it's set
    $subcategory = $_POST['subcategory'] ?? '';

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
        $new_image_name = uniqid() . '.jpg';
        $product_image_folder = '../images/' . $new_image_name;
 
        // Resize and save the image
        if (resizeImage($product_image_tmp_name, $product_image_folder, 600, 600)) {
            // Image resized and saved successfully
        } else {
            $message[] = 'A kép átméretezésénél hiba történt!';
        }
    }

    if (!empty($subcategory)) {
        $update_fields[] = "subcategory='$subcategory'";
    }

    // Combine the fields to the update query
    if (!empty($update_fields)) {
        $update_data .= implode(", ", $update_fields) . " WHERE id = '$id'";

        $upload = mysqli_query($conn, $update_data);

        if ($upload) {
            $message[] = 'Termék módosítva!';
        } else {
            //$message[] = 'Could not update the product. Please try again. ' . mysqli_error($conn);
        }
    } else {
        $message[] = 'Hiba történt a módosítás során!';
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
    <h3 class="title">Termék Módosítása</h3>
    
    <label for="product_name">Név</label>
    <input type="text" class="box" id="product_name" name="product_name" value="<?php echo htmlspecialchars($row['product_name']); ?>" placeholder="Enter the product name">
    
    <label for="product_price">Ár</label>
    <input type="number" min="0" class="box" id="product_price" name="product_price" value="<?php echo htmlspecialchars($row['price']); ?>" placeholder="Enter the product price">
    
    <label for="product_leiras">Leírás</label>
    <textarea class="box" id="product_leiras" name="product_leiras" placeholder="Enter the product description"><?php echo htmlspecialchars($row['leiras']); ?></textarea>
    
    <div>
        <input type="checkbox" id="visible_product" name="visible_product" <?php echo $row['visible_product'] ? 'checked' : ''; ?>>
        <label for="visible_product">Elrejtés</label>
    </div>
    
    <div>
        <input type="checkbox" id="seasonal" name="seasonal" <?php echo $row['seasonal'] ? 'checked' : ''; ?> disabled>
        <label for="seasonal">Seasonal</label>
    </div>
    
    <label for="product_image">Kép</label>
    <input type="file" class="box" id="product_image" name="product_image" accept="image/png, image/jpeg, image/jpg">
    
    <label for="subcategory">Alkategória</label>
    <select name="subcategory" class="box">
        <option value="<?php echo $row['subcategory']; ?>" selected="selected"><?php echo $row['subcategory']; ?></option>
        <?php
        $subcategories_query = mysqli_query($conn, "SELECT DISTINCT subcategory FROM categories");
        while ($subcategory_row = mysqli_fetch_assoc($subcategories_query)) {
            if ($subcategory_row['subcategory'] !== $row['subcategory']) {
                echo '<option value="'.$subcategory_row['subcategory'].'">'.$subcategory_row['subcategory'].'</option>';
            }
        }
        ?>
    </select>
    
    <input type="submit" value="Módosítás" name="update_product" class="btn">
    <a href="dashboard.php?cat=product-crud&subcat=admin_page&menucategory=<?php echo urlencode($menucategory); ?>&alkategoria=<?php echo urlencode($alkategoria); ?>" class="btn">Vissza</a>
</form>

    <?php } ?>

    </div>
</div>

</body>
</html>





