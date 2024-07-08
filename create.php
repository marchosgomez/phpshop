<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Insertar Registro</title>
        <link rel="stylesheet" href="./css/styles.css" type="text/css">
    </head>
    <body>
        <?php
            if (session_status() == PHP_SESSION_NONE) {
                header('Location: ./login.php');
                die();
            } else {
                session_start();
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $basedatos = '';
                $tabla = 'tArticulos';
                include_once('./functions.php');

                $conexion = conectar();
                comprobarBD($conexion, $basedatos, $tabla);

                $codigobarras = $_POST['fbarcode'];
                $descripcion = $_POST['fdescription'];
                $precio = $_POST['fprice'];

                $uploaddir = './upload/';
                $uploadfile = $uploaddir . basename($_FILES['fphoto']['name']);
                $exito = move_uploaded_file($_FILES['fphoto']['tmp_name'], $uploadfile);

                if ($exito) {
                    echo "La imagen ha sido cargada en el servidor.";
                } else {
                    echo "La imagen NO ha sido cargada en el servidor.";
                }

                $foto = $_FILES['fphoto']['full_path'];
                
                $exito = crear($conexion, $basedatos, $tabla, $codigobarras, $descripcion, $precio, $foto);

                if ($exito) {
                    header('Location: ./index.php');
                    die();
                } else {
                    header('Location: ./create.php');
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
                    <span class="title">Introducir un nuevo producto</span>
            </header>
                <figure></figure>
                <form action="<?php echo $_SERVER['PHP_SELF'];  ?>" enctype="multipart/form-data" method="POST">
                    <label for="fbarcode">Código de Barras:</label>
                    <input type="text" id="fbarcode" name="fbarcode" /><br><br>
                    <label for="fdescription">Descripción:</label>
                    <input type="text" id="fdescription" name="fdescription" /><br><br>
                    <label for="fprice">Precio Unitario:</label>
                    <input type="text" id="fprice" name="fprice" /><br><br>
                    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                    <label for="fphoto">Fotografía:</label>
                    <input type="file" id="fphoto" name="fphoto" /><br><br>
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