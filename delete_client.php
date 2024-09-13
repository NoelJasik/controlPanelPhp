<?php

$servername = "localhost";
$username = "root";
$password = "";
$databaseName = "controlPanelPhp";

$conn = mysqli_connect($servername, $username, $password, $databaseName);


function removeClient($conn, $order_id)
{
    $stmt = $conn->prepare("DELETE FROM clients WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    
    if ($stmt->execute()) {
        echo "Client removed successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['client_id'];
    removeClient($conn, $order_id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="index.php">Return</a>
</body>

</html>