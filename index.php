<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/login.css">

</head>

<body>
<header>
        <h1>Panel Sterowania - Logowanie </h1>
    </header>
        <form class="login-box" action="pages/control_panel.php" method="post">
            <label for="username">Nazwa użytkownika:</label><br>
            <input type="text" class="btn" id="username" name="username"><br>
            <label for="password">Hasło:</label><br>
            <input type="password" class="btn" id="password" name="password"><br><br>
            <input type="submit" class="btn" value="Submit">
        </form>

    <footer>
        <p>© 2024 - Noel Jasik</p>
    </footer>
</body>

</html>