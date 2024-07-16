<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
@include 'config.php';



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
    }
    if ($source_gd_image === false) {
        return false;
    }
    $destination_gd_image = imagecreatetruecolor($width, $height);
    imagecopyresampled($destination_gd_image, $source_gd_image, 0, 0, 0, 0, $width, $height, $source_width, $source_height);
    imagejpeg($destination_gd_image, $destination, 90);
    imagedestroy($source_gd_image);
    imagedestroy($destination_gd_image);
    return true;
}

if (isset($_POST['add_product'])) {
    $category_name = $_POST['category_name'];
    $subcategory = $_POST['subcategory'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $visible_product = isset($_POST['visible_product']) ? 1 : 0;
    $seasonal = isset($_POST['seasonal']) ? 1 : 0;
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];

    // Automatically generate a new name for the image file
    $new_image_name = uniqid() . '.jpg';
    $product_image_folder = 'C:/AppServ/www/diakbazis/images/' . $new_image_name;

    if (empty($product_name) || empty($product_price) || empty($product_image) || empty($subcategory)) {
        $message[] = 'Please fill out all fields.';
    } else {
        $insert = "INSERT INTO products(product_name, price, kepek, subcategory, visible_product, seasonal) VALUES('$product_name', '$product_price', '$new_image_name', '$subcategory', '$visible_product', '$seasonal')";
        $upload = mysqli_query($conn, $insert);

        if ($upload) {
            // Resize the image and save it
            if (resizeImage($product_image_tmp_name, $product_image_folder, 600, 600)) {
                $message[] = 'New product added successfully.';
            } else {
                $message[] = 'Could not resize and upload the product image.';
            }
        } else {
            $message[] = 'Could not add the product. Error: ' . mysqli_error($conn);
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header('location:admin_page.php');
}

// Fetch categories and subcategories for the dropdowns
$categories_result = mysqli_query($conn, "SELECT DISTINCT category_name FROM categories");
$subcategories_result = mysqli_query($conn, "SELECT category_name, subcategory FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>admin page</title>
<!-- custom css file link  -->
<link rel="stylesheet" href="product-crud/style.css">
</head>
<body>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<span class="message">'.$msg.'</span>';
    }
}
?>

<div class="container">

<div class="admin-product-form-container">

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
<h3>add a new product</h3>
   <select name="category_name" id="category_name" class="box">
      <option value="" selected="selected">Fő kategória</option>
      <?php while ($row = mysqli_fetch_assoc($categories_result)) { ?>
         <option value="<?php echo $row['category_name']; ?>"><?php echo $row['category_name']; ?></option>
      <?php } ?>
   </select>
   <select name="subcategory" id="subcategory" class="box">
      <option value="" selected="selected">Alkategória</option>
      <?php while ($row = mysqli_fetch_assoc($subcategories_result)) { ?>
         <option value="<?php echo $row['subcategory']; ?>" data-category="<?php echo $row['category_name']; ?>"><?php echo $row['subcategory']; ?></option>
      <?php } ?>
   </select>
   <input type="text" placeholder="enter product name" name="product_name" class="box">
   <input type="number" placeholder="enter product price" name="product_price" class="box">
   <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
   <div>
       <input type="checkbox" name="visible_product" id="visible_product">
       <label for="visible_product">Visible</label>
   </div>
   <div>
       <input type="checkbox" name="seasonal" id="seasonal">
       <label for="seasonal">Seasonal</label>
   </div>
   <input type="submit" class="btn" name="add_product" value="add product">
</form>

</div>

   <?php
   $select = mysqli_query($conn, "SELECT * FROM products");
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>product image</th>
            <th>product name</th>
            <th>product price</th>
            <th>visible</th>
            <th>seasonal</th>
            <th>action</th>
         </tr>
         </thead>
         <?php while ($row = mysqli_fetch_assoc($select)) { ?>
         <tr>
            <td><img src="uploaded_img/<?php echo $row['kepek']; ?>" height="100" alt=""></td>
            <td><?php echo $row['product_name']; ?></td>
            <td>$<?php echo $row['price']; ?>/-</td>
            <td><?php echo $row['visible_product'] ? 'Yes' : 'No'; ?></td>
            <td><?php echo $row['seasonal'] ? 'Yes' : 'No'; ?></td>
            <td>
               <a href="dashboard.php?cat=product-crud&subcat=admin_update&edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
               <a href="dashboard.php?cat=product-crud&subcat=admin_page&delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
            </td>
         </tr>
         <?php } ?>
      </table>
   </div>

</div>

</body>
</html>
<script>
   document.getElementById('category_name').addEventListener('change', function () {
      var category = this.value;
      var subcategorySelect = document.getElementById('subcategory');
      var options = subcategorySelect.querySelectorAll('option');
      options.forEach(function (option) {
         if (option.getAttribute('data-category') === category || option.value === "") {
            option.style.display = 'block';
         } else {
            option.style.display = 'none';
         }
      });
   });
</script>
<?php


$product = new Product();
$subcategories = $product->getMenucategory();
$totalRecords = $product->getTotalProducts();
$ide = $product->getCategories();

?>
<div class="content">
    <div class="filter">
<?php
        $selectedMenuCategory = $_GET['menucategory'];
        $selectedAlkategoria = isset($_GET['alkategoria']) ? $_GET['alkategoria'] : '';

        // Új sor: Beolvasás a rejtett input mezőből
        $modifiedURL = isset($_POST['modifiedURL']) ? $_POST['modifiedURL'] : '';

        echo "A keresett érték: " . $selectedMenuCategory;
        $_SESSION['selectedMenuCategory'] = $selectedMenuCategory;

        // A módosított URL alapján dolgozz tovább
        parse_str(parse_url($modifiedURL, PHP_URL_QUERY), $modifiedParams);
        $selectedAlkategoria = isset($modifiedParams['alkategoria']) ? $modifiedParams['alkategoria'] : $selectedAlkategoria;

        echo '<input type="hidden" name="modifiedURL" id="modifiedURL" value="">';
        if (isset($subcategories[$selectedMenuCategory])) {
            echo '<form method="post" id="search_form">';

            echo '<div class="filterek">';

            foreach ($subcategories[$selectedMenuCategory] as $categoryName => $subcategories) {
                echo '<h3 onclick="toggleCategory(\'' . $product->cleanString($categoryName) . '\')">' . ucfirst($categoryName) . '</h3>';
                echo '<div class="subcategory skeleton" id="' . $product->cleanString($categoryName) . '">';

                foreach ($subcategories as $key => $subcategory) {
                    $isSubcategoryChecked = (isset($_POST['subcategory']) && in_array($product->cleanString($subcategory), $_POST['subcategory']));
                    $isAlkategoriaSelected = ($product->cleanString($subcategory) == $selectedAlkategoria);
                    $subcategoryCheck = ($isSubcategoryChecked || $isAlkategoriaSelected) ? 'checked="checked"' : '';

                    echo '<label><input type="checkbox" onclick="updateURL()" value="' . $product->cleanString($subcategory) . '" ' . $subcategoryCheck . ' name="subcategory[]" class="sort_rang subcategory">' . ucfirst($subcategory) . '</label><br>';
                }

                echo '</div>';
            }

            echo '</div>';
            echo '</form>';
        }
?>

    </div>
    <div class="products" id="results">
    </div>
</div>
<input type="hidden" id="totalRecords" value="<?php echo $totalRecords; ?>">
<div id="loadMoreContainer">
    <button id="loadMoreButton" style="display:none;">Load More</button>
</div>

<script src="../filter.js"></script>
<script src="../ajax.js"></script>