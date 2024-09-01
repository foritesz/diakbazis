<?php
session_start();
$product = new Product();
$subcategories = $product->getSubcategory();
$menucategories = $product->getMenucategory();
$categories = $product->getCategories();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <script src="../public/assets/js/script.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <title>Weboldal Kínézet</title>

<body class="loading">
  <div class="header">
          <div class="logo">
          <a href="../">
            <svg width="200" height="50" xmlns="http://www.w3.org/2000/svg">
                <text x="10" y="35" font-family="Arial" font-size="30" font-weight="bold" fill="black">
                    <tspan fill="red" font-weight="bold">D</tspan>iák-<tspan fill="red" font-weight="bold">B</tspan>ázis
                </text>
            </svg>
            </a>
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
            <form action=kereses.php method="GET">
                <input type="text" placeholder="Keresés..." id="kereso" name="kereses">
                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
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
                        header("Location: /kereses.php?kereses=".urlencode($kereses));
                        exit();
                        
                        // Példa: Visszairányítás a masik_oldal-re a keresési paraméterrel
                    }
                }
            }
            //session_destroy();
            echo '</form>';
  ?>
  <div class="navbar">
        <div class="dropdown-container">
            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(event)">Papír-Írószer
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                      <div class="content1">
                            <div class="row">
 <?php
            // Example for one of the dropdowns (Papír-Írószer)
            $selectedCategory = 'Papír-Írószer';
            if (isset($menucategories[$selectedCategory])) {
                $itemCount = 0;
                foreach ($menucategories[$selectedCategory] as $categoryName => $subcategories) {
                    if ($itemCount % 4 == 0) {
                        // Close the previous column and start a new one after every 4 items
                        if ($itemCount > 0) {
                            echo '</div>'; // Close previous column
                        }
                        echo '<div class="column">'; // Start new column
                    }
                    echo '<h3>' . ucfirst($categoryName) . '</h3>';
                    foreach ($subcategories as $key => $subcategory) {
                        $categoryEncoded = urlencode($selectedCategory);
                        $subcategoryEncoded = urlencode($subcategory);
                        // Remove .php from the URL
                        $link = "termekek?menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
                        echo '<a href="termekek">' . ucfirst($subcategory) . '</a>';                        
                    }
                    $itemCount++;
                }
                echo '</div>'; 
            }
?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(event)">Kreatív
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                      <div class="content1">
                            <div class="row">
<?php

                                $selectedCategory = 'Kreatív';
                                if (isset($menucategories[$selectedCategory])) {
                                    $itemCount = 0;
                                    foreach ($menucategories[$selectedCategory] as $categoryName => $subcategories) {
                                        if ($itemCount % 4 == 0) {
                                            // Close the previous column and start a new one after every 4 items
                                            if ($itemCount > 0) {
                                                echo '</div>'; // Close previous column
                                            }
                                            echo '<div class="column">'; // Start new column
                                        }
                                        echo '<h3>' . ucfirst($categoryName) . '</h3>';
                                        foreach ($subcategories as $key => $subcategory) {
                                            $categoryEncoded = urlencode($selectedCategory);
                                            $subcategoryEncoded = urlencode($subcategory);
                                            $link = "termekek.php/?menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
                                            echo '<a href="' . $link . '">' . ucfirst($subcategory) . '</a>';
                                        }
                                        $itemCount++;
                                    }
                                    echo '</div>'; 
                    }
?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(event)">Játék
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                      <div class="content1">
                            <div class="row">
<?php

                                $selectedCategory = 'Játék';
                                if (isset($menucategories[$selectedCategory])) {
                                    $itemCount = 0;
                                    foreach ($menucategories[$selectedCategory] as $categoryName => $subcategories) {
                                        if ($itemCount % 4 == 0) {
                                            // Close the previous column and start a new one after every 4 items
                                            if ($itemCount > 0) {
                                                echo '</div>'; // Close previous column
                                            }
                                            echo '<div class="column">'; // Start new column
                                        }
                                        echo '<h3>' . ucfirst($categoryName) . '</h3>';
                                        foreach ($subcategories as $key => $subcategory) {
                                            $categoryEncoded = urlencode($selectedCategory);
                                            $subcategoryEncoded = urlencode($subcategory);
                                            $link = "termekek.php?menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
                                            echo '<a href="' . $link . '">' . ucfirst($subcategory) . '</a>';
                                        }
                                        $itemCount++;
                                    }
                                    echo '</div>'; 
                    }
