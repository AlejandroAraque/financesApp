<?php
include("database.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="asset/css/log_reg.css">
</head>
<body>
    <form action = "<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method ="POST">
    <h2>Welcome to your Finance App</h2>
    Username: <br>
    <input type= "text" name = "username"><br>
    Password: <br>
    <input type= "password" name = "password"><br>
    <input type= "submit" name = "submit" value="Login">
    </form>

   <!-- Botón para ir a la página de registrarse -->
    <a href="register.php">
        <button>Register</button><br>
    </a>
   
</body>
</html>


<?php

    
    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);    
        $hash = password_hash($password, PASSWORD_DEFAULT);

        if (empty($username)){
        echo "please enter a username";

        }
        else if(empty($password)){
            echo "please enter a password";
            
        }else {
            $check_query = "SELECT * FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $check_query);
        }
        if (mysqli_num_rows($result) > 0) {
            
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
               $_SESSION['user_id'] = $row['user_id']; 
               $_SESSION['password'] = $row['password']; 
               //echo $_SESSION['user_id'];
               //echo $_SESSION['password'];
               header("Location: pagina_principal.php");
               
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "Username not found";
        }
    }


mysqli_close($conn);
?>