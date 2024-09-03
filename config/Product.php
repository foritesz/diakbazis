<?php
class Product{
	private $search;
	private $receivedMenuCategory;
	private $menucategory;
	private $alkategoria;
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "12345678";
    private $database  = "products";
	private $productTable = 'products';
	private $categoryTable = 'categories';
	private $dbConnect = false;
	public function __construct(){
		// Start the session
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
	
		// Assign session values to class properties
		$this->search = isset($_SESSION['kereset']) ? $_SESSION['kereset'] : '';
		$this->receivedMenuCategory = isset($_SESSION['selectedMenuCategory']) ? $_SESSION['selectedMenuCategory'] : '';
		$this->menucategory = isset($_SESSION['menucategory']) ? $_SESSION['menucategory'] : ''; // Fixed here
		$this->alkategoria = isset($_SESSION['alkategoria']) ? $_SESSION['alkategoria'] : '';
	
		// Check if the database connection is not established
		if(!$this->dbConnect){ 
			$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
	
			// Check for a connection error
			if($conn->connect_error){
				die("Error failed to connect to MySQL: " . $conn->connect_error);
			} else {
				$this->dbConnect = $conn;
			}
		}
	}
	
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if (!$result) {
			die('Error in query: ' . mysqli_error($this->dbConnect));
		}
		$data = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}
	
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error($this->dbConnect));
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}	
	public function cleanString($str){
		return str_replace(' ','_',$str);
	}

	public function getCategories() {		
		$sqlQuery = "
		SELECT category_id, category_name
			FROM ".$this->categoryTable." 
			GROUP BY category_name";
        return  $this->getData($sqlQuery);
	}

	public function getSubcategory() {
		$sql = "SELECT DISTINCT c.category_id, c.category_name, c.subcategory
				FROM categories c
				INNER JOIN products p ON c.subcategory = p.subcategory
				WHERE p.visible_product = 1
				ORDER BY c.subcategory";
	
		$result = $this->dbConnect->query($sql);
	
		// Asszociatív tömb létrehozása a csoportosításhoz
		$subcategories = array();
	
		// Eredmény feldolgozása és csoportosítás
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$categoryName = $row["category_name"];
				$subcategory = $row["subcategory"];
				
				// Csoportosítás az alapján, hogy melyik kategóriához tartozik
				if (!isset($subcategories[$categoryName])) {
					$subcategories[$categoryName] = array();
				}
				$subcategories[$categoryName][] = $subcategory;
			}
		} else {
			//echo "Nincsenek eredmények.";
		}
	
		return $subcategories;
	}
	
	
	public function getMenucategory() {
		$sql = "SELECT category_name, subcategory, menu_category FROM categories ORDER BY menu_category, category_name";
		$result = $this->dbConnect->query($sql);
	
		// Asszociatív tömb létrehozása a csoportosításhoz
		$subcategories = array();
	
		// Eredmény feldolgozása és csoportosítás
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$categoryName = $row["category_name"];
				$subcategory = $row["subcategory"];
				$menuCategory = $row["menu_category"];
	
				// Csoportosítás az alapján, hogy melyik menükategóriához és kategóriához tartozik
				if (!isset($subcategories[$menuCategory])) {
					$subcategories[$menuCategory] = array();
				}
				if (!isset($subcategories[$menuCategory][$categoryName])) {
					$subcategories[$menuCategory][$categoryName] = array();
				}
				$subcategories[$menuCategory][$categoryName][] = $subcategory;
			}
		} else {
			//echo "Nincsenek eredmények.";
		}
		return $subcategories;
	}
	
	
	public function getSearchforIt() {
		$subcategories = array();
		$uniqueSubcategories = array();
		$this->search = isset($_GET['kereses']) ? $_GET['kereses'] : '';
	
		$sql = "
		SELECT p.*, c.menu_category, c.category_name, c.subcategory
		FROM products p
		INNER JOIN categories c ON p.subcategory = c.subcategory
		WHERE LOWER(p.product_name) LIKE '%" . strtolower($this->search) . "%' 
		OR LOWER(p.leiras) LIKE '%" . strtolower($this->search) . "%' 
		OR LOWER(p.subcategory) LIKE '%" . strtolower($this->search) . "%'
	";
	
		$result = $this->dbConnect->query($sql);
	
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$category_name = $row['category_name'];
				$subcategory = $row['subcategory'];
	
				if (!isset($uniqueSubcategories[$subcategory])) {
					$subcategories[$category_name][] = $subcategory;
					$uniqueSubcategories[$subcategory] = true;
				}
			}
		}
	
		if (isset($_POST['subcategory']) && !empty($_POST['subcategory'])) {
			$checked = $_POST['subcategory'];
			$conditions = [];
			foreach ($checked as $value) {
				$escapedValue = mysqli_real_escape_string($this->dbConnect, $value);
				$conditions[] = "menu_category LIKE '%$escapedValue%' OR category_name LIKE '%$escapedValue%' OR subcategory LIKE '%$escapedValue%'";
			}
			$conditionsString = implode(' OR ', $conditions);
			$sql = "SELECT * FROM categories WHERE $conditionsString";
		} else {
			$sql = "
				SELECT * FROM categories 
				WHERE menu_category LIKE '%" . $this->search . "%' 
				OR category_name LIKE '%" . $this->search . "%' 
				OR subcategory LIKE '%" . $this->search . "%'
			";
		}
		
		$result_categories = $this->dbConnect->query($sql);
	
		if ($result_categories->num_rows > 0) {
			while ($row = $result_categories->fetch_assoc()) {
				if (isset($row['category_name'])) {
					$category_name = $row['category_name'];
					$subcategory = $row['subcategory'];
	
					if (!isset($uniqueSubcategories[$subcategory])) {
						$subcategories[$category_name][] = $subcategory;
						$uniqueSubcategories[$subcategory] = true;
					}
				}
			}
		}
	
		return $subcategories;
	}
	
	
	
	
	

