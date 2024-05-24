<?php

/*include("Product.php");*/
$product = new Product();
$subcategories = $product->getSubcategory();
$menucategories = $product->getMenucategory();
$categories = $product->getCategories();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
* {
  box-sizing: border-box;
}

body {
  margin: 0;
}

.navbar {
  overflow: hidden;
  background-color: #333;
  font-family: Arial, Helvetica, sans-serif;
}

.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: red;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  width: 100%;
  left: 0;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content .header {
  background: red;
  padding: 16px;
  color: white;
}

.dropdown:hover .dropdown-content {
  display: block;
}

/* Create three equal columns that floats next to each other */
.column {
  float: left;
  width:10%;
  height: 250px;
}

.column a {
  float: none;
  color: black;
  padding: 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.column a:hover {
  background-color: #ddd;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>
</head>
<body style="background-color:white;">
  
<form action="kereses.php" method="GET">
        <label for="kereso">Keresés:</label>
        <input type="text" id="kereso" name="kereses">
        <button type="submit">Keresés</button>
</form>

<?php
echo '<form method="post" id="search_form">';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Keresési paraméter kiolvasása
    if(isset($_GET['kereses'])) {
        $kereset = $_GET['kereses'];
             
        $_SESSION['kereset'] = $_GET['kereses'];
        // Ellenőrzés, ha a keresőmező nem üres
        if(isset($_GET['submit'])) {
            // Itt lehet további keresési logika vagy adatbázis lekérdezés
            header("Location: kereses.php?kereses=".urlencode($kereses));
            exit();
            
            // Példa: Visszairányítás a masik_oldal.php-re a keresési paraméterrel
        }
    }
}
//session_destroy();
?>


<div class="navbar">
  <div class="dropdown">
    <button class="collapsible">Papír-íroszer
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="content1">
      <div class="row">
        <?php
        //$selectedCategory = 'Papír-íroszer';

        /*if (isset($menucategories[$selectedCategory])) {
        foreach ($subcategories as $categoryName => $subcategories) { 
          echo' <div class="column">';
          echo '<h3>' . ucfirst($categoryName) . '</h3>';
          foreach ($subcategories as $key => $subcategory) {
          echo '<a href="#">' . ucfirst($subcategory) . '</a>';
          } 
          echo'</div>';
        }
        }
        foreach ($categories as $category) {
            echo $category['category_id'] . '<br>';
        }*/
        $selectedCategory = 'Papír-Íroszer';
if (isset($menucategories[$selectedCategory])) {
    foreach ($menucategories[$selectedCategory] as $categoryName => $subcategories) {
        echo' <div class="column">';
          echo '<h3>' . ucfirst($categoryName) . '</h3>';
          foreach ($subcategories as $key => $subcategory ) {
            $categoryEncoded = urlencode($selectedCategory);
            $subcategoryEncoded = urlencode($subcategory);
            $link = "termekek.php?menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
            echo '<a href="' . $link . '">' . ucfirst($subcategory) . '</a>';

            } 
          echo'</div>';
    }
}
        ?>
      </div>
     </div>
    </div>
    <div class="dropdown">
    <button class="dropbtn">Kreatív
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <div class="header">
        <h2>Mega Menu</h2>
      </div>   
      <div class="row">
       
        <?php
        /*foreach ($subcategories as $categoryName => $subcategories) { 
          echo' <div class="column">';
          echo '<h3>' . ucfirst($categoryName) . '</h3>';
          foreach ($subcategories as $key => $subcategory) {
          echo '<a href="#">' . ucfirst($subcategory) . '</a>';
          } 
          echo'</div>';
        }
*/
        ?>
      </div>
     </div>
    </div> 
</div>

<div style="padding:16px">
  <h3>Mega Menu (Full-width dropdown in navbar)</h3>
  <p>Hover over the "Dropdown" link to see the mega menu.</p>
</div>

</body>
</html>
