<?php

    function conectar() {
        $servidor = 'localhost';
        $usuario = 'root';
        $contrasena = '';

            $conexion = new mysqli($servidor, $usuario, $contrasena);

        if ($conexion->connect_errno) {
            die('Error de conexión: ' . $conexion->connect_errno);
        }

        return $conexion;
    }

    function comprobarBD($conexion, &$basedatos, &$tabla) {
        $basedatos = 'phpShopDB';
        $tabla = 'tArticulos';

        $consulta = 'CREATE DATABASE IF NOT EXISTS ' . $basedatos . ';';

        $resultado = $conexion->query($consulta);

        if (!$resultado) {
            printf('Error en la creación de la base de datos %s.', $basedatos);
        } else {
            $consulta = 'CREATE TABLE IF NOT EXISTS ' . $basedatos . '.' . $tabla . ' (
                id INT AUTO_INCREMENT PRIMARY KEY,
                barcode VARCHAR(13),
                description VARCHAR(50),
                price DECIMAL(5,2),
                photo VARCHAR(150)
            );';

            $resultado = $conexion->query($consulta);

            if (!$resultado) {
                printf("Error en la creación de la tabla %s.", $tabla);
            }
        }

        return $resultado;
    }

    function crear($conexion, $basedatos, $tabla, $codigobarras, $descripcion, $precio, $foto) {
        $resultado = false;

        $consulta = 'INSERT INTO ' . $basedatos . '.' . $tabla . ' (barcode, description, price, photo) VALUES (?, ?, ?, ?);'; 

        $stmt = $conexion->prepare($consulta);

        $stmt->bind_param('ssds', $codigobarras, $descripcion, $precio, $foto);

        $resultado = $stmt->execute();
        $stmt->close();

        if (!$resultado) {
            printf("Error en la inserción del registro");
        }

        $conexion->close();
        return $resultado;
    }

    function leer($conexion, $basedatos, $tabla, $id) {
        $resultado = '';

        $consulta = 'SELECT * FROM ' . $basedatos . '.' . $tabla . ' WHERE id = ?;'; 

        $stmt = $conexion->prepare($consulta);

        if ($stmt) {
            $stmt->bind_param('i', $_id);

            $_id = $id;

            $resultado = $stmt->execute();
            $stmt->close();
        }
        
        $conexion->close();
        return $resultado;
    }

    function actualizar($conexion, $basedatos, $tabla, $id, $codigobarras, $descripcion, $precio, $foto) {
        $resultado = false;

        $consulta = 'UPDATE ' . $basedatos . '.' . $tabla . ' SET barcode = ?, description = ?, price = ?, photo = ? WHERE $id = ?;';

        $stmt = $conexion->prepare($consulta);

        if ($stmt) {
            $stmt->bind_param('ssdsi', $codigobarras, $descripcion, $precio, $foto, $id);

            $_codigobarras = $conexion->real_escape_string($codigobarras);
            $_descripcion = $conexion->real_escape_string($descripcion);
            $_precio = $precio;
            $_foto = $conexion->real_escape_string($foto);
            $_id = $id;

            $resultado = $stmt->execute();
            $stmt->close();

            if (!$resultado) {
                printf("Error en la actualización del registro");
            }
        }

        $conexion->close();
        return $resultado;        
    }

    function borrar($conexion, $basedatos, $tabla, $id) {
        $resultado = false;

        $consulta = 'DELETE FROM ' . $basedatos . '.' . $tabla . ' WHERE id = ?;'; 

        $stmt = $conexion->prepare($consulta);

        if ($stmt) {
            $stmt->bind_param('i', $_id);

            $_id = $id;
            
            $resultado = $stmt->execute();
            $stmt->close();

            if ($resultado) {
                printf("Error en el borrado del registro");
            }
        }

        $conexion->close();
        return $resultado;        
    }

    function mostrar($conexion, $basedatos, $tabla) {
        $resultado = '';
        $datos = '';

        $consulta = 'SELECT * FROM ' . $basedatos . '.' . $tabla . ';';

        $resultado = $conexion->query($consulta);

        if (!$resultado) {
            printf("Error en la recuperación de datos.");
        } else {
            while ($registro = $resultado->fetch_assoc()) {
                $datos .= '<tr>';
                $datos .= '<td>' . $registro["id"] . '</td>';
                $datos .= '<td>' . $registro["barcode"] . '</td>';
                $datos .= '<td>' . $registro["description"] . '</td>';
                $datos .= '<td style="text-align: right;">' . $registro["price"] . ' €</td>';
                $datos .= '<td>';
                $datos .= '<a href="./read.php?id=' . $registro["id"] . '"><img src="./image/eye.png"></a>';
                $datos .= '<a href="./update.php?id=' . $registro["id"] . '"><img src="./image/pencil.png"></a>';
                $datos .= '<a href="./delete.php?id=' . $registro["id"] . '"><img src="./image/trash-can.png"></a>';
                $datos .= '</td>';
                $datos .= '</tr>';
            }
        }

        $resultado->close();
        $conexion->close();
        return $datos;
    }

?>