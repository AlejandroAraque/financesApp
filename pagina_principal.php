<?php

session_start();

$user_id = $_SESSION['user_id'];
include("database.php");

$sql_username = "SELECT username FROM users WHERE user_id = $user_id";
$result_username = $conn->query($sql_username);

if ($result_username->num_rows > 0) {
    $row_username = $result_username->fetch_assoc();
    $username = $row_username['username'];
} else {
    $username = "Usuario Desconocido"; // Si no se encuentra el nombre de usuario, utilizar un valor predeterminado
}

// Consulta SQL para obtener el saldo total
$sql = "SELECT balance FROM accounts WHERE user_id = $user_id";
$result_saldo = $conn->query($sql);
 
 if ($result_saldo->num_rows > 0) {
     $row = $result_saldo->fetch_assoc();
     $total_balance = $row['balance'];
 } else {
     $total_balance = 00; // Si no hay cuentas, el saldo total es cero
 }

 //INGRESOS
 $sql_cuenta= "SELECT account_id FROM accounts WHERE user_id = $user_id";
 $userAccount = $conn->query($sql_cuenta);

if ($userAccount->num_rows > 0) {
    $row_account = $userAccount->fetch_assoc();
    $account_id = $row_account['account_id'];

    $sql_ingresos = "SELECT SUM(amount) AS total_ingresos FROM transactions WHERE account_id = $account_id AND transaction_type = 'Ingreso' AND MONTH(transaction_date) = MONTH(CURRENT_DATE)";
    $result_ingresos = $conn->query($sql_ingresos);

    // INGRESOS
    if ($result_ingresos->num_rows > 0) {
        $row = $result_ingresos->fetch_assoc();
        $total_ingresos = $row['total_ingresos'];
    } else {
        $total_ingresos = 0; // Si no hay ingresos
    }
} else {
    // Si no hay cuentas asociadas al usuario
    $total_ingresos = 0;
}

 //GASTOS
 $sql_cuenta= "SELECT account_id FROM accounts WHERE user_id = $user_id";
 $userAccount = $conn->query($sql_cuenta);

 if ($userAccount->num_rows > 0) {
    $row_account = $userAccount->fetch_assoc();
    $account_id = $row_account['account_id'];

    $sql_gastos = "SELECT SUM(amount) AS total_gastos FROM transactions WHERE account_id = $account_id AND transaction_type = 'Gasto' AND MONTH(transaction_date) = MONTH(CURRENT_DATE)";
    $result_gastos = $conn->query($sql_gastos);

    // GASTOS
    if ($result_gastos->num_rows > 0) {
        $row = $result_gastos->fetch_assoc();
        $total_gastos = $row['total_gastos'];
    } else {
        $total_gastos = 0; // Si no hay gastos
    }
} else {
    // Si no hay cuentas asociadas al usuario
    $total_gastos = 0;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finanzas App</title>
    <link rel="stylesheet" href="asset/css/estilos.css">
   
</head>
<body>

    <header>
        <h1>Finanzas App</h1>
    </header>

    <nav>
        <a href="pagina_principal.php " class="active">Home</a>
        <a href="transacciones.php" >Transactions</a>
        <a href="accounts.php" >Accounts</a>
        <a href="logout.php">Close session</a>
    </nav>

    <div class="container">
        <h2>Welcome, <?php echo $username; ?>!</h2>
        
        <div class="stats">
            <div class="stat-box">
                <h3>Total Balance</h3>
                <p><?php echo '$' . number_format($total_balance, 2); ?></p>
            </div>

            <div class="stat-box">
                <h3>Monthly Income</h3>
                <p><?php echo '$' . number_format($total_ingresos, 2); ?></p>
            </div>

            <div class="stat-box">
                <h3>Monthly Spent</h3>
                <p><?php echo '$' . number_format($total_gastos, 2); ?></p>
            </div>
        </div>
    </div>

</body>
</html>


<?php

// Cerrar la conexión
$conn->close();
?>