<?php
include("Product.php");
include("navbar.php");
include("cookie.php");
$product = new Product();
$subcategories = $product->getMenucategory();
$totalRecords = $product->getTotalProducts();
$ide = $product->getCategories();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            max-width: 900px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .box {
            width: 100%;
            margin-bottom: 20px;
        }
        .map-container {
            width: 100%;
            height: 400px;
            margin-top: 20px;
        }
        @media (min-width: 768px) {
            .box {
                width: 48%;
            }
            .map-container {
                height: 500px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <img src="your-image-url.jpg" alt="Bolt képe" style="width: 100%; max-width: 600px; border-radius: 10px;">
        </div>

        <div class="content">
            <div class="box">
                <h2>Bolt Címe és Elérhetőségei</h2>
                <p><strong>Cím:</strong> 1234 Budapest, Fő utca 1.</p>
                <p><strong>Telefon:</strong> +36 1 234 5678</p>
                <p><strong>Email:</strong> info@bolt.hu</p>
            </div>
            <div class="box">
                <h2>Hol Találsz Minket</h2>
                <div id="map" class="map-container"></div>
            </div>
        </div>
    </div>

    <script>
        function initMap() {
            var storeLocation = {lat: 47.4979, lng: 19.0402}; // Budapest központja
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: storeLocation
            });
            var marker = new google.maps.Marker({
                position: storeLocation,
                map: map
            });
        }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap">
    </script>

</body>
</html>
