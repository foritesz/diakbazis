<?php

// termekek.php

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

// Itt jön a további kód a termékek megjelenítéséhez

 session_start();
include("Product.php");
include("navbar.php");
$product = new Product();
//$categories = $product->getCategories();
$subcategories = $product->getMenucategory();
$totalRecords = $product->getTotalProducts();
$ide=$product->getCategories();

?>

<div class="goods">
  <div class="container-fluid">
    <div class="row content">
      <div class="col-sm-3 sidenav" >
            <div id="mobile-filter">
              <div class="border-bottom pb-2 ml-2">
                
              <h4 id="burgundy">Filters</h4>
            </div>
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
        
        // ... (Egyéb kód a checkbox-ok és URL alapján)
        
             
                            
              echo '<input type="hidden" name="modifiedURL" id="modifiedURL" value="">';
              if (isset($subcategories[$selectedMenuCategory])) {
                  echo '<form method="post" id="search_form">';
                  
                  foreach ($subcategories[$selectedMenuCategory] as $categoryName => $subcategories) {
                      echo '<div class="py-2 border-bottom ml-3">';
                      echo '<button class="collapsible" data-category-name="' . $product->cleanString($categoryName) . '">';
                      echo ucfirst($categoryName) . '</button>';
                      echo '<div class="content1">';
                      echo '<ul class="list-group">';
                      
                      foreach ($subcategories as $key => $subcategory) {
                        $isSubcategoryChecked = (isset($_POST['subcategory']) && in_array($product->cleanString($subcategory), $_POST['subcategory']));
                        $isAlkategoriaSelected = ($product->cleanString($subcategory) == $selectedAlkategoria);
                        $subcategoryCheck = ($isSubcategoryChecked || $isAlkategoriaSelected) ? 'checked="checked"' : '';
            

                      
                          echo '<li class="list-group-item">';
                          echo '<div class="checkbox"><label><input type="checkbox" onclick="clearFilters()" value="' . $product->cleanString($subcategory) . '" ' . @$subcategoryCheck . ' name="subcategory[]" class="sort_rang subcategory" ">';
                          echo ucfirst($subcategory). '</label></div>';
                          echo '</li>';
                      }
                    
                      echo '</ul>';
                      echo '</div>';
                      echo '</div>';
                  }
                  
                  echo '</form>';
              }
              
              echo '<button type="button" name="clearFilters" onclick="clearFilters()">Törlés</button>';
              
              ini_set('display_errors', 1);
              ini_set('display_startup_errors', 1);
              error_reporting(E_ALL);
              //session_destroy();
              


          ?>

          </div>
        </div>
      </div>
    </div>
  </div>
  

  <div class="col-sm-9">
    <div id="results"></div>
  </div>
  
</div>
<input type="hidden" id="totalRecords" value="<?php echo $totalRecords; ?>">
</div>
</div>

</body>
</html>
<script>
const mediaQueryfilter = window.matchMedia('(min-width: 800px)');

function initFilter(event) {
  
  var coll = document.getElementsByClassName("collapsible");
  var i;

  function toggleCollapsible(event) {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight) {
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
    event.preventDefault();
  }

  for (i = 0; i < coll.length; i++) {
    // Eseménykezelő hozzáadása
    coll[i].addEventListener("click", toggleCollapsible);

    // Kezdeti állapot beállítása az ablakméretnek megfelelően
    if (mediaQueryfilter.matches) {
      coll[i].classList.add("active");
      var content = coll[i].nextElementSibling;
      content.style.maxHeight = content.scrollHeight + "px";
    } else {
      coll[i].classList.remove("active");
      var content = coll[i].nextElementSibling;
      content.style.maxHeight = null;
    }
  }
  
}

// Eseménykezelő hozzáadása az ablak betöltésekor


  // Az "initFilter" függvény meghívása az oldal betöltésekor
  initFilter();

  // Eseményfigyelő a médiaképernyő méretének változásához
  //mediaQuery.addListener(initFilter);
  
  // Eseményfigyelő a médiaké
//php-hoz
function updateURL() {
  // Jelenlegi URL lekérése
  let currentURL = window.location.href;

  // Checkbox elemek lekérése
  let checkboxes = document.querySelectorAll('.checkbox input[type="checkbox"]');

  // Ellenőrzés, hogy legalább egy checkbox ki van-e pipálva
  let anyCheckboxChecked = false;

  // Az URL-ből az összes alkategoria eltávolítása
  currentURL = currentURL.replace(/&alkategoria=[^&]*/g, '');

  // Ellenőrzés és alkategoria hozzáadása az URL-hez
  for (let checkbox of checkboxes) {
    if (checkbox.checked) {
      anyCheckboxChecked = true;
      let alkategoriaValue = checkbox.value;
      currentURL += "&alkategoria=" + alkategoriaValue;
    }
  }

  // Ha egyetlen checkbox sem pipálva, akkor az összes alkategoria eltávolítása
  if (!anyCheckboxChecked) {
    currentURL = currentURL.replace(/&alkategoria=[^&]*/g, '');
  }

  // Frissíti az URL-t
  history.replaceState({}, document.title, currentURL);
  document.getElementById("modifiedURL").value = currentURL;
}

// Checkbox változás eseménykezelő hozzárendelése minden checkbox-hoz
let checkboxes = document.querySelectorAll('.checkbox input[type="checkbox"]');
for (let checkbox of checkboxes) {
  checkbox.addEventListener("change", updateURL);
}

// Az oldal betöltésekor inicializálja az URL-t
updateURL();

// URL-ből kiolvasott alkategoria-k
let urlParams = new URLSearchParams(window.location.search);
let alkategoriaFromURL = urlParams.getAll('alkategoria');

// Checkbox-ok kiemelése az URL-ből kiolvasott alkategoria-k alapján
for (let checkbox of checkboxes) {
  if (alkategoriaFromURL.includes(checkbox.value)) {
    checkbox.checked = true;
  }
}

</script>
<script src="ajax.js"></script>