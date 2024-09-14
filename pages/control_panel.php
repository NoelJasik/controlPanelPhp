<?php
$servername = "localhost";
$username = "";
$password = "";
$databaseName = "controlPanelPhp";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
}

$conn = mysqli_connect($servername, $username, $password, $databaseName);

if (!$conn) {
    die("Połączenie nieudane: " . mysqli_connect_error());
}

$queries = [
    'clients' => "SELECT * FROM clients",
    'employees' => "SELECT employees.*, roles.name as role_name FROM employees INNER JOIN roles ON employees.role_id = roles.id",
    'orders' => "SELECT orders.*, employees.name as employee_name, employees.last_name as employee_last_name, clients.name as client_name, clients.last_name as client_last_name, services.name as service_name FROM orders INNER JOIN employees ON orders.employee_id = employees.id INNER JOIN clients ON orders.client_id = clients.id INNER JOIN services ON orders.service_id = services.id",
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
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Sterowania</title>
    <link rel="stylesheet" href="../css/index.css">

</head>

<body>
    <header>
        <h1>Panel Sterowania - <?php echo $username ?> </h1>
        <a class="btn" href="../index.php">Wyloguj się</a>
    </header>
    <main>
        <div class="table-box">
            <h2>Usługi</h2>
            <table>
                <tr>
                    <th>Usługa</th>
                    <th>Cena</th>
                    <th>Czas usługi</th>
                </tr>
                <?php foreach ($tableServices as $row): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['service_time']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="table-box">
            <h2>Pracownicy</h2>
            <table>
                <tr>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Rola</th>
                </tr>
                <?php foreach ($tableEmployees as $row): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['role_name']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <!-- 
    <h2>Role</h2>
    <table border="1">
        <tr>
            <th>Rola</th>
            <th>Wynagrodzenie</th>
        </tr>
        <?php foreach ($tableRoles as $row): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['hourly_wage']; ?></td>
                </form>
            </tr>
        <?php endforeach; ?>
    </table> -->
        <div class="table-box">
            <h2>Klienci</h2>
            <table>
                <tr>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Email</th>
                    <th>Nr. telefonu</th>
                    <th>Usuń</th>
                    <th>Edytuj</th>
                </tr>
                <?php foreach ($tableClients as $row): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['telephone']; ?></td>
                        <form action="delete_entry.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="table" value="clients">
                            <td><input type="submit" value="Usuń" class="btn"></td>
                        </form>
                        <form action="update_entry.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="table" value="clients">
                            <td><input type="submit" value="Edytuj" class="btn"></td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="table-box">
            <h2>Zamówienia</h2>
            <table>
                <tr>
                    <th>Lp.</th>
                    <th>Pracownik</th>
                    <th>Klient</th>
                    <th>Usługa</th>
                    <th>Data</th>
                    <th>Zakończ</th>
                    <th>Usuń</th>
                    <th>Edytuj</th>
                </tr>
                <?php foreach ($tableOrders as $row):
                    if ($row['completed'] == 0) :
                ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['employee_name'] . ' ' . $row['employee_last_name']; ?></td>
                            <td><?php echo $row['client_name'] . ' ' . $row['client_last_name']; ?></td>
                            <td><?php echo $row['service_name']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <form action="complete_order.php" method="post">
                                <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                <td><input type="submit" value="Zakończ" class="btn"></td>
                            </form>
                            <form action="delete_entry.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="table" value="orders">
                                <td><input type="submit" value="Usuń" class="btn"></td>
                            </form>
                            <form action="update_entry.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="table" value="orders">
                                <td><input type="submit" value="Edytuj" class="btn"></td>
                            </form>
                        </tr>
                <?php endif;
                endforeach; ?>
            </table>
        </div>
        <div class="table-box create-order">
            <h2>Utwórz nowe zamówienie</h2>
            <form action="create_order.php" method="post">

                <div class="form-box">
                    <label for="employee_id">Pracownik:</label>
                    <select name="employee_id" id="employee_id" class="btn">
                        <?php foreach ($tableEmployees as $employee): ?>
                            <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name'] . ' ' . $employee['last_name']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="service_id">Usługa:</label>
                    <select name="service_id" id="service_id" class="btn">
                        <?php foreach ($tableServices as $service): ?>
                            <option value="<?php echo $service['id']; ?>"><?php echo $service['name']; ?></option>
                        <?php endforeach; ?>
                    </select>


                    <label for="date">Data:</label>
                    <input required type="date" name="date" id="date" class="btn">

                    <label for="time">Czas:</label>
                    <input required type="time" name="time" id="time" class="btn">
                </div>

                <div class="form-box">


                    <div id="existing_client_fields" class="client-info-box" style="display: flex;">
                        <label for="client_id">Klient:</label>
                        <select name="client_id" id="client_id" class="btn">
                            <?php foreach ($tableClients as $client): ?>
                                <option value="<?php echo $client['id']; ?>"><?php echo $client['name'] . ' ' . $client['last_name']; ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>

                    <div id="new_client_fields" class="client-info-box" style="display: none">
                        <label for="client_name">Imię:</label>
                        <input type="text" name="client_name" id="client_name" class="btn">

                        <label for="client_last_name">Nazwisko:</label>
                        <input type="text" name="client_last_name" id="client_last_name" class="btn">

                        <label for="client_email">Email:</label>
                        <input type="email" name="client_email" id="client_email" class="btn">

                        <label for="client_telephone">Telefon:</label>
                        <input type="text" name="client_telephone" id="client_telephone" class="btn">

                    </div>




                </div>
                <div class="form-box">
                <label for="toggle_client">Użyj istniejącego klienta: <input type="checkbox" id="toggle_client" name="toggle_client" onclick="toggleClientFields()">
                </label>
                <input type="submit" value="Utwórz zamówienie" class="btn">
            </div>
            </form>
 
        </div>

    </main>
    <footer>
        <p>© 2024 - Noel Jasik</p>
        
    </footer>
    <script>
        function toggleClientFields() {
            var toggle = document.getElementById('toggle_client').checked;
            document.getElementById('existing_client_fields').style.display = toggle ? 'flex' : 'none';
            document.getElementById('new_client_fields').style.display = toggle ? 'none' : 'flex';
        }

        toggleClientFields();
    </script>
</body>

</html>