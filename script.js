function toggleDropdown(event) {
    event.preventDefault(); // Ezzel megelőzzük az alapértelmezett működést

    // Bezárjuk az összes lenyíló tartalmat
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
        }
    }

    // Megnyitjuk az aktuális lenyíló tartalmat
    var dropdownContent = event.target.nextElementSibling;
    dropdownContent.classList.toggle("show");
}

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
function toggleCategory(id) {
    var element = document.getElementById(id);
    if (element.style.display === "none" || element.style.display === "") {
        element.style.display = "block";
    } else {
        element.style.display = "none";
    }
}

function toggleMenu() {
    var dropdownContainer = document.querySelector('.dropdown-container');
    if (dropdownContainer.classList.contains('active')) {
        dropdownContainer.classList.remove('active');
    } else {
        dropdownContainer.classList.add('active');
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

