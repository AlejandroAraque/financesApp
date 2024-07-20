<?php

include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<?php
// Insertar usuarios de ejemplo
$sql_insert_users = "INSERT INTO users (username, password) VALUES
                    ('usuario1', '" . password_hash('contrasena1', PASSWORD_DEFAULT) . "'),
                    ('usuario2', '" . password_hash('contrasena2', PASSWORD_DEFAULT) . "'),
                    ('usuario3', '" . password_hash('contrasena3', PASSWORD_DEFAULT) . "')";

$conn->query($sql_insert_users);

// Obtener los ID de los usuarios insertados
$user_id_1 = $conn->insert_id - 2;
$user_id_2 = $conn->insert_id - 1;
$user_id_3 = $conn->insert_id;

// Insertar cuentas de ejemplo
$sql_insert_accounts = "INSERT INTO accounts (user_id, account_name, balance) VALUES
                        ($user_id_1, 'Cuenta Principal', 1000.00),
                        ($user_id_2, 'Cuenta de Principal', 500.00),
                        ($user_id_3, 'Cuenta de Principal', 200.00)";
$conn->query($sql_insert_accounts);

// Insertar presupuestos de ejemplo
$sql_insert_categories= "INSERT INTO transaction_categories (category_name) VALUES
                        ('Income'),
                        ('Groceries'),
                        ('Utilities'),
                        ('Entertainment'),
                        ('Rent'),
                        ('Healthcare'),
                        ('Others')
                        ";
$conn->query($sql_insert_categories);

// Insertar transacciones de ejemplo
$sql_insert_transactions = "INSERT INTO transactions (account_id, amount, transaction_type, category_id, description) VALUES
(1, 500.00, 'Ingreso', 1, 'Ingreso de salario'),
(1, 200.00, 'Gasto', 2, 'Compra en línea'),
(4, 100.00, 'Ingreso', 3, 'Depósito'),
(3, 50.00, 'Gasto', 4, 'Almuerzo');
";
$conn->query($sql_insert_transactions);



// Cerrar la conexión
$conn->close();

echo "Datos de muestra insertados correctamente.";
?>
