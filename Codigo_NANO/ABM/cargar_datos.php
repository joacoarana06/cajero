<?php
// Verificar que se reciba el nombre de la tabla
if (isset($_GET['tabla'])) {
    $tabla = $_GET['tabla'];

    // Conexión a la base de datos
    $cnx = mysqli_connect("localhost", "root", "", "nano") or die("Problemas con la conexión");

    // Determinar la consulta SQL según la tabla seleccionada
    switch ($tabla) {
        case 'cliente':
            $sql = "SELECT * FROM cliente";
            break;
        case 'marcas':
            $sql = "SELECT * FROM marcas";
            break;
        case 'producto':
            $sql = "SELECT p.`id_producto`,t.`tipo`,m.`marca`,r.`rubro`,p.`precio_unitario`,p.`stock`
                    FROM `producto` p
                    inner join marcas as m on p.id_marca=m.id_marca
                    inner join tipos as t on p.id_tipo=t.id_tipo
                    inner join rubro as r on p.id_rubro=r.id_rubro";
            break;
        case 'proveedor':
            $sql = "SELECT * FROM `proveedor`";
            break;
        case 'rubro':
            $sql = "SELECT * FROM `rubro`";
            break;
        case 'tipo':
            $sql = "SELECT * FROM `tipos`";
            break;
        default:
            die("Tabla no válida");
    }

    // Ejecutar la consulta y generar el HTML para el select
    $resultado = mysqli_query($cnx, $sql) or die("Problemas en la consulta");

    while ($fila = mysqli_fetch_array($resultado)) {
        // Mostramos el campo correspondiente según la tabla seleccionada
        if ($tabla == 'cliente') {
            echo "<option value='{$fila['id_cliente']}'>{$fila['nombre']} {$fila['apellido']} {$fila['telefono']} {$fila['fiado']}</option>";
        } 
        else if ($tabla == 'marcas'){
            echo "<option value='{$fila['id_marca']}'>{$fila['marca']}</option>"; // Mostramos id y nombre
        } 
        else if ($tabla == 'producto'){
            echo "<option value='{$fila['id_producto']}'>{$fila['tipo']} {$fila['marca']} {$fila['rubro']} {$fila['precio_unitario']} {$fila['stock']}</option>"; // Mostramos id y nombre
        }
        else if ($tabla == 'proveedor'){
            echo "<option value='{$fila['id_proveedor']}'>{$fila['mail']} {$fila['ubicacion']} {$fila['telefono']}</option>"; // Mostramos id y nombre
        }
        else if ($tabla == 'rubro'){
            echo "<option value='{$fila['id_rubro']}'>{$fila['rubro']}</option>"; // Mostramos id y nombre
        }
        else if ($tabla == 'tipo'){
            echo "<option value='{$fila['id_tipo']}'>{$fila['tipo']}</option>"; // Mostramos id y nombre
        }
    }
    // Cerrar la conexión
    mysqli_close($cnx);
} else {
    die("Tabla no especificada");
}
?>