// Fetch total products for pagination
public function getTotalProducts() {
    $sql = "SELECT DISTINCT " . $this->productTable . ".id 
            FROM " . $this->productTable . "
            INNER JOIN " . $this->categoryTable . " 
            ON " . $this->productTable . ".subcategory = " . $this->categoryTable . ".subcategory";
    
    $conditions = [];
    
    // Check for subcategory filter
    if (isset($_POST['subcategory']) && !empty($_POST['subcategory'])) {
        $subcategory = array_map([$this->dbConnect, 'real_escape_string'], $_POST['subcategory']);
        $conditions[] = $this->categoryTable . ".subcategory IN ('" . implode("','", $subcategory) . "')";
    }

    // Append conditions to SQL query
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }
    
    $result = $this->dbConnect->query($sql);
    if (!$result) {
        die('Invalid query: ' . $this->dbConnect->error);
    }

    $productPerPage = 9;        
    $rowCount = $result->num_rows;
    $totalData = ceil($rowCount / $productPerPage);

    return $totalData;
}

// Fetch products based on filters and pagination
public function getProducts($page = 0, $subcategory = [], $search = '') {
    $productPerPage = 9;
    $start = $page * $productPerPage;

    $sql = "SELECT " . $this->productTable . ".*, " . $this->categoryTable . ".subcategory
            FROM " . $this->productTable . "
            INNER JOIN " . $this->categoryTable . " 
            ON " . $this->productTable . ".subcategory = " . $this->categoryTable . ".subcategory";

    $conditions = [];

    // Filter by received menu category if set
    if (!empty($this->receivedMenuCategory)) {
        $conditions[] = $this->categoryTable . ".menu_category = '" . $this->dbConnect->real_escape_string($this->receivedMenuCategory) . "'";
    }

    // Filter by subcategories
    if (!empty($subcategory)) {
        $subcategory = array_map([$this->dbConnect, 'real_escape_string'], $subcategory);
        $conditions[] = $this->categoryTable . ".subcategory IN ('" . implode("','", $subcategory) . "')";
    }

	if (!empty($search)) {
		// Sanitize and save the search term to session
		$search = $this->dbConnect->real_escape_string($search);
		$_SESSION['kereset'] = $search;
		$conditions[] = "LOWER(" . $this->productTable . ".product_name) LIKE '%" . strtolower($search) . "%'";
	} elseif (isset($_SESSION['kereset']) && $_SESSION['kereset'] != "") {
		// Retrieve the search term from session and sanitize
		$search = $this->dbConnect->real_escape_string($_SESSION['kereset']);
		$conditions[] = "LOWER(" . $this->productTable . ".product_name) LIKE '%" . strtolower($search) . "%'";
	}
	

    // Build SQL query
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    $sql .= " LIMIT $start, $productPerPage";

    $products = $this->getData($sql);
    $productHTML = '';
    
    if (!empty($products)) {
        foreach ($products as $product) {
			if($product['visible_product']==0){
				$productHTML .= '<div class="product-card">';
				$productHTML .= '<div class="image-container skeleton">';
				$productHTML .= '<a href="index.php?ID=' . $product['id'] . '"><img src="images/' . $product['kepek'] . '" alt="' . $product['product_name'] . '" class="zoom-image"></a>';
				$productHTML .= '</div>';
				$productHTML .= '<div class="zoom-window" id="zoomWindow">';
				$productHTML .= '<img src="images/' . $product['kepek'] . '" alt="' . $product['product_name'] . '" class="zoomed-image">';
				$productHTML .= '</div>';
				$productHTML .= '<div class="product-details">';
				$productHTML .= '<h3>' . $product['product_name'] . '</h3>';
				$productHTML .= '<p>' . $product['leiras'] . '</p>';

				if ($product['price'] != 0) {
					$productHTML .= '<p>' . $product['price'] . ' Ft</p>';
				}

				$productHTML .= '</div>';
				$productHTML .= '</div>';
			}
        }
    }

    return $productHTML;
}

