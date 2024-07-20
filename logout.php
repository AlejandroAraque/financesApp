<?php
// Inicia la sesión si no está iniciada
session_start();
include("database.php");


// Verifica si se ha enviado el formulario de cierre de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrar Sesión</title>
    <link rel="stylesheet" href="asset/css/estilos.css">
</head>
<body>

    <header>
        <h1>Finanzas App</h1>
    </header>

    <nav>
    <a href="pagina_principal.php">Home</a>
        <a href="transacciones.php" >Transactions</a>
        <a href="accounts.php">Accounts</a>
        <a href="logout.php" class="active">Close Session</a>
    </nav>

        <h2 class="encabezado">Close session</h2>

        <p class="encabezado">¿Are you sure that you want to close de sesion?</p>

        <div class="center-container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <button  class="encabezado" type="submit" name="logout">Close Session</button>
        </form>
        </div>

    </div>

</body>
</html>
