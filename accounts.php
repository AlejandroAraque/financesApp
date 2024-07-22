<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirige a la página de inicio de sesión si no está autenticado
    exit();
}


include("database.php");

// Obtiene el user_id 
$user_id = $_SESSION['user_id'];

// Consulta para obtener las cuentas del usuario
$sql_cuentas = "SELECT * FROM accounts WHERE user_id = $user_id";
$result_cuentas = $conn->query($sql_cuentas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finanzas App</title>
    <link rel="stylesheet" href="asset/css/estilos.css">
    <style>




    </style>    
</head>
<body>

    <header>
        <h1>Finances App</h1>
    </header>

    <nav>
    <a href="pagina_principal.php">Home</a>
        <a href="transacciones.php" >Transactions</a>
        <a href="accounts.php" class="active">Accounts</a>
        <a href="logout.php">Close session</a>
    </nav>

    

</head>
<body>

<h2 class="encabezado">My Accounts</h2>

<?php
// Verifica si hay cuentas
if ($result_cuentas->num_rows > 0) {
    echo "<table class='table_center' border='1'>";
    echo "<tr><th>ID</th><th>Name of the Account</th><th>Balance</th></tr>";

    // Itera sobre las filas de resultados
    while ($row = $result_cuentas->fetch_assoc()) {
        echo "<tr class='table_center'>";
        echo "<td class='table_center'>{$row['account_id']}</td>";
        echo "<td class='table_center'>{$row['account_name']}</td>";
        echo "<td class='table_center'>{$row['balance']}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron cuentas para este usuario.";
}


$conn->close();
?>

</body>
</html>
