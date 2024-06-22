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
            $message[] = 'Category updated successfully!';
        } else {
            $message[] = 'Could not update the category. Please try again.' . mysqli_error($conn);
        }
    } else {
        $message[] = 'No fields to update.';
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
    <title>Update Category</title>
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

    <form action="" method="post">
        <h3 class="title">Update the Category</h3>
        <input type="text" class="box" name="category_name" value="<?php echo $row['category_name']; ?>" placeholder="Enter the category name">
        <select name="menu_category" class="box" required>
            <option value="<?php echo $row['menu_category']; ?>" selected="selected"><?php echo $row['menu_category']; ?></option>
            <option value="Papír-Írószer">Papír-Írószer</option>
            <option value="Kreatív">Kreatív</option>
            <option value="Játék">Játék</option>
            <option value="Ajándék">Ajándék</option>
            <option value="Könyv">Könyv</option>
            <option value="Táska-Pénztárca">Táska-Pénztárca</option>
            <option value="Cipő">Cipő</option>
            <option value="Háztartási cikkek">Házatartási cikkek</option>
            <option value="Szezonális">Szezonális</option>
            <option value="Óra">Óra</option>
            <option value="Szolgáltatás">Szolgáltatás</option>
        </select>
        <select name="subcategory_name" class="box" required>
            <option value="<?php echo $row['subcategory']; ?>" selected="selected"><?php echo $row['subcategory']; ?></option>
            <?php
            $subcategories_query = mysqli_query($conn, "SELECT DISTINCT subcategory FROM categories");
            while ($subcategory_row = mysqli_fetch_assoc($subcategories_query)) {
                echo '<option value="'.$subcategory_row['subcategory'].'">'.$subcategory_row['subcategory'].'</option>';
            }
            ?>
        </select>
        <input type="text" class="box" name="subcategory_name" value="<?php echo $row['subcategory']; ?>" placeholder="Enter the subcategory name">
        <input type="submit" value="Update Category" name="update_category" class="btn">
        <a href="dashboard.php?cat=product-crud&subcat=filter_page" class="btn">Go Back!</a>
    </form>

    <?php } ?>

    </div>
</div>

</body>
</html>
