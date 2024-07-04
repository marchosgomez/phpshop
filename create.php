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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $basedatos = '';
            $tabla = '';
            include_once('./functions.php');

            $conexion = conectar();
            comprobarBD($conexion, $basedatos, $tabla);

            $id = 0;
            $codigobarras = $_POST['fbarcode'];
            $descripcion = $_POST['fdescription'];
            $precio = $_POST['fprice'];
            $foto = $_POST['fphoto'];
            
            crear($conexion, $basedatos, $tabla, $id, $codigobarras, $descripcion, $precio, $foto);
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
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>" enctype="multipart/form-data">
                <label for="fbarcode">Código de Barras:</label>
                <input type="text" id="fbarcode" name="fbarcode"><br><br>
                <label for="fdescription">Descripción:</label>
                <input type="text" id="fdescription" name="fdescription"><br><br>
                <label for="fprice">Precio Unitario:</label>
                <input type="text" id="fprecio" name="fprecio"><br><br>
                <label for="fphoto">Fotografía:</label>
                <input type="file" id="fphoto" name="fphoto"><br><br>
                <input type="submit" id="submit" name="submit" value="Guardar">
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