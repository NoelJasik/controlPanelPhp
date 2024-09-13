<?php

$servername = "localhost";
$username = "root";
$password = "";
$databaseName = "controlPanelPhp";

$conn = mysqli_connect($servername, $username, $password, $databaseName);


function removeClient($conn, $id, $table)
{
    $stmt = $conn->prepare("DELETE FROM " . $table . " WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Item ID: " . $id . " from " . $table . " removed successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $table = $_POST['table'];
    removeClient($conn, $id, $table);
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
<a href="../index.php">Return</a>

</body>

</html>