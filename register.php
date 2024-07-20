<?php
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="asset/css/log_reg.css">
</head>
<body>
    <form action = "<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method ="POST">
    <h2>Welcome to your Finance App</h2>
    Username: <br>
    <input type= "text" name = "username"><br>
    Password: <br>
    <input type= "password" name = "password"><br>
    <input type= "submit" name = "submit" value="Register">
    </form>

   <!-- Botón para ir a la página de inicio de sesión -->
    <a href="login.php">
        <button>Login</button><br>
    </a>
    
</body>
</html>

<?php

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);    

        if (empty($username)){
        echo "please enter a username";

        }
        else if(empty($password)){
            echo "please enter a password";

        }else {
            $check_query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            echo "Username '$username' already exists. Please choose a different username.";
        } else {
            
            $hash = password_hash($password, PASSWORD_DEFAULT);
             $sql = "INSERT INTO users (username, password)
                     VALUES ('$username', '$hash')";
                     
                     if (mysqli_query($conn, $sql)) {
                        echo "You are now registered!";
                    } else {
                        echo "Error registering user: " . mysqli_error($conn);
                    }
                }
        }

    }


mysqli_close($conn);
?>