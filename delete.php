<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Borrar Registro</title>
        <link rel="stylesheet" href="./css/styles.css" type="text/css">
    </head>
    <body>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['submityes'])) {
                    $basedatos = '';
                    $tabla = '';
                    include_once('./functions.php');
    
                    $conexion = conectar();
                    comprobarBD($conexion, $basedatos, $tabla);
                    
                    $id = $_POST['id'];

                    $exito = borrar($conexion, $basedatos, $tabla, $id);
                    
                    if ($exito) {
                        header('Location: ./index.php');
                        die();
                    }
                    
                } else {
                    header('Location: ./index.php');
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
                    <span class="title">Borrar un producto</span>
                </header>
                <figure></figure>
                <form action="<?php echo $_SERVER['PHP_SELF'];  ?>" enctype="multipart/form-data" method="POST">
                    <legend>¿Deseas eliminar el producto?</legend><br><br>
                    <input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>">
                    <input type="submit" id="submityes" name="submityes" value="Si" />
                    <input type="submit" id="submitno" name="submitno" value="No" />
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