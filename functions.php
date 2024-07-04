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

        $consulta = 'CREATE DATABASE IF NOT EXISTS ' . 
            $conexion->real_escape_string($basedatos) . ';';

        $resultado = $conexion->query($consulta);

        if (!$resultado) {
            printf('Error en la creación de la base de datos %s.', $basedatos);
        } else {
            $consulta = 'CREATE TABLE IF NOT EXISTS ' .
                $conexion->real_escape_string($basedatos) . '.' . 
                $conexion->real_escape_string($tabla) . ' (
                id INT AUTO_INCREMENT PRIMARY KEY,
                barcode VARCHAR(13),
                description VARCHAR(50),
                price DECIMAL(5,2),
                photo BLOB
            );';

            $resultado = $conexion->query($consulta);

            if (!$resultado) {
                printf("Error en la creación de la tabla %s.", $tabla);
            }
        }

        return $resultado;
    }

    function crear($conexion, $basedatos, $tabla, $id, $codigobarras, $descripcion, $precio, $foto) {
        $resultado = false;

        $consulta = 'INSERT INTO ' . 
            $conexion->real_escape_string($basedatos) . '.' .
            $conexion->real_escape_string($tabla) . 
            ' VALUES (?, ?, ?, ?);';

        $stmt = $conexion->prepare($consulta);

        if ($stmt) {
            $stmt->bind_param('i', $_id);
            $stmt->bind_param('s', $_codigobarras);
            $stmt->bind_param('s', $_descripcion);
            $stmt->bind_param('d', $_precio);
            $stmt->bind_param('b', $_foto);
            // $stmt->bind_param('issdb', $id, $codigobarras, $descripcion, $precio, $foto);

            $_id = $conexion->real_escape_string($id);
            $_codigobarras = $conexion->real_escape_string($codigobarras);
            $_descripcion = $conexion->real_escape_string($descripcion);
            $_precio = $conexion->real_escape_string($precio);
            $_foto = $conexion->real_escape_string($foto);

            $resultado = $stmt->execute();
            $stmt->close();

            if (!$resultado) {
                printf("Error en la inserción del registro");
            };
        }

        $conexion->close();
        return $resultado;
    }

    function leer($conexion, $basedatos, $tabla, $id) {
        $resultado = '';

        $consulta = 'SELECT * FROM ' . 
            $conexion->real_escape_string($basedatos) . '.' . 
            $conexion->real_escape_string($tabla) . 
            ' WHERE id = ?;';

        $stmt = $conexion->prepare($consulta);

        if ($stmt) {
            $stmt->bind_param('i', $_id);
            $_id = $conexion->real_escape_string($id);
            $resultado = $stmt->execute();
            $stmt->close();
        }
        
        $conexion->close();
        return $resultado;
    }

    function actualizar($conexion, $basedatos, $tabla, $id, $codigobarras, $descripcion, $precio, $foto) {
        $resultado = false;

        $consulta = 'UPDATE ' . 
            $conexion->real_escape_string($basedatos) . '.' . 
            $conexion->real_escape_string($tabla) . 
            ' SET barcode = ?, description = ?, price = ?, photo = ? WHERE $id = ?;';

        $stmt = $conexion->prepare($consulta);

        if ($stmt) {
            $stmt->bind_param('ssdbi', $codigobarras, $descripcion, $precio, $foto, $id);

            $_codigobarras = $conexion->real_escape_string($codigobarras);
            $_descripcion = $conexion->real_escape_string($descripcion);
            $_precio = $conexion->real_escape_string($precio);
            $_foto = $conexion->real_escape_string($foto);
            $_id = $conexion->real_escape_string($id);

            $resultado = $stmt->execute();
            $stmt->close();

            if (!$resultado) {
                printf("Error en la actualización del registro");
            };
        }

        $conexion->close();
        return $resultado;        
    }

    function borrar($conexion, $basedatos, $tabla, $id) {
        $resultado = false;

        $consulta = 'DELETE FROM ' . 
            $conexion->real_escape_string($basedatos) . '.' . 
            $conexion->real_escape_string($tabla) . 
            ' WHERE id = ?;';

        $stmt = $conexion->prepare($consulta);

        if ($stmt) {
            $stmt->bind_param('i', $_id);
            $_id = $conexion->real_escape_string($id);
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

        $consulta = 'SELECT * FROM ' . 
            $conexion->real_escape_string($basedatos) . '.' . 
            $conexion->real_escape_string($tabla) . ';';

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
                $datos .= '<a href="./read.php"><img src="./img/eye.png"></a>';
                $datos .= '<a href="./update.php"><img src="./img/pencil.png"></a>';
                $datos .= '<a href="./delete.php"><img src="./img/trash-can.png"></a>';
                $datos .= '</td>';
                $datos .= '</tr>';
            }
        }

        $resultado->close();
        $conexion->close();
        return $datos;
    }

?>