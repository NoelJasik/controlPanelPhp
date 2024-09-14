<?php

$servername = "localhost";
$username = "root";
$password = "";
$databaseName = "controlPanelPhp";

$conn = mysqli_connect($servername, $username, $password, $databaseName);

function removeEntry($conn, $id, $table)
{
    global $isQuerySuccessfull;
    $stmt = $conn->prepare("DELETE FROM " . $table . " WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $isQuerySuccessfull = true;
    } else {
        $isQuerySuccessfull = false;
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $table = $_POST['table'];
    removeEntry($conn, $id, $table);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Sterowania</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/success.css">
</head>

<body>
    <header>
        <h1>Panel Sterowania - Sukcess </h1>
    </header>
    <div class="success-box">
        <h2><?php 
        if($isQuerySuccessfull){
            echo "Element o ID: " . htmlspecialchars($id) . " z tabeli " . htmlspecialchars($table) . " został pomyślnie usunięty";
        } else {
            echo "Wystąpił błąd podczas usuwania wpisu";
        }
        
        ?></h2>
        <a href="../index.php" class="btn">Ekran logowania</a>
    </div>
    <footer>
        <p>© 2024 - Noel Jasik</p>
    </footer>
</body>

</html>