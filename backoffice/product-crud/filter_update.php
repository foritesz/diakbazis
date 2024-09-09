<style>

.container {
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.admin-product-form-container {
    width: 100%;
}



h3.title {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}



.box {    
    display: flex;
    width: 100%;
    max-width: 600px;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

select.box {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: #fff;
    cursor: pointer;
}

input.btn {
    width: 100%;
    max-width: 300px;
    padding: 10px;
    margin-top: 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

input.btn:hover {
    background-color: #0056b3;
}

a.btn {
    display: inline-block;
    padding: 10px 20px;
    margin-top: 20px;
    background-color: #6c757d;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

a.btn:hover {
    background-color: #5a6268;
}

span.message {
    display: block;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    border-radius: 5px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Styling for the labels */
label {
    width: 100%;
    max-width: 600px;
    margin: 10px 0 5px 0;
    text-align: left;
    font-size: 16px;
    color: #333;
}
</style>
<?php

@include 'config.php';

$id = $_GET['edit'];

if (isset($_POST['update_category'])) {
    $category_name = $_POST['category_name'];
    $menu_category = $_POST['menu_category'];
    $subcategory_name = $_POST['subcategory_name'];

    // Initialize the update query
    $update_data = "UPDATE categories SET ";

    // Add fields to update only if they are not empty
    $update_fields = [];
    if (!empty($category_name)) {
        $update_fields[] = "category_name='$category_name'";
    }
    if (!empty($menu_category)) {
        $update_fields[] = "menu_category='$menu_category'";
    }
    if (!empty($subcategory_name)) {
        $update_fields[] = "subcategory='$subcategory_name'";
    }

    // Combine the fields to the update query
    if (!empty($update_fields)) {
        $update_data .= implode(", ", $update_fields) . " WHERE category_id = '$id'";

        $upload = mysqli_query($conn, $update_data);

        if ($upload) {
            $message[] = 'Kategória Módosítva!';
        } else {
            //$message[] = 'Error.' . mysqli_error($conn);
        }
    } else {
        $message[] = 'Hiba történt a módosítás során!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Kategória Módosítása</title>
</head>
<body>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<span class="message">' . $msg . '</span>';
    }
}
?>

<div class="container">
    <div class="admin-product-form-container centered">

    <?php
    $select = mysqli_query($conn, "SELECT * FROM categories WHERE category_id = '$id'");
    while ($row = mysqli_fetch_assoc($select)) {
    ?>

    <form action="" method="post" class="category">
        <h3 class="title">Update the Category</h3>
        <label for="category_name">Kategória Átnevezése</label>
        <input type="text" class="box" id="category_name" name="category_name" value="<?php echo $row['category_name']; ?>" placeholder="Enter the category name">
        <label for="category_name">Válasszon Kategóriát</label>
        <select name="category_name" id="category_name" class="box" required>
            <option value="<?php echo $row['category_name']; ?>" selected="selected"><?php echo $row['category_name']; ?></option>
            <?php
            $categories_query = mysqli_query($conn, "SELECT DISTINCT category_name FROM categories");
            while ($category_row = mysqli_fetch_assoc($categories_query)) {
                echo '<option value="'.$category_row['category_name'].'">'.$category_row['category_name'].'</option>';
            }
            ?>
        </select>

        <label for="menu_category">Válasszon Menü Kategóriát</label>
        <select name="menu_category" id="menu_category" class="box" required>
            <option value="<?php echo $row['menu_category']; ?>" selected="selected"><?php echo $row['menu_category']; ?></option>
            <option value="Papír-Írószer">Papír-Írószer</option>
            <option value="Kreatív">Kreatív</option>
            <option value="Játék">Játék</option>
            <option value="Ajándék">Ajándék</option>
            <option value="Könyv">Könyv</option>
            <option value="Táska-Pénztárca">Táska-Pénztárca</option>
            <option value="Cipő">Cipő</option>
            <option value="Háztartási cikkek">Háztartási cikkek</option>
            <option value="Szezonális">Szezonális</option>
            <option value="Óra">Óra</option>
            <option value="Szolgáltatás">Szolgáltatás</option>
        </select>
        
        <label for="subcategory_name">Válasszon Alkategórát</label>
        <select name="subcategory_name" id="subcategory_name" class="box" required>
            <option value="<?php echo $row['subcategory']; ?>" selected="selected"><?php echo $row['subcategory']; ?></option>
            <?php
            $subcategories_query = mysqli_query($conn, "SELECT DISTINCT subcategory FROM categories");
            while ($subcategory_row = mysqli_fetch_assoc($subcategories_query)) {
                echo '<option value="'.$subcategory_row['subcategory'].'">'.$subcategory_row['subcategory'].'</option>';
            }
            ?>
        </select>
        <label for="category_name">AlKategória Átnevezése</label>
        <input type="text" class="box" name="subcategory_name" value="<?php echo $row['subcategory']; ?>" placeholder="Enter the subcategory name">
        <input type="submit" value="Módosítás" name="update_category" class="btn">
        <a href="dashboard.php?cat=product-crud&subcat=filter_page" class="btn">Vissza</a>
    </form>

    <?php } ?>

    </div>
</div>

</body>
</html>

