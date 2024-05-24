<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>URL módosítás</title>
</head>
<body>

  <input type="checkbox" class="alkategoriaCheckbox" value="Vonalas"> Vonalas
  <input type="checkbox" class="alkategoriaCheckbox" value="Egyéb"> Egyéb
  <!-- További checkbox-okat itt adhatsz hozzá -->

  <script>
    function updateURL() {
      // Jelenlegi URL lekérése
      let currentURL = window.location.href;

      // Checkbox elemek lekérése
      let checkboxes = document.getElementsByClassName("alkategoriaCheckbox");

      // Ellenőrzés, hogy legalább egy checkbox ki van-e pipálva
      let anyCheckboxChecked = false;

      // Az URL-ből az összes alkategoria eltávolítása
      currentURL = currentURL.replace(/&alkategoria=[^&]*/g, '');

      // Ellenőrzés és alkategoria hozzáadása az URL-hez
      for (let checkbox of checkboxes) {
        if (checkbox.checked) {
          anyCheckboxChecked = true;
          let alkategoriaValue = checkbox.getAttribute("value");
          currentURL += "&alkategoria=" + alkategoriaValue;
        }
      }

      // Ha egyetlen checkbox sem pipálva, akkor az összes alkategoria eltávolítása
      if (!anyCheckboxChecked) {
        currentURL = currentURL.replace(/&alkategoria=[^&]*/g, '');
      }

      // Frissíti az URL-t
      history.replaceState({}, document.title, currentURL);
    }

    // Checkbox változás eseménykezelő hozzárendelése minden checkbox-hoz
    let checkboxes = document.getElementsByClassName("alkategoriaCheckbox");
    for (let checkbox of checkboxes) {
      checkbox.addEventListener("change", updateURL);
    }

    // Az oldal betöltésekor inicializálja az URL-t
    updateURL();
  </script>

</body>
</html>
