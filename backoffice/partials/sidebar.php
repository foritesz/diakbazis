<!-- Sticky Top Menu -->
<div class="container-fluid bg-secondary menu sticky-top">
  <div class="row">
    <div class="col-sm-2">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link shortname" href="#">Acronym</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Full Name</a>
        </li>
      </ul>
    </div>
    <div class="col-sm-6">
      <ul class="nav">
        <li class="nav-item">
          <h4 class="text-light" style="position: relative;top: 8px">Admin Panel</h4>
        </li>
      </ul>
    </div>
    <div class="col-sm-4">
      <ul class="nav justify-content-end">
        <li class="nav-item">
          <a href="dashboard.php?cat=setting&subcat=admin-panel" class="nav-link content-link" title="setting"><i class='fas fa-cog'></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php" title="logout"><i class='fas fa-sign-out-alt'></i></a>
        </li>
      </ul>
    </div>
  </div>
</div>

<!-- Main navigation -->
<nav class="navbar bg-light main-menu sticky-top">
  <div class="container-fluid">
    <ul class="navbar-nav flex-row">
      <li class="nav-item">
        <a class="nav-link content-link" href="dashboard.php"><i class='fas fa-home'></i> Dashboard</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="productsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class='fas fa-cog'></i> Termékek
        </a>
        <div class="dropdown-menu" aria-labelledby="productsDropdown">
          <a class="dropdown-item" href="dashboard.php?cat=product-crud&subcat=admin_page">Termék kezelése</a>
          <a class="dropdown-item" href="dashboard.php?cat=product-crud&subcat=filter_page">Kategóriák kezelése</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="websiteSettingDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class='fas fa-cog'></i> Website Setting
        </a>
        <div class="dropdown-menu" aria-labelledby="websiteSettingDropdown">
          <a class="dropdown-item" href="dashboard.php?cat=website-setting&subcat=website-menu">Website Menu</a>
          <a class="dropdown-item" href="dashboard.php?cat=website-setting&subcat=website-setting">Website-Setting</a>
          <a class="dropdown-item" href="dashboard.php?cat=website-setting&subcat=theme-setting">Theme Setting</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="contactUsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class='fas fa-envelope'></i> Contact Us
        </a>
        <div class="dropdown-menu" aria-labelledby="contactUsDropdown">
          <a class="dropdown-item" href="dashboard.php?cat=contact&subcat=contact-details">Contact Detail</a>
          <a class="dropdown-item" href="dashboard.php?cat=contact&subcat=contact-us-message">Contact Message</a>
          <a class="dropdown-item" href="dashboard.php?cat=contact&subcat=contact-email">Contact Email</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="websiteContentDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class='fas fa-file-alt'></i> Website Content
        </a>
        <div class="dropdown-menu" aria-labelledby="websiteContentDropdown">
          <a class="dropdown-item" href="dashboard.php?cat=website-content&subcat=home-content">Home Content</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="websiteAdminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class='fas fa-user-cog'></i> Website Admin
        </a>
        <div class="dropdown-menu" aria-labelledby="websiteAdminDropdown">
          <a class="dropdown-item" href="dashboard.php?cat=website-admin&subcat=admin-profile">Admin Profile</a>
          <a class="dropdown-item" href="dashboard.php?cat=website-admin&subcat=change-password">Change Password</a>
        </div>
      </li>
    </ul>
  </div>
</nav>

<!-- Content goes here -->
<div class="container-fluid">
  <!-- Your page content -->
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJAK/lAxT5d3wblKcz0M7+6Im9xCZUyJHs6fo5w5ku4E6QLLa" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
