<?php

session_start();

$user_id = $_SESSION['user_id'];
include("database.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/estilos.css">
    <title>Transaction Register</title>
    <style>




form {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input, select, textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}
</style>

</head>
<body>

    <header>
        <h1>Transaction Register</h1>
    </header>

    <nav>
        <a href="pagina_principal.php">Home</a>
        <a href="transacciones.php" class="active">Transactions</a>
        <a href="accounts.php">Accounts</a>
        <a href="logout.php">Close session</a>
    </nav>

    <div class="container">
        <h2>New Transaction</h2>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <label for="amount">Quantity:</label>
            <input type="number" name="amount" required min="0">
            
            <label for="type">Transaction type:</label>
            <select name="type" required>
                <option value="Ingreso">Income</option>
                <option value="Gasto">Spent</option>
            </select>
            
            <label for="category">Category:</label>
            <input type="text" name="category" required>
            
            
            <label for="description">Description:</label>
            <textarea name="description"></textarea>
            
            <button type="submit">Transaction Register</button>
        </form>

        <h2>Transaction History</h2>
        <table>
      <tr>
           <th>ID</th>
           <th>Quantity</th>
           <th>Type</th>
           <th>Description</th>
           <th>Date</th>
        </tr>
       

         
         <?php
          include("database.php");
         
                 // Obtener transacciones desde la base de datos
         $sql_cuenta = "SELECT account_id FROM accounts WHERE user_id = $user_id;";
         
         $result_cuenta = $conn->query($sql_cuenta);
         if (!$result_cuenta) {
             die("Error en la consulta: " . $conn->error);
         }
         if ($result_cuenta->num_rows > 0) {
             $row_account = $result_cuenta->fetch_assoc();
             $account_id = $row_account['account_id'];
         }
 
 
         
         $sql_transactions = "SELECT * FROM transactions WHERE account_id  = $account_id;";     
        $result_transactions = $conn->query($sql_transactions);
         $i=0;
         
         // Mostrar transacciones 
         if ($result_transactions->num_rows > 0) {
             
             while ($row_transaction = $result_transactions->fetch_assoc()) {
                 echo "<tr>";
                 echo "<td>" . $i . "</td>";  
                 echo "<td>" . $row_transaction['amount'] . "$</td>";            
                 echo "<td>" . $row_transaction['transaction_type'] . "</td>";
                 echo "<td>" . $row_transaction['description'] . "</td>";
                 echo "<td>" . $row_transaction['transaction_date'] . "</td>";
                 echo "</tr>";
                 $i++;
             }
        } else {
             echo "<tr><td colspan='6'>No hay transacciones disponibles</td></tr>";
         }
         ?>
 
     </table>
    </div>
        <?php
        include("database.php");

        if ($_SERVER["REQUEST_METHOD"]=="POST"){

            // campos del formulario llenos
            if (!empty($_POST['amount']) && !empty($_POST['type']) && !empty($_POST['category'])) {
                
                
             // Recupera los datos del formulario
            $amount = $_POST['amount'];
            $type = $_POST['type'];
            $category = $_POST['category'];
            $description = isset($_POST['description']) ? $_POST['description'] : '';

             
             $sql_account = "SELECT account_id FROM accounts WHERE user_id = $user_id";
             
             $result_account = $conn->query($sql_account);

             if ($result_account->num_rows > 0) {
                 $row_account = $result_account->fetch_assoc();
                 $account_id = $row_account['account_id'];
             }
             


             $sql = "INSERT INTO transactions (account_id, amount, category_id, transaction_type,  description, transaction_date) VALUES ('$account_id', '$amount','$category', '$type',  '$description', NOW())";
             if ($type=='Ingreso'){
                $sql_update_balance = "UPDATE accounts SET balance = balance +'$amount' WHERE account_id = $account_id";
             }else{$sql_update_balance = "UPDATE accounts SET balance = balance -'$amount' WHERE account_id = $account_id";}
             
             // Ejecutar la consulta
             if ($conn->multi_query("$sql;$sql_update_balance")) {
                 echo "";
             } else {
                 echo "Error al registrar la transacción: " . $conn->error;
             }
             
             

             

         } else {
             
             echo "Todos los campos del formulario deben estar llenos.";
         }
         } 
        
?>
  



</body>
</html>
