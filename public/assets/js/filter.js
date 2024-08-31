// Function to update the URL based on checkbox selections
function updateURL() {
    // Get the current URL without the query string
    let baseURL = window.location.protocol + "//" + window.location.host + window.location.pathname;

    // Get the value of 'menucategory' from the initial URL parameters
    let urlParams = new URLSearchParams(window.location.search);
    let selectedMenuCategory = urlParams.get('menucategory');

    // Get all checkbox elements
    let checkboxes = document.querySelectorAll('.subcategory input[type="checkbox"]');

    // Collect selected checkbox values
    let alkategoriaParams = [];
    for (let checkbox of checkboxes) {
        if (checkbox.checked) {
            alkategoriaParams.push(checkbox.value);
        }
    }

    // Build the new URL with selected checkboxes
    let newURL = baseURL + "?menucategory=" + encodeURIComponent(selectedMenuCategory);
    if (alkategoriaParams.length > 0) {
        newURL += "&alkategoria=" + alkategoriaParams.map(encodeURIComponent).join('&alkategoria=');
    }

    // Update the browser's URL without reloading the page
    history.replaceState({}, document.title, newURL);

    // Set the hidden input value to the modified URL
    document.getElementById("modifiedURL").value = newURL;
}

// Add change event listeners to all checkbox elements
let checkboxes = document.querySelectorAll('.subcategory input[type="checkbox"]');
for (let checkbox of checkboxes) {
    checkbox.addEventListener("change", updateURL);
}

// Highlight checkboxes based on URL parameters
function highlightCheckboxesFromURL() {
    let urlParams = new URLSearchParams(window.location.search);
    let alkategoriaFromURL = urlParams.getAll('alkategoria');

    // Highlight checkboxes based on 'alkategoria' values in the URL
    for (let checkbox of checkboxes) {
        if (alkategoriaFromURL.includes(checkbox.value)) {
            checkbox.checked = true;
        }
    }
}

// Initialize the URL and highlight checkboxes on page load
highlightCheckboxesFromURL();
updateURL();







