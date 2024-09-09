<?php
$menucategory = isset($_GET['menucategory']) ? $_GET['menucategory'] : '';
$alkategoria = isset($_GET['alkategoria']) ? $_GET['alkategoria'] : '';
$_SESSION['menucategory'] = $menucategory;
$_SESSION['alkategoria'] = $alkategoria;

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
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
    $category_name = trim($_POST['category_name']);  // Szóközök eltávolítása
    $subcategory = trim($_POST['subcategory']);
    $product_name = trim($_POST['product_name']);
    $product_leiras = trim($_POST['product_leiras']);
    $product_price = $_POST['product_price'];
    $visible_product = isset($_POST['visible_product']) ? 1 : 0;
    $seasonal = isset($_POST['seasonal']) ? 1 : 0;
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];

    $new_image_name = uniqid() . '.jpg';
    $product_image_folder = '../images/' . $new_image_name;

    if (empty($product_name) || empty($product_image) || empty($subcategory)) {
        $message[] = 'Töltse ki a "*" jelölt mezőket.';
    } else {
        $insert = "INSERT INTO products(product_name, price, kepek, subcategory, visible_product, seasonal, leiras) 
                   VALUES('$product_name', '$product_price', '$new_image_name', '$subcategory', '$visible_product', '$seasonal', '$product_leiras')";
        $upload = mysqli_query($conn, $insert);

        if ($upload) {
            if (resizeImage($product_image_tmp_name, $product_image_folder, 600, 600)) {
                $message[] = 'Új termék felvéve!';
            } else {
                $message[] = 'Hiba a kép feltöltése során.';
            }
        } else {
            $message[] = 'Hiba a felvétel során! Error: ' . mysqli_error($conn);
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header('location:admin_page.php');
}

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
<h3>Termék felvétele</h3>
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
   <input type="text" placeholder="Termék neve *" name="product_name" class="box" value="<?php echo isset($product_name) ? $product_name : ''; ?>">
   <textarea class="box" id="product_leiras" name="product_leiras" placeholder="Termék leírása *"><?php echo isset($product_leiras) ? $product_leiras : ''; ?></textarea>
   <input type="number" placeholder="Termék ára" name="product_price" class="box" value="<?php echo isset($product_price) ? $product_price : ''; ?>">
   <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
   <div>
       <input type="checkbox" name="visible_product" id="visible_product" <?php echo isset($visible_product) && $visible_product ? 'checked' : ''; ?>>
       <label for="visible_product">Elrejtés</label>
   </div>
   <div>
       <input type="checkbox" name="seasonal" id="seasonal" <?php echo isset($seasonal) && $seasonal ? 'checked' : ''; ?>>
       <label for="seasonal">Szezonális</label>
   </div>
   <input type="submit" class="btn" name="add_product" value="Termék felvétele">
</form>

</div>

  

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.subcategory');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateURL();
        });
    });

    function updateURL() {
        const selectedCheckboxes = document.querySelectorAll('.subcategory:checked');
        let params = new URLSearchParams(window.location.search);
        params.delete('alkategoria'); // Remove existing 'alkategoria' params

        selectedCheckboxes.forEach(checkbox => {
            params.append('alkategoria', checkbox.value);
        });

        const newURL = `${window.location.pathname}?${params.toString()}`;
        window.location.href = newURL;
    }

    // Retain the checkbox state on page load
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.getAll('alkategoria').forEach(value => {
        const checkbox = document.querySelector(`.subcategory[value="${value}"]`);
        if (checkbox) {
            checkbox.checked = true;
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
$menucategory = isset($_GET['menucategory']) ? $_GET['menucategory'] : '';
$alkategoria = isset($_GET['alkategoria']) ? $_GET['alkategoria'] : '';


        $selectedMenuCategory = $_GET['menucategory'];
        $selectedAlkategoria = isset($_GET['alkategoria']) ? $_GET['alkategoria'] : '';

        $modifiedURL = isset($_POST['modifiedURL']) ? $_POST['modifiedURL'] : '';

        echo "A keresett érték: " . $selectedMenuCategory;
        $_SESSION['selectedMenuCategory'] = $selectedMenuCategory;

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

<script src="assets/js/filter_admin.js"></script>
<script src="assets/js/ajax_admin.js"></script>
