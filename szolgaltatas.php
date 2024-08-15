<?php
include("Product.php");
include("navbar.php");
include("cookie.php");
$product = new Product();
$subcategories = $product->getMenucategory();
$totalRecords = $product->getTotalProducts();
$ide = $product->getCategories();
?>

    <main>
        <section class="services">
            <div class="service-box">
                <h2>Nyomtatási és fénymásolási szolgáltatások</h2>
                <p>Fekete-fehér és színes nyomtatás, fénymásolás, poszterek és nagy formátumú nyomtatás.</p>
            </div>
            <div class="service-box">
                <h2>Laminálás és spirálozás</h2>
                <p>Dokumentumok laminálása, spirálkötés és könyvkötés, névjegykártyák készítése.</p>
            </div>
            <div class="service-box">
                <h2>Egyedi bélyegzőkészítés</h2>
                <p>Bélyegzők tervezése és gyártása személyre szabott szöveggel vagy logóval.</p>
            </div>
            <div class="service-box">
                <h2>Fotónyomtatás és fényképkidolgozás</h2>
                <p>Digitális fotók nyomtatása különböző méretekben, fotókönyvek, vászonképek készítése.</p>
            </div>
        </section>
    </main>
<?php include("footer.php");?>
