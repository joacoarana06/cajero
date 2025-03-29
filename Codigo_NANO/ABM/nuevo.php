<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ÉXITO</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section class = "form-register">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accion = $_POST['accion'];
        $tabla = $_POST['tabla'];

        // Conexión a la base de datos
        $cnx = mysqli_connect("localhost", "root", "", "nano") or die("Problemas con la conexión");
        switch ($tabla) {
            case 'cliente':
                $id_campo = 'id_cliente';
                $campo1 = $_POST['1'];
                $campo2 = $_POST['2'];
                $campo3 = $_POST['3'];
                $campo4 = $_POST['4'];
                $tabla_bd = 'cliente';
                break;
            case 'marcas':
                $id_campo = 'id_marca';
                $campo1 = $_POST['1'];
                $tabla_bd = 'marcas';
                break;
            case 'tipo':
                $id_campo = 'id_tipo';
                $campo1 = $_POST['1'];
                $tabla_bd = 'tipos';
                break;
            case 'producto': 
                $id_campo = 'id_producto';
                $campo1 = $_POST['1'];
                $campo2 = $_POST['2'];
                $campo3 = $_POST['3'];
                $tabla_bd = 'producto';
                $tipo = $_POST['tipos'];
                $marcas = $_POST['marcas'];
                $rubro = $_POST['rubro'];
                break;
            case 'proveedor': 
                $id_campo = 'id_proveedor';
                $campo1 = $_POST['1'];
                $campo2 = $_POST['2'];
                $campo3 = $_POST['3'];
                $tabla_bd = 'proveedor';
                break;
            case 'rubro':
                $id_campo = 'id_rubro';
                $campo1 = $_POST['1'];
                $tabla_bd = 'rubro';
                break;
            default:
                die("Tabla no válida");
        }

        if ($accion === 'Nuevo') {
            switch ($tabla) {
                case 'cliente':
                    $sql = "INSERT INTO $tabla_bd  VALUES (NULL,'$campo1','$campo2','$campo3','$campo4')";
                    break;
                case 'marcas':
                    $sql = "INSERT INTO $tabla_bd  VALUES (NULL,'$campo1')";
                    break;
                case 'tipo':
                    $sql = "INSERT INTO $tabla_bd  VALUES (NULL,'$campo1')";
                    break;
                case 'producto':
                    $sql = "INSERT INTO $tabla_bd  VALUES (NULL,'$tipo',' $marcas',$campo3,'$campo1','$campo2','$rubro')" ;
                    break;
                case 'proveedor':
                    $sql = "INSERT INTO $tabla_bd  VALUES (NULL,'$campo1','$campo2','$campo3')";
                    break;
                case 'rubro':
                    $sql = "INSERT INTO $tabla_bd  VALUES (NULL,'$campo1')";
                    break;
                default:
                    die("Tabla no válida");
                }
            // Insertar nuevo registro en la base de datos
            mysqli_query($cnx, $sql) or die("Problemas en la inserción");
            echo "Registro agregado en $tabla";
        } elseif ($accion === 'Actualizar') {
            $actual=$_POST['registro'];
            switch ($tabla) {
                case 'cliente':
                    $sql = "UPDATE `cliente` SET `nombre`='$campo1',`apellido`='$campo2',`telefono`='$campo3',`fiado`='$campo4'WHERE `id_cliente`='$actual'";
                    break;
                case 'marcas':
                    $sql = "UPDATE `marcas` SET `marca`='$campo1' WHERE `id_marca`='$actual'";
                    break;
                case 'tipo':
                    $sql = "UPDATE `tipos` SET `tipo`='$campo1' WHERE `id_tipo`='$actual'";
                    break;
                case 'producto':
                    $sql = "UPDATE `producto` SET `id_tipo`='$tipo',`id_marca`='$marcas',`codigo`='$campo3',`precio_unitario`='$campo1',`stock`='$campo2',`id_rubro`='$rubro' WHERE `id_producto`='$actual'";
                    break;
                case 'proveedor':
                    $sql = "UPDATE `proveedor` SET `mail`='$campo1',`ubicacion`='$campo2',`telefono`='$campo3' WHERE `id_proveedor`='$actual'";
                    break;
                case 'rubro':
                    $sql = "UPDATE `rubro` SET `rubro`='$campo1' WHERE `id_rubro`='$actual'";
                    break;
                default:
                    die("Tabla no válida");
                }

            // Actualizar registro en la base de datos
            mysqli_query($cnx, $sql) or die("Problemas en la inserción");
            echo "Registro modificado correctamente";

        } elseif ($accion === 'Borrar') {
            $actual=$_POST['registro'];

            // Borrar registro de la base de datos
            $sql = "DELETE FROM `$tabla_bd` WHERE `$id_campo`='$actual'";
            mysqli_query($cnx, $sql) or die("Problemas en la eliminación");
            mysqli_close($cnx);

            echo "Registro borrado correctamente";
        }
        echo "<br>";
        echo "<label></label>";
        echo "<br>";
        echo "<a class='link' href='../ABM.php'>Volver</a>";
    }
    ?>
</section>
</body>
</html>