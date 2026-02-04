<?php
session_start();
if(isset($_POST["enviar"])){
    if($_SESSION["rol"] == "rrhh")
        header("Location:panel_rrhh.php");
    if($_SESSION["rol"] == "trabajador")
        header("Location:trabajador.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="static/estilos/stylo.css">
</head>
<body>
    <main>
<form action="inicio.php" method="POST">
    <label for="usuario">Usuario</label>
    <input type="text" name="usuario" placeholder="Usuario" required><br>
    <label for="contrasenya">Contraseña</label>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <input type="submit" name="enviar" value="Entrar">
    <?php if (isset($_GET['error'])): //En caso de que de error salga este mensaje ?>
    <p style="color:red;">Usuario o contraseña incorrectos</p>
<?php endif;?>
</form>

</main>
    <footer>
        <h4>Contacto</h4>
        <p>666 777 888 - 888 777 666</p>
        <p>correoempresa@gmail.com</p>
        <p id="fecha"><?php
            echo date('d/m/Y');
        ?></p>
    </footer>
</body>
</html>




