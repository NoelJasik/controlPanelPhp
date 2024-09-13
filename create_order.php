<?php

$servername = "localhost";
$username = "root";
$password = "";
$databaseName = "controlPanelPhp";

$conn = mysqli_connect($servername, $username, $password, $databaseName);


function createOrder($conn, $employee_id, $client_id, $service_id, $date)
{
    $completed = 0;
    $stmt = $conn->prepare("INSERT INTO orders (employee_id, client_id, service_id, date, completed) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisi", $employee_id, $client_id, $service_id, $date, $completed);

    if ($stmt->execute()) {
        echo "New order created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

function createClient($conn, $name, $last_name, $phone, $email)
{
    $stmt = $conn->prepare("INSERT INTO clients (name, phone, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $last_name, $phone, $email);

    if ($stmt->execute()) {
        echo "New client created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $client_id = $_POST['client_id'];
    $service_id = $_POST['service_id'];
    $date = $_POST['date'];
    $toggle_client = $_POST['toggle_client'];



    createOrder($conn, $employee_id, $client_id, $service_id, $date);
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