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
<div id="loadMoreContainer">
    <button id="loadMoreButton" style="display:none;">Load More</button>
</div>

<script>
$(document).ready(function() {
    var totalRecord = 0;
    var totalData = $("#totalRecords").val();
    var loading = false;

    function loadProducts() {
        var subcategory = getCheckboxValues('subcategory');
        var search = $("#myInput").val();

        $.ajax({
            type: 'POST',
            url: "load_products.php",
            dataType: "json",
            data: {
                totalRecord: totalRecord,
                subcategory: subcategory,
                search: search
            },
            beforeSend: function() {
                $("#loadMoreButton").text("Loading...").prop("disabled", true);
            },
            success: function(data) {
                $("#results").append(data.products);
                $(".skeleton").removeClass("skeleton"); // Remove the skeleton class
                totalRecord++;
                loading = false;
                if (totalRecord >= totalData) {
                    $("#loadMoreButton").hide();
                } else {
                    $("#loadMoreButton").show().text("Load More").prop("disabled", false);
                }
            },
            error: function() {
                $("#loadMoreButton").text("Load More").prop("disabled", false);
            }
        });
    }

    $('#searchForm').submit(function(e) {
        e.preventDefault();

        totalRecord = 0;
        $("#results").empty();
        loadProducts();
    });

    $("#loadMoreButton").click(function() {
        if (!loading && totalRecord < totalData) {
            loading = true;
            loadProducts();
        }
    });

    loadProducts();

    function getCheckboxValues(checkboxClass) {
        var values = [];
        $("." + checkboxClass + ":checked").each(function() {
            values.push($(this).val());
        });
        return values;
    }

    $('.sort_rang').change(function() {
        $("#search_form").submit();
        return false;
    });
});
</script>

<script src="filter.js"></script>

