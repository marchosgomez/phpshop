<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
    <body>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $basedatos = '';
                $tabla = 'tUsuarios';
                include_once('./functions.php');

                $conexion = conectar();
                comprobarBD($conexion, $basedatos, $tabla);

                $email = $_POST['femail'];
                $password = $_POST['fpassword'];

                $exito = login($conexion, $basedatos, $tabla, $email, $password);

                if ($exito) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    header('Location: ./index.php');
                    die();
                } else {
                    header('Location: ./login.php');
                    die();
                }
                
            } else {
        ?>
        <header>
            <h1>Demo: Crear una aplicación PHP Crud</h1>
        </header>
        <nav></nav>
        <main>
            <section></section>
            <article>
                <header>
                    <span class="title">Iniciar Sesión</span>
            </header>
                <figure></figure>
                <form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="POST">
                    <label for="femail">Email:</label>
                    <input type="text" id="femail" name="femail" /><br><br>
                    <label for="fpassword">Contraseña:</label>
                    <input type="text" id="fpassword" name="fpassword" /><br><br>
                    <input type="submit" id="submit" name="submit" value="Guardar registro" />
                </form>
                <footer></footer>
            </article>
            <aside></aside>
        </main>
        <footer></footer>
        <?php
            }
        ?>
    </body>
</html>