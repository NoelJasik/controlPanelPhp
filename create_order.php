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
    $stmt = $conn->prepare("INSERT INTO clients (name, last_name, email, telephone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $last_name, $email, $phone);

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
    $time = $_POST['time'];
    $toggle_client = $_POST['toggle_client'];

    if (!$toggle_client) {
        $name = $_POST['client_name'];
        $last_name = $_POST['client_last_name'];
        $phone = $_POST['client_email'];
        $email = $_POST['client_telephone'];
        createClient($conn, $name, $last_name, $phone, $email);
        $client_id = $conn->insert_id;
        createOrder($conn, $employee_id, $client_id, $service_id, $date . ' ' . $time);
    } else {
        createOrder($conn, $employee_id, $client_id, $service_id, $date . ' ' . $time);
    }
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