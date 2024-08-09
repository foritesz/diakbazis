<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookie Felugró Ablak Kategóriákkal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .cookie-container {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background-color: #333;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            display: none; /* Alapértelmezés szerint elrejtve */
            flex-direction: column;
            justify-content: space-between;
            z-index: 1000;
        }

        .cookie-container p {
            margin: 0;
            font-size: 16px;
        }

        .cookie-buttons {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .cookie-btn, .details-btn {
            background-color: #ff9900;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 10px;
        }

        .details {
            margin-top: 15px;
            background-color: #444;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }

        .details h4 {
            margin-top: 10px;
            margin-bottom: 5px;
            font-size: 18px;
            color: #ffcc00;
        }
    </style>
</head>
<body>

    <div class="cookie-container" id="cookie-container">
        <p>Ez a weboldal sütiket használ a legjobb élmény biztosítása érdekében.</p>
        
        <div class="details" id="details">
            <h4>Funkcionális sütik</h4>
            <p>Ezek a sütik szükségesek a weboldal alapvető funkcióinak biztosításához.</p>
        </div>

        <div class="cookie-buttons">
            <button class="details-btn" onclick="toggleDetails()">Részletek</button>
            <button class="cookie-btn" onclick="acceptCookies()">Elfogadom az összeset</button>
        </div>
    </div>

    <script>

        function displayCookieCategories() {
            const categories = getCookieCategories();
            const detailsDiv = document.getElementById('details');

            for (const [category, cookies] of Object.entries(categories)) {
                if (cookies.length > 0) {
                    const categoryTitle = document.createElement('h4');
                    categoryTitle.innerText = category;
                    detailsDiv.appendChild(categoryTitle);

                    const cookieList = document.createElement('p');
                    cookieList.innerText = cookies.join(", ");
                    detailsDiv.appendChild(cookieList);
                }
            }
        }

        function acceptCookies() {
            document.getElementById('cookie-container').style.display = 'none';
            localStorage.setItem('cookiesAccepted', 'true');
        }

        function toggleDetails() {
            const details = document.getElementById('details');
            details.style.display = details.style.display === 'none' ? 'block' : 'none';
        }

        window.onload = function() {
            if (localStorage.getItem('cookiesAccepted')) {
                document.getElementById('cookie-container').style.display = 'none';
            } else {
                document.getElementById('cookie-container').style.display = 'flex';
                displayCookieCategories();
            }
        }
    </script>

</body>
</html>
