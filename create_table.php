<?php
include("database.php");
// Verificar si la conexión está establecida
if ($conn) {

// Crear tabla de usuarios
    $sql_users = "CREATE TABLE IF NOT EXISTS users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      )";

            
            if (mysqli_query($conn, $sql_users)) {
            echo "Table 'users' created successfully! <br>";
            } else {
            echo "Error creating table users: " . mysqli_error($conn) . "<br>";
            }
// Crear tabla de cuentas
    $sql_account = "CREATE TABLE IF NOT EXISTS accounts (
                account_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                account_name VARCHAR(50) NOT NULL,
                balance DECIMAL(10, 2) DEFAULT 0.00,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(user_id)
            )";        

            if (mysqli_query($conn, $sql_account)) {
            echo "Table 'account' created successfully! <br>";
            } else {
            echo "Error creating table account: " . mysqli_error($conn) . "<br>";
            }

// Crear tabla de categorias
    $sql_categories = "CREATE TABLE IF NOT EXISTS transaction_categories (
        category_id INT AUTO_INCREMENT PRIMARY KEY,
        category_name VARCHAR(50) NOT NULL
    )";

// Ejecutar consulta
if (mysqli_query($conn, $sql_categories)) {
    echo "Table 'categories' created successfully! <br>";
    } else {
    echo "Error creating table categories: " . mysqli_error($conn) . "<br>";
    }



// Crear tabla de transactions
    $sql_transactions = "CREATE TABLE IF NOT EXISTS transactions (
        transaction_id INT AUTO_INCREMENT PRIMARY KEY,
        account_id INT,
        amount DECIMAL(10, 2) NOT NULL,
        category_id INT,
        transaction_type ENUM('Ingreso', 'Gasto') NOT NULL,
        description TEXT,
        transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (account_id) REFERENCES accounts(account_id),
        FOREIGN KEY (category_id) REFERENCES transaction_categories(category_id)
    )";

            // Ejecutar consulta
            if (mysqli_query($conn, $sql_transactions)) {
            echo "Table 'transactions' created successfully! <br>";
            } else {
            echo "Error creating table transactions: " . mysqli_error($conn) . "<br>";
            }
    


} else {
    echo "Could not create tables - No database connection! <br>";
}

?>
