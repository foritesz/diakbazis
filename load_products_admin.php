<?php
include("Product.php");
$product = new Product();

$page = isset($_POST['totalRecord']) ? (int)$_POST['totalRecord'] : 0;
$subcategory = isset($_POST['subcategory']) ? $_POST['subcategory'] : [];
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Fetch products for admin
$products = $product->getProductsForAdmin($page, $subcategory, $search);
$productData = array(
    "products" => $products
);
echo json_encode($productData);
?>
