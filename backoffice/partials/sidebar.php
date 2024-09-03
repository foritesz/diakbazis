<?php
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
    <link rel="stylesheet" href="assets/css/style_admin.css">
    <script src="../public/assets/js/script.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Admin oldla</title>

<body class="loading">
  <div class="header">
          <div class="logo">
              <h1>Admin Oldal</h1>
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
            <form method="GET">
                <input type="text" placeholder="Keresés..." id="kereso" name="kereses">
                <button type="submit" name="submit"><i class="bi bi-search" ></i></button>
            </form>
          </div>
    </div>
  <?php
            echo '<form method="post" id="search_form">';

            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['submit'])) {
                // Check if 'kereses' is set
                if (isset($_GET['kereses'])) {
                    $kereses = $_GET['kereses'];
                    
                    // Optional: Store in session if needed
                    // session_start();
                    // $_SESSION['kereset'] = $kereses;
                    
                    // Redirect to the desired page with the search parameter
                    header("Location: /backoffice/dashboard.php?cat=product-crud&subcat=kereses_admin&kereses=" . urlencode($kereses));
                    exit();
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
            $link = "dashboard.php?cat=product-crud&subcat=admin_page&menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
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
                                            $link = "dashboard.php?cat=product-crud&subcat=admin_page&menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
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
                                            $link = "dashboard.php?cat=product-crud&subcat=admin_page&menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
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
                                            $link = "dashboard.php?cat=product-crud&subcat=admin_page&menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
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
                                            $link = "dashboard.php?cat=product-crud&subcat=admin_page&menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
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
                                            $link = "dashboard.php?cat=product-crud&subcat=admin_page&menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
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
                                            $link = "dashboard.php?cat=product-crud&subcat=admin_page&menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
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
                                            $link = "dashboard.php?cat=product-crud&subcat=admin_page&menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
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
                                            $link = "dashboard.php?cat=product-crud&subcat=admin_page&menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
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
                                            $link = "dashboard.php?cat=product-crud&subcat=admin_page&menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
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
                <button class="dropbtn" onclick="toggleDropdown(event)">Szolgáltatás
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                      <div class="content1">
                            <div class="row">
<?php

                                $selectedCategory = 'Szolgáltatás';
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
                                            $link = "dashboard.php?cat=product-crud&subcat=admin_page&menucategory={$categoryEncoded}&alkategoria={$subcategoryEncoded}";
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

            </div>
        </div>
    </div>
</body>

    <!-- Main navigation -->
    <nav class="custom-navbar sticky-top">
        <div class="container-fluid">
            <ul class="custom-navbar-nav">
                <li class="nav-item">
                    <a class="custom-nav-link" href="dashboard.php"><i class='fa fa-home'></i>Kezdőlap</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle custom-nav-link" href="#" onclick="toggleDropdown(event)">
                        <i class='fa fa-cog'></i> Termékek
                    </a>
                    <div class="custom-dropdown-content">
                        <a href="dashboard.php?cat=product-crud&subcat=admin_page">Termék kezelése</a>
                        <a href="dashboard.php?cat=product-crud&subcat=filter_page">Kategóriák kezelése</a>
                    </div>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle custom-nav-link" href="#" onclick="toggleDropdown(event)">
                        <i class='fa fa-cog'></i> Website Setting 
                    </a>
                    <div class="custom-dropdown-content">
                        <a href="dashboard.php?cat=website-setting&subcat=website-menu">Website Menu</a>
                        <a href="dashboard.php?cat=website-setting&subcat=website-setting">Website-Setting</a>
                        <a href="dashboard.php?cat=website-setting&subcat=theme-setting">Theme Setting</a>
                    </div>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle custom-nav-link" href="#" onclick="toggleDropdown(event)">
                        <i class='fa fa-envelope'></i> Contact Us
                    </a>
                    <div class="custom-dropdown-content">
                        <a href="dashboard.php?cat=contact&subcat=contact-details">Contact Detail</a>
                        <a href="dashboard.php?cat=contact&subcat=contact-us-message">Contact Message</a>
                        <a href="dashboard.php?cat=contact&subcat=contact-email">Contact Email</a>
                    </div>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle custom-nav-link" href="#" onclick="toggleDropdown(event)">
                        <i class='fa fa-file-alt'></i> Website Content
                    </a>
                    <div class="custom-dropdown-content">
                        <a href="dashboard.php?cat=website-content&subcat=home-content">Home Content</a>
                    </div>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle custom-nav-link" href="#" onclick="toggleDropdown(event)">
                        <i class='fa fa-user-cog'></i> Felhasználók
                    </a>
                    <div class="custom-dropdown-content">
                        <a href="dashboard.php?cat=website-admin&subcat=admin-profile">Admin Profile</a>
                        <a href="dashboard.php?cat=website-admin&subcat=change-password">Change Password</a>
                    </div>
                </li>
                <li class="nav-item" style="margin-top:15px;">
                <a class="nav-link " href="logout.php" title="Kijelentkezés"><i class='fas fa-sign-out-alt'></i>
            </a>
                </li>
            </ul>
        </div>
    </nav>


    <script>
        function toggleDropdown(event) {
            event.preventDefault();

            // Bezárjuk az összes lenyíló tartalmat
            var dropdowns = document.getElementsByClassName("custom-dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }

            // Megnyitjuk az aktuális lenyíló tartalmat
            var dropdownContent = event.target.nextElementSibling;
            dropdownContent.classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.custom-nav-link')) {
                var dropdowns = document.getElementsByClassName("custom-dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        function logout() {
            window.location.href = 'logout.php';
        }
    </script>