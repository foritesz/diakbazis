<?php
class Product{
	private $search;
	private $receivedMenuCategory;
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
		$sql = "SELECT  category_id,category_name,subcategory FROM categories ORDER BY subcategory";

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
    echo "Nincsenek eredmények.";
}
	
	
		// Kiíratás a csoportosított adatokról
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
			echo "Nincsenek eredmények.";
		}
		return $subcategories;
	}
	
	
	public function getSearchforIt() {
		// Initialize the $subcategories array
		$subcategories = array();
		// Initialize a set to keep track of unique subcategories
		$uniqueSubcategories = array();
	
		// Construct the SQL query to search in products and join with categories
		$sql = "
			SELECT p.*, c.menu_category, c.category_name, c.subcategory
			FROM products p
			INNER JOIN categories c ON p.subcategory = c.subcategory
			WHERE p.product_name LIKE '%" . $this->search . "%' 
			OR p.leiras LIKE '%" . $this->search . "%' 
			OR p.subcategory LIKE '%" . $this->search . "%'
		";
		$result = $this->dbConnect->query($sql);
	
		if ($result->num_rows > 0) {
			// Iterate through the result set and build the subcategories array
			while ($row = $result->fetch_assoc()) {
				$category_name = $row['category_name'];
				$subcategory = $row['subcategory'];
	
				// Check if the subcategory is already in the unique set
				if (!isset($uniqueSubcategories[$subcategory])) {
					// Add the result to the $subcategories array
					$subcategories[$category_name][] = $subcategory;
					// Mark the subcategory as seen
					$uniqueSubcategories[$subcategory] = true;
				}
			}
		} else {
			// No results found in the products and categories tables
		}
	
		if (isset($_POST['subcategory']) && !empty($_POST['subcategory'])) {
			$checked = $_POST['subcategory'];
			$conditions = [];
		
			foreach ($checked as $value) {
				// Escape and sanitize the input to prevent SQL injection
				$escapedValue = mysqli_real_escape_string($this->dbConnect, $value);
		
				// Add each condition to the array
				$conditions[] = "menu_category LIKE '%$escapedValue%' OR category_name LIKE '%$escapedValue%' OR subcategory LIKE '%$escapedValue%'";
			}
		
			// Combine conditions with OR
			$conditionsString = implode(' OR ', $conditions);
		
			// Construct the SQL query
			$sql = "SELECT * FROM categories WHERE $conditionsString";
		} else {
			// Construct the SQL query to search in categories
			$sql = "
				SELECT * FROM categories 
				WHERE menu_category LIKE '%" . $this->search . "%' 
				OR category_name LIKE '%" . $this->search . "%' 
				OR subcategory LIKE '%" . $this->search . "%'
			";
		}
		
		$result_categories = $this->dbConnect->query($sql);
	
		if ($result_categories->num_rows > 0) {
			// Iterate through the result set and build the subcategories array
			while ($row = $result_categories->fetch_assoc()) {
				if (isset($row['category_name'])) {
					$category_name = $row['category_name'];
					$subcategory = $row['subcategory'];
	
					// Check if the subcategory is already in the unique set
					if (!isset($uniqueSubcategories[$subcategory])) {
						// Add the result to the $subcategories array
						$subcategories[$category_name][] = $subcategory;
						// Mark the subcategory as seen
						$uniqueSubcategories[$subcategory] = true;
					}
				}
			}
		} else {
			// No results found in the categories table
		}
	
		// Close the connection (if necessary)
		// $this->dbConnect->close();
		
		// Return the $subcategories array
		return $subcategories;
	}
	
	
	
	

	public function getTotalProducts () {
		$sql = "SELECT DISTINCT id FROM " . $this->productTable . "
		INNER JOIN " . $this->categoryTable . 
		" ON " . $this->productTable . ".subcategory = " . $this->categoryTable . ".subcategory";
		if(isset($_POST['subcategory']) && $_POST['subcategory']!=""){			
			$sql.=" AND " . $this->categoryTable . ".subcategory IN ('".implode("','",$_POST['subcategory'])."')";
		}	
		$productPerPage = 9;		
		$rowCount = $this->getNumRows($sql);
		$totalData = ceil($rowCount / $productPerPage);
		return $totalData;
	}		
	public function getProducts() {
		$productPerPage = 9;	
		$totalRecord  = strtolower(trim(str_replace("/","",$_POST['totalRecord'])));
		$start = ceil($totalRecord * $productPerPage);
		
		//$selectedMenuCategory = isset($_SESSION['selectedMenuCategory']) ? $_SESSION['selectedMenuCategory'] : '';
		
		$sql = "SELECT *
        FROM " . $this->productTable . "
        INNER JOIN " . $this->categoryTable . 
        " ON " . $this->productTable . ".subcategory = " . $this->categoryTable . ".subcategory";
        

		if (!empty($this->receivedMenuCategory)) {
			$sql .= " WHERE " . $this->categoryTable . ".menu_category = '" . $this->receivedMenuCategory . "'";
		}


		if (isset($_POST['category']) && $_POST['category'] != "") {
			$sql .= " AND " . $this->categoryTable . ".category_id IN ('" . implode("','", $_POST['category']) . "')";
		}

		if (isset($_POST['subcategory']) && $_POST['subcategory'] != "") {
			$sql .= " AND " . $this->categoryTable . ".subcategory IN ('" . implode("','", $_POST['subcategory']) . "')";
		}

		if (isset($_SESSION['kereset']) && $_SESSION['kereset'] != "") {
			$sql .= " AND " . $this->productTable . ".product_name LIKE '%" . $this->search . "%'";
		}

		/*if(isset($_POST['sorting']) && $_POST['sorting']!="") {
			$sorting = implode("','",$_POST['sorting']);			
			if($sorting == 'newest' || $sorting == '') {
				$sql.=" ORDER BY id DESC";
			} else if($sorting == 'low') {
				$sql.=" ORDER BY price ASC";
			} else if($sorting == 'high') {
				$sql.=" ORDER BY price DESC";
			}
		} else {
			$sql.=" ORDER BY id DESC";
		}*/		
		$sql.=" LIMIT $start, $productPerPage";		
		$products = $this->getData($sql);
		$rowcount = $this->getNumRows($sql);
		$productHTML = '';
		if(isset($products) && count($products)) {			
            foreach ($products as $key => $product) {				
				$productHTML .= '<div class="product-card">';
				$productHTML .= '<div class="image-container skeleton">';
				$productHTML .= '<a href="index4.php?ID=' . $product['id'] . '"><img src="images/' . $product['kepek'] . '" alt="' . $product['product_name'] . '" class="zoom-image"></a>';
				$productHTML .= '</div>';
				$productHTML .= '<div class="zoom-window" id="zoomWindow">';
				$productHTML .= '<img src="images/' . $product['kepek'] . '" alt="' . $product['product_name'] . '" class="zoomed-image">';
				$productHTML .= '</div>';
				$productHTML .= '<div class="product-details skeleton">';
				$productHTML .= '<h3>' . $product['product_name'] . '</h3>';
				$productHTML .= '<p>' . $product['leiras'] . '</p>';
				$productHTML .= '<p>Ár: $' . $product['price'] . '</p>';
				$productHTML .= '</div>';
				$productHTML .= '</div>';		
			}
		}
		session_unset();
		return 	$productHTML;	
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



/*$stmt = $your_pdo_connection->prepare($sql);
$stmt->execute($params);

// Fetch results as needed
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	// Process each row*/
?>