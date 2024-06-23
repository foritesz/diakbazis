<?php
// Ellenőrizzük a menucategory paramétert
if (!isset($_GET['menucategory']) || empty($_GET['menucategory'])) {
    http_response_code(404);
    include('404.php');
    exit();
}

// Ellenőrizzük az alkategoria paramétert
if (empty($_GET['alkategoria']) && empty($_GET['menucategory'])) {
    http_response_code(404);
    include('404.php');
    exit();
}

session_start();
include("Product.php");
include("navbar.php");
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

<script src="filter.js"></script>
<script src="ajax.js"></script>
