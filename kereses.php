<?php

// kereses.php

// Ellenőrizzük a keresés paramétert
if (!isset($_GET['kereses']) || empty($_GET['kereses'])) {
    http_response_code(404);
    include('404.php');
    exit();
}

// Itt jön a további kód a keresési eredmények megjelenítéséhez


session_start();
include("Product.php");
include("navbar.php");
$product = new Product();
//$categories = $product->getCategories();
$searchResults = $product->getSearchforIt();
$totalRecords = $product->getTotalProducts();
$ide=$product->getCategories();

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .goods {
      margin-top: 50px;
      margin-bottom: 50px;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
      position: relative;
    }
    .col-sm-9{
     width: 80%;
     float: right;
     position: relative;
    }

    @media (max-width: 800px) {
      .col-sm-9{
    width: 100%;
    float: none;
  }
}

    .col-sm-3{
      width: 20%; 
      position: fixed;

      
    }

    @media (max-width: 800px) {
      .col-sm-3{
    width: 100%;
    position: relative;
  }
}


/*.clearfix:after {
  content: "";
  display: table;
  clear: both;
}*/
.mobil-filter{
 
}
.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
 
}

@media (max-width: 800px) {
  button.dropbtn{
    width: 100%;
  }
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #3e8e41;
}

#myInput {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}

#myInput:focus {outline: 3px solid #ddd;}



.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
  min-width: 230px;
  overflow: auto;
  border: 1px solid #ddd;
  z-index: 1;
}


.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}

/* filters*/

.collapsible {
  background-color: #777;
  color: white;
  cursor: pointer;
  padding: 18px;
  width: 250px;
  border: none;
  text-align: center;
  outline: none;
  font-size: 15px;
 

}

@media only screen and (max-width: 800px) {
.collapsible {
    width: 100%;
  }
}

.active, .collapsible:hover {
  background-color: #555;
}

.content1 {
  padding: 0 18px;
  max-height:  0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;

}
h6{
  font-size: 62%;
}
.product-name
{
  font-size: 90%;
}
.list-group-item {
  display: block;
  padding: 0;
  margin-bottom: 0px;
  background-color: none;
  border: 0px solid #ddd;
}
.list-group-item:hover{
  background-color: none;
}
/*     line-height: 0; */
</style>
</head>
<body>



<div class="goods">
  <div class="container-fluid">
    <div class="row content">
      <div class="col-sm-3 sidenav" >
            <div id="mobile-filter">
              <div class="border-bottom pb-2 ml-2">
                
              <h4 id="burgundy">Filters</h4>
            </div>
            <?php
        
        
              $kereset = $_GET['kereses'];
              $selectedAlkategoria = isset($_GET['alkategoria']) ? $_GET['alkategoria'] : '';
              echo "A keresett érték: " . $kereset;
              $_SESSION['kereset'] = $kereset;
             

              
              if (!empty($searchResults)&&!empty($kereset)) {
                //echo '<form method="post" id="search_form">';
            
                foreach ($searchResults as $categoryName => $subcategories) {
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
                        echo '<div class="checkbox"><label>';
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
            else
            {
              echo "Üres!";
            }
            
              
              
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
//window.onload = initFilter;


  // Az "initFilter" függvény meghívása az oldal betöltésekor
  initFilter();

  // Eseményfigyelő a médiaképernyő méretének változásához
  mediaQuery.addListener(initFilter);
  
  // Eseményfigyelő a médiaké
  /*$(document).on('click', 'label', function() {
    var checkbox = $(this).find('input:checkbox'); // Keresd meg a labelhez tartozó checkboxot

    if (checkbox.is(':checked')) {
        checkbox.prop('checked', false); // Ha be van jelölve, vedd ki a pipát
        $(this).removeClass('active'); // Távolítsd el az "active" class-t
    } else {
        checkbox.prop('checked', true); // Ha nincs bejelölve, jelöld be
        $(this).addClass('active'); // Adj hozzá az "active" class-t
    }
});*/
//php-hoz
  function clearFilters() {
      $('input:checkbox').each(function() {
          if ($(this).prop('checked')) {
              // Ha a checkbox be van jelölve, hozzáadja az alkategoria részt az URL-hez
              var currentValue = $(this).val();
              window.history.replaceState({}, document.title, updateUrl('alkategoria', currentValue));
          } else {
              // Ha a checkbox nincs bejelölve, eltávolítja az alkategoria részt az URL-ből
              window.history.replaceState({}, document.title, removeUrlParam('alkategoria'));
          }
      });
  }

  // Függvény az alkategoria rész hozzáadására vagy módosítására az URL-ben
  function updateUrl(key, value) {
      var currentUrl = window.location.href;
      var urlParts = currentUrl.split('?');
      if (urlParts.length >= 2) {
          var baseUrl = urlParts[0];
          var queryParams = urlParts[1].split('&');

          var updatedParams = [];
          var paramExists = false;

          for (var i = 0; i < queryParams.length; i++) {
              var param = queryParams[i].split('=');
              if (param[0] === key) {
                  paramExists = true;
                  updatedParams.push(key + '=' + value);
              } else {
                  updatedParams.push(queryParams[i]);
              }
          }

          if (!paramExists) {
              updatedParams.push(key + '=' + value);
          }

          return baseUrl + '?' + updatedParams.join('&');
      }

      return currentUrl;
  }

  // Függvény az alkategoria rész eltávolítására az URL-ből
  function removeUrlParam(key) {
      var currentUrl = window.location.href;
      var urlParts = currentUrl.split('?');
      if (urlParts.length >= 2) {
          var baseUrl = urlParts[0];
          var queryParams = urlParts[1].split('&');

          var updatedParams = [];

          for (var i = 0; i < queryParams.length; i++) {
              var param = queryParams[i].split('=');
              if (param[0] !== key) {
                  updatedParams.push(queryParams[i]);
              }
          }

          return baseUrl + '?' + updatedParams.join('&');
      }

      return currentUrl;
  }



  /*function clearFilters() {
              var checkboxes = document.querySelectorAll('input[type="checkbox"]');
              checkboxes.forEach(function (checkbox) {
                  checkbox.checked = false;
              });

              // Az űrlap elküldése
              document.getElementById('search_form').submit();
          }*/


    /*function updateURL(checkbox) {
      var selectedMenuCategory = '<?php //echo $selectedMenuCategory; ?>';
      var selectedAlkategoria = '<?php //echo $selectedAlkategoria; ?>';
      var subcategoryCheck = '<?php //echo $subcategoryCheck; ?>';


      if (checkbox.checked) {
          selectedAlkategoria = checkbox.value;
      } else {
          selectedAlkategoria = 'checked="checked"';
      }

      var newURL = 'termekek.php?menucategory=' + selectedMenuCategory;

      if (subcategoryCheck) {
          newURL += '&alkategoria=' + selectedAlkategoria;
      }

      window.location.href = newURL;
  }

  */
  //
</script>
<script src="ajax.js"></script>