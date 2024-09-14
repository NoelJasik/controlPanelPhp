<?php

$servername = "localhost";
$username = "root";
$password = "";
$databaseName = "controlPanelPhp";

$conn = mysqli_connect($servername, $username, $password, $databaseName);


function markAsCompleted($conn, $order_id)
{
    global $isQuerySuccessfull;
    $stmt = $conn->prepare("UPDATE orders SET completed = 1 WHERE id = ?");
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        $isQuerySuccessfull = true;
    } else {
        $isQuerySuccessfull = false;
    }

    $stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    markAsCompleted($conn, $order_id);
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
            echo "Zamówienie zostało oznaczone jako zakończone";
        } else {
            echo "Wystąpił błąd podczas oznaczania zamówienia jako zakończone";
        }
        ?></h2>
        <a href="../index.php" class="btn">Ekran logowania</a>
    </div>
    <footer>
        <p>© 2024 - Noel Jasik</p>
    </footer>
</body>

</html>