<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Átirányítás gombbal</title>
</head>
<body>
    <form method="post">
        <button type="submit" name="redirect">Menj az index.php oldalra</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['redirect'])) {
        header('Location: index4.php');
        exit();
    }
    ?>
</body>
</html>
