function toggleCategory(id) {
  var element = document.getElementById(id);
  if (element.style.display === "none" || element.style.display === "") {
      element.style.display = "block";
  } else {
      element.style.display = "none";
  }
}

function toggleMenu() {
  var dropdown = document.querySelector('.dropdown-menu.dropdown');
  if (dropdown.classList.contains('active')) {
      dropdown.classList.remove('active');
  } else {
      dropdown.classList.add('active');
  }
}

function toggleSearchBar() {
  var searchBar = document.querySelector('.search-bar');
  if (searchBar.classList.contains('active')) {
      searchBar.classList.remove('active');
  } else {
      searchBar.classList.add('active');
  }
}

window.addEventListener('load', function() {
  if (window.innerWidth <= 1024) {
      var subcategories = document.querySelectorAll('.subcategory');
      subcategories.forEach(function(subcategory) {
          subcategory.style.display = "none";
      });
  }

  // Remove skeleton class after loading
  setTimeout(function() {
      var skeletons = document.querySelectorAll('.skeleton');
      skeletons.forEach(function(skeleton) {
          skeleton.classList.remove('skeleton');
      });

      // Show content after skeletons are removed
      document.querySelector('body').classList.remove('loading');
  }, 3000); // Adjust the timeout as needed
});