<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
        margin-bottom: 50px;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
    
    img{
    width: 100%;
    display: block;
}

    @media only screen and (max-width: 500px) {
  .descrition {
    width: 100%;
  }
}

@media only screen and (max-width: 500px) {
  .right {
    width: 100%;
  }
}

.column {
  float: left;
  width: 33.33%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

@media (max-width: 600px) {
  .column {
    width: 100%;
  }
}

  </style>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Products</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class = "main-wrapper">
  <div class = "container">
  <?php
  session_start();
$ID=$_GET['category'];
$_SESSION['category']=$_GET['category'];
if($ID)
{
  $conn = mysqli_connect("localhost", "root","12345678", "products");
		if (!$conn) {die("Hiba: " . mysqli_connect_error());}
		$sql = "SELECT category_name
        FROM categories
        WHERE id ='$ID'";
		//echo $sql;
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {	
  echo '<div class = "product-div">
          <div class = "product-div-left">
              <div class = "img-container">
                  <img src = "images/'.$row["image"].'" alt="'.$row["image"].'">
              </div>
              <div class = "hover-container">
                  <div><img src = "images/'.$row["image"].'" alt="'.$row["image"].'"></div>
                  <div><img src = "'.$row["image"].'" alt="'.$row["image"].'"></div>
                  <div><img src = "'.$row["image"].'" alt="'.$row["image"].'"></div>
                  <div><img src = "'.$row["image"].'" alt="'.$row["image"].'"></div>
                  <div><img src = "'.$row["image"].'" alt="'.$row["image"].'"></div>
              </div>
          </div>
          <div class = "product-div-right">
              <span class = "product-name">'.$row["category_name"].'</span>
              <span class = "product-price">$ 50.25</span>
              <p class = "product-description">'.$row["category_name"].'</p>
              <div class = "btn-groups">
                  <button type = "button" class = "add-cart-btn"><i class = "fas fa-shopping-cart"></i>add to cart</button>
                  <button type = "button" class = "buy-now-btn"><i class = "fas fa-wallet"></i>buy now</button>
              </div>
          </div>
      </div>';
      }
    }
  }
  else {
			
  }
		mysqli_close($conn);
?>
  </div>
</div>

<section class="product"> 
  <h2 class="product-category">best selling</h2>
  <button class="pre-btn"><img src="images/arrow.png" alt=""></button>
  <button class="nxt-btn"><img src="images/arrow.png" alt=""></button>
  <div class="product-container">
      <div class="product-card">
          <div class="product-image">
              
              <img src="images/card1.jpg" class="product-thumb" alt="">
              <button class="card-btn">add to wishlist</button>
          </div>
          <div class="product-info">
              <h2 class="product-brand">brand</h2>
              <p class="product-short-description">a short line about the cloth..</p>
          </div>
      </div>
      <div class="product-card">
          <div class="product-image">
              
              <img src="images/card2.jpg" class="product-thumb" alt="">
              <button class="card-btn">add to wishlist</button>
          </div>
          <div class="product-info">
              <h2 class="product-brand">brand</h2>
              <p class="product-short-description">a short line about the cloth..</p>                
          </div>
      </div>
      <div class="product-card">
          <div class="product-image">
              <img src="images/card3.jpg" class="product-thumb" alt="">
              <button class="card-btn">add to wishlist</button>
          </div>
          <div class="product-info">
              <h2 class="product-brand">brand</h2>
              <p class="product-short-description">a short line about the cloth..</p>
              
          </div>
      </div>
      <div class="product-card">
          <div class="product-image">
              <img src="images/card4.jpg" class="product-thumb" alt="">
              <button class="card-btn">add to wishlist</button>
          </div>
          <div class="product-info">
              <h2 class="product-brand">brand</h2>
              <p class="product-short-description">a short line about the cloth..</p>               
          </div>
      </div>
      <div class="product-card">
          <div class="product-image">
              <img src="images/card5.jpg" class="product-thumb" alt="">
              <button class="card-btn">add to wishlist</button>
          </div>
          <div class="product-info">
              <h2 class="product-brand">brand</h2>
              <p class="product-short-description">a short line about the cloth..</p>                
          </div>
      </div>
      <div class="product-card">
          <div class="product-image">
              <img src="images/card6.jpg" class="product-thumb" alt="">
              <button class="card-btn">add to wishlist</button>
          </div>
          <div class="product-info">
              <h2 class="product-brand">brand</h2>
              <p class="product-short-description">a short line about the cloth..</p>
              
          </div>
      </div>
      <div class="product-card">
          <div class="product-image">
              <img src="images/card7.jpg" class="product-thumb" alt="">
              <button class="card-btn">add to wishlist</button>
          </div>
          <div class="product-info">
              <h2 class="product-brand">brand</h2>
              <p class="product-short-description">a short line about the cloth..</p>
              
          </div>
      </div>
      <div class="product-card">
          <div class="product-image">
              <img src="images/card8.jpg" class="product-thumb" alt="">
              <button class="card-btn">add to wishlist</button>
          </div>
          <div class="product-info">
              <h2 class="product-brand">brand</h2>
              <p class="product-short-description">a short line about the cloth..</p>                 
          </div>
      </div>
      <div class="product-card">
          <div class="product-image">
              <img src="images/card9.jpg" class="product-thumb" alt="">
              <button class="card-btn">add to wishlist</button>
          </div>
          <div class="product-info">
              <h2 class="product-brand">brand</h2>
              <p class="product-short-description">a short line about the cloth..</p>               
          </div>
      </div>
      <div class="product-card">
          <div class="product-image">
              <img src="images/card10.jpg" class="product-thumb" alt="">
              <button class="card-btn">add to wishlist</button>
          </div>
          <div class="product-info">
              <h2 class="product-brand">brand</h2>
              <p class="product-short-description">a short line about the cloth..</p>
              
          </div>
      </div>
  </div>
</section>

<footer class="footer">
  <p>Online Store Copyright</p> 
</footer>


<script src="script.js"></script>
<script>
  let bigImg = document.querySelector('.big-img img');
  function showImg(pic){
      bigImg.src = pic;
  }
</script>


</body>
</html>
