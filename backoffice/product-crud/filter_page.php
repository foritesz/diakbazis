<?php
@include 'config.php';

if(isset($_POST['add_filter'])) {
   $menu_category = $_POST['menucategory'];
   $category_name = $_POST['category_name'];
   $subcategories = $_POST['subcategories'];

   if(empty($category_name) || empty($subcategories)) {
      $message[] = 'Please fill out all fields';
   } else {
      $subcategoriesArray = explode(',', $subcategories);
      foreach($subcategoriesArray as $subcategory_name) {
         $subcategory_name = trim($subcategory_name); // Trim whitespace from the subcategory name
         $insert = "INSERT INTO categories (category_name, subcategory, menu_category) VALUES ('$category_name', '$subcategory_name', '$menu_category')";
         $upload = mysqli_query($conn, $insert);
      }
      if($upload) {
         $message[] = 'Új kategória sikeresen felvéve!';
      } else {
         $message[] = 'Hiba a felvétel során! Error:'. mysqli_error($conn);
      }
   }
}

if(isset($_GET['delete'])) {
   $category_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM categories WHERE category_id = $category_id");
   header('Location: dashboard.php?cat=product-crud&subcat=filter_page');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>
   <!-- custom css file link  -->
   <link rel="stylesheet" href="product-crud/style.css">
   <script>
      function addSubcategory() {
         var subcategoryInput = document.getElementById('subcategory_name');
         var subcategory = subcategoryInput.value.trim();
         if(subcategory !== '') {
            var subcategoryList = document.getElementById('subcategory_list');
            var newItem = document.createElement('li');
            newItem.textContent = subcategory;
            subcategoryList.appendChild(newItem);
            subcategoryInput.value = '';

            // Update hidden input with subcategories
            var subcategoriesInput = document.getElementById('subcategories');
            subcategoriesInput.value += (subcategoriesInput.value === '' ? '' : ',') + subcategory;
         }
      }
   </script>
</head>
<body>

<?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}
?>
   
<div class="container">
   <div class="admin-product-form-container">
      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
         <h3>Kategória felvétele</h3>
         <label for="menucategory">Menü Kategória kiválasztása:</label>
         <select name="menucategory" id="menucategory" class="box" required>
         <option value="">Menü kategória</option>
            <option value="Papír-Írószer">Papír-Írószer</option>
            <option value="Kreatív">Kreatív</option>
            <option value="Játék">Játék</option>
            <option value="Ajándék">Ajándék</option>
            <option value="Könyv">Könyv</option>
            <option value="Táska-Pénztárca">Táska-Pénztárca</option>
            <option value="Cipő">Cipő</option>
            <option value="Házatrtási cikkek">Házatrtási cikkek</option>
            <option value="Szezonáli">Szezonális</option>
            <option value="Ór">Óra</option>
            <option value="Szolgáltatás">Szolgáltatás</option>
         <input type="text" placeholder="Kategoria neve" name="category_name" class="box" required>
         <input type="text" placeholder="Alkategoria" id="subcategory_name" class="box">
         <button type="button" onclick="addSubcategory()" class="btn">Alkategoria felvétele</button>
         <ul id="subcategory_list"></ul>
         <input type="hidden" name="subcategories" id="subcategories">
         <input type="submit" class="btn" name="add_filter" value="Kategória felvétele">
      </form>
   </div>

   <?php
   $select = mysqli_query($conn, "SELECT * FROM categories");
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>product name</th>
            <th>action</th>
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><?php echo $row['category_name']; ?> <br>
            <select name="topic" id="topic">
            <option value="" selected="selected"><?php echo $row['subcategory']; ?></option>
            </select> </td>
            <td>
               <a href="dashboard.php?cat=product-crud&subcat=filter_update&edit=<?php echo $row['category_id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
               <a href="dashboard.php?cat=product-crud&subcat=filter_page&delete=<?php echo $row['category_id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
            </td>
         </tr>
         <?php } ?>
      </table>
   </div>
</div>
</body>
</html>
