<?php
include("config/Product.php");
include("includes/navbar.php");
include("includes/cookie.php");
$product = new Product();
$subcategories = $product->getMenucategory();
$totalRecords = $product->getTotalProducts();
$ide = $product->getCategories();
?>
    <title>Home Page</title>
    <style>


    </style>
</head>
<body>

    <div class="info_container">
        <div class="info">
            <img src="your-image-url.jpg" alt="Bolt képe" style="width: 100%; max-width: 600px; border-radius: 10px;">
        </div>

        <div class="info_content">
            <div class="box">
                <h2>Bolt Címe és Elérhetőségei</h2>
                <p><strong>Cím:</strong> 1234 Budapest, Fő utca 1.</p>
                <p><strong>Email:</strong> info@bolt.hu</p>
            </div>
            <div class="box">
                <h2>Hol Találsz Minket</h2>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d670.0248032676759!2d21.68261352857572!3d47.79891249905962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x474766762751e59d%3A0xe870cceb5fb071e!2zw5pqZmVow6lydMOzLCBGxZF0w6lyIDEsIDQyNDQ!5e0!3m2!1shu!2shu!4v1723550600846!5m2!1shu!2shu"></iframe>
            </div>
        </div>
    </div>

<?php include("includes/footer.php");?>