?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(event)">Ajándék 
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                      <div class="content1">
                            <div class="row">
<?php

                                $selectedCategory = 'Ajándék';
                                if (isset($menucategories[$selectedCategory])) {
                                    $itemCount = 0;
                                    foreach ($menucategories[$selectedCategory] as $categoryName => $subcategories) {
                                        if ($itemCount % 4 == 0) {
                                            // Close the previous column and start a new one after every 4 items
                                            if ($itemCount > 0) {
                                                echo '</div>'; // Close previous column
                                            }
                                            echo '<div class="column">'; // Start new column
                                        }
                                        echo '<h3>' . ucfirst($categoryName) . '</h3>';
                                        foreach ($subcategories as $key => $subcategory) {
                                            $categoryEncoded = urlencode($selectedCategory);
                                            $subcategoryEncoded = urlencode($subcategory);
                                            $link = "termekek.php?menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
                                            echo '<a href="' . $link . '">' . ucfirst($subcategory) . '</a>';
                                        }
                                        $itemCount++;
                                    }
                                    echo '</div>'; 
                    }
?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(event)">Könyv
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                      <div class="content1">
                            <div class="row">
<?php

                                $selectedCategory = 'Könyv';
                                if (isset($menucategories[$selectedCategory])) {
                                    $itemCount = 0;
                                    foreach ($menucategories[$selectedCategory] as $categoryName => $subcategories) {
                                        if ($itemCount % 4 == 0) {
                                            // Close the previous column and start a new one after every 4 items
                                            if ($itemCount > 0) {
                                                echo '</div>'; // Close previous column
                                            }
                                            echo '<div class="column">'; // Start new column
                                        }
                                        echo '<h3>' . ucfirst($categoryName) . '</h3>';
                                        foreach ($subcategories as $key => $subcategory) {
                                            $categoryEncoded = urlencode($selectedCategory);
                                            $subcategoryEncoded = urlencode($subcategory);
                                            $link = "termekek.php?menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
                                            echo '<a href="' . $link . '">' . ucfirst($subcategory) . '</a>';
                                        }
                                        $itemCount++;
                                    }
                                    echo '</div>'; 
                    }
?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(event)">Táska-Pénztárca
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                      <div class="content1">
                            <div class="row">
<?php

                                $selectedCategory = 'Táska-Pénztárca';
                                if (isset($menucategories[$selectedCategory])) {
                                    $itemCount = 0;
                                    foreach ($menucategories[$selectedCategory] as $categoryName => $subcategories) {
                                        if ($itemCount % 4 == 0) {
                                            // Close the previous column and start a new one after every 4 items
                                            if ($itemCount > 0) {
                                                echo '</div>'; // Close previous column
                                            }
                                            echo '<div class="column">'; // Start new column
                                        }
                                        echo '<h3>' . ucfirst($categoryName) . '</h3>';
                                        foreach ($subcategories as $key => $subcategory) {
                                            $categoryEncoded = urlencode($selectedCategory);
                                            $subcategoryEncoded = urlencode($subcategory);
                                            $link = "termekek.php?menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
                                            echo '<a href="' . $link . '">' . ucfirst($subcategory) . '</a>';
                                        }
                                        $itemCount++;
                                    }
                                    echo '</div>'; 
                    }
?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(event)">Cipő
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                      <div class="content1">
                            <div class="row">
