<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <title>Weboldal Kínézet</title>

<?php
/*include("Product.php");*/
$product = new Product();
$subcategories = $product->getSubcategory();
$menucategories = $product->getMenucategory();
$categories = $product->getCategories();
?>
<body class="loading">

  <div class="header">
          <div class="logo">
              <h1>Logó</h1>
          </div>
          <div class="hamburger" onclick="toggleMenu()">
              <div></div>
              <div></div>
              <div></div>
          </div>
          <div class="search-icon" onclick="toggleSearchBar()">
              <i class="bi bi-search"></i>
          </div>
          <div class="search-bar">
            <form action="kereses.php" method="GET">
                <input type="text" placeholder="Keresés..." id="kereso" name="kereses">
            </form>
          </div>
    </div>
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
  <div class="dropdown-container">
          <div class="dropdown">
              <button class="dropbtn">Papír-Írószer</button>
              <div class="dropdown-content">
                  <a href="#">Link 1</a>
                  <a href="#">Link 2</a>
                  <a href="#">Link 3</a>
              </div>
          </div>
          <div class="dropdown">
              <button class="dropbtn">Kreatív</button>
              <div class="dropdown-content">
                  <a href="#">Link 1</a>
                  <a href="#">Link 2</a>
                  <a href="#">Link 3</a>
              </div>
          </div>
          <div class="dropdown">
              <button class="dropbtn">Játék</button>
              <div class="dropdown-content">
                  <a href="#">Link 1</a>
                  <a href="#">Link 2</a>
                  <a href="#">Link 3</a>
              </div>
          </div>
          <div class="dropdown">
              <button class="dropbtn">Ajándék</button>
              <div class="dropdown-content">
                  <a href="#">Link 1</a>
                  <a href="#">Link 2</a>
                  <a href="#">Link 3</a>
              </div>
          </div>
          <div class="dropdown">
              <button class="dropbtn">Könyv</button>
              <div class="dropdown-content">
                  <a href="#">Link 1</a>
                  <a href="#">Link 2</a>
                  <a href="#">Link 3</a>
              </div>
          </div>
          <div class="dropdown">
              <button class="dropbtn">Táska-Pénztárca</button>
              <div class="dropdown-content">
                  <a href="#">Link 1</a>
                  <a href="#">Link 2</a>
                  <a href="#">Link 3</a>
              </div>
          </div>
          <div class="dropdown">
              <button class="dropbtn">Cipő</button>
              <div class="dropdown-content">
                  <a href="#">Link 1</a>
                  <a href="#">Link 2</a>
                  <a href="#">Link 3</a>
              </div>
          </div>
          <div class="dropdown">
              <button class="dropbtn">Háztartási cikkek</button>
              <div class="dropdown-content">
                  <a href="#">Link 1</a>
                  <a href="#">Link 2</a>
                  <a href="#">Link 3</a>
              </div>
          </div>
          <div class="dropdown">
              <button class="dropbtn">Szezonális</button>
              <div class="dropdown-content">
                  <a href="#">Link 1</a>
                  <a href="#">Link 2</a>
                  <a href="#">Link 3</a>
              </div>
          </div>
          <div class="dropdown">
              <button class="dropbtn">Óra</button>
              <div class="dropdown-content">
                  <a href="#">Link 1</a>
                  <a href="#">Link 2</a>
                  <a href="#">Link 3</a>
              </div>
          </div>
          <div class="dropdown">
              <button class="dropbtn">Szolgáltatás</button>
              <div class="dropdown-content">
                  <a href="#">Link 1</a>
                  <a href="#">Link 2</a>
                  <a href="#">Link 3</a>
              </div>
          </div>
      </div>
</body>