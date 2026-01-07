<form action="inicio.php" method="POST">
    <label for="usuario">Usuario</label>
    <input type="text" name="usuario" placeholder="Usuario" required><br>
    <label for="contrasenya">Contraseña</label>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <input type="submit" name="enviar" value="Entrar">
</form>

<?php if (isset($_GET['error'])): //En caso de que de error salga este mensaje ?>
    <p style="color:red;">Usuario o contraseña incorrectos</p>
<?php endif; ?>
