<?php
$servername = "localhost";
$username = "root";
$password = "";
$databaseName = "controlPanelPhp";

$conn = mysqli_connect($servername, $username, $password, $databaseName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$queries = [
    'clients' => "SELECT * FROM clients",
    'employees' => "SELECT * FROM employees",
    'orders' => "SELECT * FROM orders",
    'roles' => "SELECT * FROM roles",
    'services' => "SELECT * FROM services"
];

$resultClients = $conn->query($queries['clients']);
$resultEmployees = $conn->query($queries['employees']);
$resultOrders = $conn->query($queries['orders']);
$resultRoles = $conn->query($queries['roles']);
$resultServices = $conn->query($queries['services']);

$tableClients = [];
while ($row = $resultClients->fetch_assoc()) {
    $tableClients[] = $row;
}

$tableEmployees = [];
while ($row = $resultEmployees->fetch_assoc()) {
    $tableEmployees[] = $row;
}

$tableOrders = [];
while ($row = $resultOrders->fetch_assoc()) {
    $tableOrders[] = $row;
}

$tableRoles = [];
while ($row = $resultRoles->fetch_assoc()) {
    $tableRoles[] = $row;
}

$tableServices = [];
while ($row = $resultServices->fetch_assoc()) {
    $tableServices[] = $row;
}



$conn->close();

echo "Connected successfully";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Sterowania</title>
</head>

<body>
    <h2>Clients</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Telephone</th>
        </tr>
        <?php foreach ($tableClients as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['telephone']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Employees</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Last name</th>
            <th>Role ID</th>
        </tr>
        <?php foreach ($tableEmployees as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['role_id']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Roles</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Role</th>
            <th>Salary</th>
        </tr>
        <?php foreach ($tableRoles as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['hourly_wage']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Services</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Service</th>
            <th>Price</th>
            <th>Service time</th>
        </tr>
        <?php foreach ($tableServices as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['service_time']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Orders</h2>
    <table border="1">
        <tr>
            <th>Index</th>
            <th>Employee</th>
            <th>Client</th>
            <th>Service</th>
            <th>Date</th>
            <th></th>
        </tr>
        <?php foreach ($tableOrders as $row): 
            if($row['completed'] == 0) :
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $tableEmployees[$row['employee_id'] - 1]['name'] . ' ' . $tableEmployees[$row['employee_id'] - 1]['last_name']; ?></td>
                <td><?php echo $tableClients[$row['client_id'] - 1]['name'] . ' ' . $tableClients[$row['client_id'] - 1]['last_name']; ?></td>
                <td><?php echo $tableServices[$row['service_id'] - 1]['name']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <form action="complete_order.php" method="post">
                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                    <td><input type="submit" value="Complete"></td>
                </form>
            </tr>
        <?php endif; endforeach; ?>
    </table>

    <h2>Create New Order</h2>
    <form action="create_order.php" method="post">
        <label for="employee_id">Employee:</label>
        <select name="employee_id" id="employee_id">
            <?php foreach ($tableEmployees as $employee): ?>
                <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name'] . ' ' . $employee['last_name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label for="toggle_client">Use Existing Client:</label>
        <input type="checkbox" id="toggle_client" name="toggle_client" onclick="toggleClientFields()">
        <br>

        <div id="existing_client_fields" style="display: none;">
            <label for="client_id">Client:</label>
            <select name="client_id" id="client_id">
            <?php foreach ($tableClients as $client): ?>
                <option value="<?php echo $client['id']; ?>"><?php echo $client['name'] . ' ' . $client['last_name']; ?></option>
            <?php endforeach; ?>
            </select>
            <br>
        </div>

        <div id="new_client_fields">
            <label for="client_name">Name:</label>
            <input type="text" name="client_name" id="client_name" required><br>

            <label for="client_last_name">Last Name:</label>
            <input type="text" name="client_last_name" id="client_last_name" required><br>

            <label for="client_email">Email:</label>
            <input type="email" name="client_email" id="client_email" required><br>

            <label for="client_telephone">Telephone:</label>
            <input type="text" name="client_telephone" id="client_telephone" required><br>
        </div>

        <script>
            function toggleClientFields() {
            var toggle = document.getElementById('toggle_client').checked;
            document.getElementById('existing_client_fields').style.display = toggle ? 'block' : 'none';
            document.getElementById('new_client_fields').style.display = toggle ? 'none' : 'block';
            }
        </script>


        <label for="service_id">Service:</label>
        <select name="service_id" id="service_id">
            <?php foreach ($tableServices as $service): ?>
                <option value="<?php echo $service['id']; ?>"><?php echo $service['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>



        <label for="date">Date:</label>
        <label for="date">Date:</label>
        <input type="date" name="date" id="date"><br>

        <label for="time">Time:</label>
        <input type="time" name="time" id="time"><br>


        <input type="submit" value="Create Order">
    </form>
</body>

</html>