// Fetch products with admin actions
public function getProductsForAdmin($page = 0, $subcategory = [], $search = '') {
    $productPerPage = 9;
    $start = $page * $productPerPage;

    $sql = "SELECT " . $this->productTable . ".*, " . $this->categoryTable . ".subcategory
            FROM " . $this->productTable . "
            INNER JOIN " . $this->categoryTable . " 
            ON " . $this->productTable . ".subcategory = " . $this->categoryTable . ".subcategory";

    $conditions = [];

    if (!empty($this->receivedMenuCategory)) {
        $conditions[] = $this->categoryTable . ".menu_category = '" . $this->dbConnect->real_escape_string($this->receivedMenuCategory) . "'";
    }

    if (!empty($subcategory)) {
        $subcategory = array_map([$this->dbConnect, 'real_escape_string'], $subcategory);
        $conditions[] = $this->categoryTable . ".subcategory IN ('" . implode("','", $subcategory) . "')";
    }

    if (!empty($search)) {
        $search = $this->dbConnect->real_escape_string($search);
        $_SESSION['kereset'] = $search;  // Update session with new search term
        $conditions[] = $this->productTable . ".product_name LIKE '%" . $search . "%'";
    } else {
        unset($_SESSION['kereset']);  // Clear the session if no search term
    }

	if (!empty($search)) {
		// Sanitize and save the search term to session
		$search = $this->dbConnect->real_escape_string($search);
		$_SESSION['kereset'] = $search;
		$conditions[] = "LOWER(" . $this->productTable . ".product_name) LIKE '%" . strtolower($search) . "%'";
	} elseif (isset($_SESSION['kereset']) && $_SESSION['kereset'] != "") {
		// Retrieve the search term from session and sanitize
		$search = $this->dbConnect->real_escape_string($_SESSION['kereset']);
		$conditions[] = "LOWER(" . $this->productTable . ".product_name) LIKE '%" . strtolower($search) . "%'";
	}

    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    $sql .= " LIMIT $start, $productPerPage";

    $products = $this->getData($sql);
    $productHTML = '';

    if (!empty($products)) {
        foreach ($products as $product) {
            $productHTML .= '<div class="product-card">';
            $productHTML .= '<div class="image-container skeleton">';
            $productHTML .= '<a href="index.php?ID=' . $product['id'] . '"><img src="../images/' . $product['kepek'] . '" alt="' . $product['product_name'] . '" class="zoom-image"></a>';
            $productHTML .= '</div>';
            $productHTML .= '<div class="zoom-window" id="zoomWindow">';
            $productHTML .= '<img src="../images/' . $product['kepek'] . '" alt="' . $product['product_name'] . '" class="zoomed-image">';
            $productHTML .= '</div>';
            $productHTML .= '<div class="product-details">';
            $productHTML .= '<h3>' . $product['product_name'] . '</h3>';
            $productHTML .= '<p>' . $product['leiras'] . '</p>';
            
            if ($product['price'] != 0) {
                $productHTML .= '<p>' . $product['price'] . ' Ft</p>';
            }

            $productHTML .= '</div>';
            $productHTML .= '<div class="actions">';
            $productHTML .= '<div class="checkbox-container">';
            $productHTML .= '</div>';
            $productHTML .= '<div class="buttons">';
            $productHTML .= '<a href="dashboard.php?cat=product-crud&subcat=admin_update&edit=' . $product['id'] . '&menucategory=' . urlencode($this->menucategory) . '&alkategoria=' . urlencode($this->alkategoria) . '" class="modify-btn"> <i class="fas fa-edit"></i> Módosítás </a>';
            $productHTML .= '<a href="dashboard.php?cat=product-crud&subcat=admin_page&delete=' . $product['id'] . '" class="delete-btn"> <i class="fas fa-trash"></i> Törlés </a>';
            $productHTML .= '</div>';
            $productHTML .= '</div>';
            $productHTML .= '</div>';
        }
    }

    return $productHTML;
}


	
	

	/**
	 * @return mixed
	 */
	public function getDbConnect() {
		return $this->dbConnect;
	}
	
	/**
	 * @param mixed $dbConnect 
	 * @return self
	 */
	public function setDbConnect($dbConnect): self {
		$this->dbConnect = $dbConnect;
		return $this;
	}
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>