<?php

                                $selectedCategory = 'Cipő';
                                if (isset($menucategories[$selectedCategory])) {
                                    $itemCount = 0;
                                    foreach ($menucategories[$selectedCategory] as $categoryName => $subcategories) {
                                        if ($itemCount % 4 == 0) {
                                            // Close the previous column and start a new one after every 4 items
                                            if ($itemCount > 0) {
                                                echo '</div>'; // Close previous column
                                            }
                                            echo '<div class="column">'; // Start new column
                                        }
                                        echo '<h3>' . ucfirst($categoryName) . '</h3>';
                                        foreach ($subcategories as $key => $subcategory) {
                                            $categoryEncoded = urlencode($selectedCategory);
                                            $subcategoryEncoded = urlencode($subcategory);
                                            $link = "termekek.php?menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
                                            echo '<a href="' . $link . '">' . ucfirst($subcategory) . '</a>';
                                        }
                                        $itemCount++;
                                    }
                                    echo '</div>'; 
                    }
?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(event)">Háztartási cikkek
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                      <div class="content1">
                            <div class="row">
<?php

                                $selectedCategory = 'Háztartási cikkek';
                                if (isset($menucategories[$selectedCategory])) {
                                    $itemCount = 0;
                                    foreach ($menucategories[$selectedCategory] as $categoryName => $subcategories) {
                                        if ($itemCount % 4 == 0) {
                                            // Close the previous column and start a new one after every 4 items
                                            if ($itemCount > 0) {
                                                echo '</div>'; // Close previous column
                                            }
                                            echo '<div class="column">'; // Start new column
                                        }
                                        echo '<h3>' . ucfirst($categoryName) . '</h3>';
                                        foreach ($subcategories as $key => $subcategory) {
                                            $categoryEncoded = urlencode($selectedCategory);
                                            $subcategoryEncoded = urlencode($subcategory);
                                            $link = "termekek.php?menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
                                            echo '<a href="' . $link . '">' . ucfirst($subcategory) . '</a>';
                                        }
                                        $itemCount++;
                                    }
                                    echo '</div>'; 
                    }
?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(event)">Szezonális
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                      <div class="content1">
                            <div class="row">
<?php

                                $selectedCategory = 'Szezonális';
                                if (isset($menucategories[$selectedCategory])) {
                                    $itemCount = 0;
                                    foreach ($menucategories[$selectedCategory] as $categoryName => $subcategories) {
                                        if ($itemCount % 4 == 0) {
                                            // Close the previous column and start a new one after every 4 items
                                            if ($itemCount > 0) {
                                                echo '</div>'; // Close previous column
                                            }
                                            echo '<div class="column">'; // Start new column
                                        }
                                        echo '<h3>' . ucfirst($categoryName) . '</h3>';
                                        foreach ($subcategories as $key => $subcategory) {
                                            $categoryEncoded = urlencode($selectedCategory);
                                            $subcategoryEncoded = urlencode($subcategory);
                                            $link = "termekek.php?menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
                                            echo '<a href="' . $link . '">' . ucfirst($subcategory) . '</a>';
                                        }
                                        $itemCount++;
                                    }
                                    echo '</div>'; 
                    }
?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(event)">Óra
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                      <div class="content1">
                            <div class="row">
<?php

                                $selectedCategory = 'Óra';
                                if (isset($menucategories[$selectedCategory])) {
                                    $itemCount = 0;
                                    foreach ($menucategories[$selectedCategory] as $categoryName => $subcategories) {
                                        if ($itemCount % 4 == 0) {
                                            // Close the previous column and start a new one after every 4 items
                                            if ($itemCount > 0) {
                                                echo '</div>'; // Close previous column
                                            }
                                            echo '<div class="column">'; // Start new column
                                        }
                                        echo '<h3>' . ucfirst($categoryName) . '</h3>';
                                        foreach ($subcategories as $key => $subcategory) {
                                            $categoryEncoded = urlencode($selectedCategory);
                                            $subcategoryEncoded = urlencode($subcategory);
                                            $link = "termekek.php?menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
                                            echo '<a href="' . $link . '">' . ucfirst($subcategory) . '</a>';
                                        }
                                        $itemCount++;
                                    }
                                    echo '</div>'; 
                    }
?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dropdown">
            <button class="dropbtn">
                <a href="szolgaltatas" class="dropbtn" style=" text-decoration: none;">
                    Szolgáltatás
                </a>
                </button>
            </div>

        </div>
    </div>
</body>