<?php
if (!isset($_GET['kereses']) || empty($_GET['kereses'])) {
    http_response_code(404);
    include('includes/404.php');
    exit();
}

// Itt jön a további kód a keresési eredmények megjelenítéséhez



include("config/Product.php");
include("includes/navbar.php");
include("includes/cookie.php");
$product = new Product();
//$categories = $product->getCategories();
$searchResults = $product->getSearchforIt();
$totalRecords = $product->getTotalProducts();
$ide=$product->getSearchforIt();

?>

<div class="content">
    <div class="filter">
            <?php
        
        
              $kereset = $_GET['kereses'];
              $selectedAlkategoria = isset($_GET['alkategoria']) ? $_GET['alkategoria'] : '';
              echo "A keresett érték: " . $kereset;
              $_SESSION['kereset'] = $kereset;
             

              
              if (!empty($searchResults)&&!empty($kereset)) {
                //echo '<form method="post" id="search_form">';
            
                foreach ($searchResults as $categoryName => $subcategories) {
                  echo '<div>';
                  echo '<div>';
                  echo '<h3 onclick="toggleCategory(\'' . $product->cleanString($categoryName) . '\')">' . ucfirst($categoryName) . '</h3>';
                  echo '<div class="subcategory" id="' . $product->cleanString($categoryName) . '">';
                  
                  foreach ($subcategories as $key => $subcategory) {
                      $isSubcategoryChecked = (isset($_POST['subcategory']) && in_array($product->cleanString($subcategory), $_POST['subcategory']));
                      $isAlkategoriaSelected = ($product->cleanString($subcategory) == $selectedAlkategoria);
                      $subcategoryCheck = ($isSubcategoryChecked || $isAlkategoriaSelected) ? 'checked="checked"' : '';
              
                      echo '<label><input type="checkbox" onclick="clearFilters()" value="' . $product->cleanString($subcategory) . '" ' . @$subcategoryCheck . ' name="subcategory[]" class="sort_rang subcategory">' . ucfirst($subcategory) . '</label><br>';
                  }
              
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
            }
          }
            else
            {
              echo " <br>Nincs ilyen termék!";
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

<?php include("includes/footer.php"); ?>
<script>

</script>
<script>
$(document).ready(function() {
    setCheckboxesFromUrl();
    
    // Attach event listener to checkboxes to update URL when their state changes
    $('input:checkbox').on('change', function() {
        clearFilters();
    });
});

function clearFilters() {
    var checkedValues = [];
    
    $('input:checkbox').each(function() {
        if ($(this).prop('checked')) {
            // If a checkbox is checked, add its value to the list
            checkedValues.push($(this).val());
        }
    });
    
    // Update the URL with the selected checkboxes and refresh the page
    var newUrl = updateUrl('alkategoria', checkedValues);
    window.location.href = newUrl; // This will reload the page with the updated URL
}

// Function to add or update the alkategoria parameters in the URL
function updateUrl(key, values) {
    var currentUrl = window.location.href;
    var urlParts = currentUrl.split('?');
    var baseUrl = urlParts[0];
    var queryParams = urlParts.length > 1 ? urlParts[1].split('&') : [];

    // Filter out existing alkategoria parameters
    queryParams = queryParams.filter(param => !param.startsWith(key + '='));

    // Add new alkategoria parameters for each value
    values.forEach(value => {
        queryParams.push(key + '=' + value);
    });

    return baseUrl + (queryParams.length > 0 ? '?' + queryParams.join('&') : '');
}

// Function to get URL parameter values by key
function getUrlParameterValues(key) {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.getAll(key);
}

// Function to set checkboxes based on URL parameters
function setCheckboxesFromUrl() {
    var alkategoriaValues = getUrlParameterValues('alkategoria');
    if (alkategoriaValues.length > 0) {
        $('input:checkbox').each(function() {
            if (alkategoriaValues.includes($(this).val())) {
                $(this).prop('checked', true);
            }
        });
    }
}



</script>
<script src="../public/assets/js/ajax.js"></script>