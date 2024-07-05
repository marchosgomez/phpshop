<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Index</title>
        <link rel="stylesheet" href="./css/styles.css" type="text/css">
    </head>
    <body>
        <header>
            <h1>Demo: Crear una aplicación PHP Crud</h1>
        </header>
        <nav></nav>
        <main>
            <section></section>
            <article>
                <header>
                    <span class="title">Detalles de Productos</span>
                    <button onclick="location.href='./create.php';" style="background-color: green; color: white; float: right; margin-right: 235px; padding: 10px;">Añadir producto nuevo</button>
                </header>
                <figure></figure>
                <table style="width:80%;">
                    <thead>
                        <tr>
                            <th align="left" style="width:5%;">#</th>
                            <th align="left" style="width:15%;">Código de Barras</th>
                            <th align="left" style="width:50%;">Descripción</th>
                            <th align="left" style="width:13%;">Precio Unitario</th>
                            <th align="left" style="width:17%;">Operaciones</th>
                        </tr>  
                    </thead>
                    <tbody>
                        <?php
                            $basedatos = '';
                            $tabla = '';
                            include_once('./functions.php');
                            $conexion = conectar();
                            comprobarBD($conexion, $basedatos, $tabla);
                            $datos = mostrar($conexion, $basedatos, $tabla);
                            echo $datos;
                        ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
                <footer></footer>
            </article>
            <aside></aside>
        </main>
        <footer></footer>
    </body>
</html>