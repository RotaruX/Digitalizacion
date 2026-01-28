<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de EPI</title>
    <link rel="stylesheet" href="static/estilos/style.css">
    <link rel="stylesheet" href="static/estilos/panel_trabajador.css">
</head>
<body>
    <header>
        <section id="titulo"><h1>Sistema de gestión de la seguridad laboral</h1><img src="./static/includes/logo.png" height="60px"></section>
<ul>
    <li><a href="../Digitalizacion/index.php"
           class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">
           Inicio</a></li>

    <li><a href="../Digitalizacion/panel_epis.php"
           class="<?= basename($_SERVER['PHP_SELF']) === 'panel_epis.php' ? 'active' : '' ?>">
           EPI's</a></li>

    <li><a href="../Digitalizacion/panel_trabajador.php"
           class="<?= basename($_SERVER['PHP_SELF']) === 'panel_trabajador.php' ? 'active' : '' ?>">
           Trabajador</a></li>
</ul>

    </header>