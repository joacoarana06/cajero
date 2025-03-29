<?php
// Código PHP al principio del archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    if (isset($_POST['id_cliente'])) {
        $id_delcliente = $_POST['id_cliente'];
        // Conexión a la base de datos
        $cnx = mysqli_connect("localhost", "root", "", "nano") or die("Problemas con la conexión");

        // Consulta para obtener el fiado
        $sql = "SELECT fiado FROM cliente WHERE id_cliente='$id_delcliente'";
        $resultado = mysqli_query($cnx, $sql) or die("No se pudo ejecutar la consulta");

        // Obtener el resultado
        if ($resultado = mysqli_fetch_assoc($resultado)) {
            $fiado = $resultado['fiado'];
            // Devolver el resultado como JSON
            echo json_encode(['fiado' => $fiado]);
            // PONER FIADO EN UNA VARIABLE DE JAVA  
        } else {
            echo json_encode(['fiado' => 0]);
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($cnx);
        if (isset($_POST['vuelto'])) {
            $vuelto = $_POST['vuelto'];
            $id_delcliente = $_POST['id_cliente'];
            $cnx = mysqli_connect("localhost", "root", "", "nano") or die("Problemas con la conexión");
            $sql = "UPDATE `cliente` SET `fiado` = (`fiado` - '$vuelto') WHERE `id_cliente` = '$id_delcliente'";
            mysqli_query($cnx, $sql) or die("No se pudo ejecutar la consulta");
            mysqli_close($cnx);
            echo json_encode(['status' => 'success', 'message' => 'Datos procesados correctamente1']);
        }
    }
    if (isset($_POST['filas'])){
        if (isset($_POST['id_cliente'])) {
            $id_delcliente = $_POST['id_cliente'];
        }
        else{
            $id_delcliente = 0;
        }
        $filas = json_decode($_POST['filas'], true);  // Decodificar el JSON en un array PHP
        date_default_timezone_set('America/Buenos_Aires');
        $fecha=date('Y-m-d h:i:s');
        $cnx = mysqli_connect("localhost", "root", "", "nano") or die("Problemas con la conexión");

        $sql = "INSERT INTO `venta`(`id_cliente`, `fecha y hora`) VALUES ('$id_delcliente','$fecha')";
        mysqli_query($cnx, $sql) or die("No se pudo ejecutar la consulta");
        $sql = "SELECT `id_venta` FROM `venta` WHERE `id_cliente`='$id_delcliente' AND `fecha y hora`='$fecha'";
        $sasas=mysqli_query($cnx, $sql) or die("No se pudo ejecutar la consulta");
        $fec=mysqli_fetch_array($sasas);
        foreach ($filas as $fila) {
            $producto = $fila['producto'];
            $id_producto=$fila['id_producto'];
            $cantidad = $fila['cantidad'];
            $precio=$fila['precio'];            
            $sql = "UPDATE `producto` SET `stock`=(`stock`-'$cantidad') WHERE `id_producto`='$id_producto'";
            mysqli_query($cnx, $sql) or die("No se pudo ejecutar la consulta");
            $sql = "INSERT INTO `detalles_venta`(`id_venta`, `producto`, `cantidad`, `precio_unitario`) VALUES ('$fec[id_venta]','$producto','$cantidad','$precio')";
            mysqli_query($cnx, $sql) or die("No se pudo ejecutar la consulta");
        }
        mysqli_close($cnx);
        echo json_encode(['status' => 'success', 'message' => 'Datos procesados correctamente2']);
    }
    exit; // Salir para que no se ejecute el resto del HTML
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
            <script>
                // Función para realizar la consulta del fiado usando AJAX
        function precios_fiado() {
            var fia = document.getElementById('cliente').value; // Obtener el valor del input

            // Realizar la solicitud AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "admin.php", true); // Enviar el valor a la misma página
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = (xhr.responseText); // Asumiendo que devuelves JSON
                    console.log(response);
                }
            };
            xhr.send("id_cliente=" + fia); // Enviar el valor 'fia' a PHP

        }
                function borrrar(boton){
                                    var tabla = document.getElementById("tablita");
                                    var fila = boton.parentNode.parentNode;
                                    tabla.deleteRow(fila.rowIndex)
                                    
                                }
                    function confirmar(){
                        var total = 0;
                        var filas = document.querySelectorAll('#tablita tr');  // Selecciona todas las filas de la tabla
                        var productos=[]

                        // Recorremos todas las filas desde la 2da (índice 1), ya que la primera es el encabezado
                        for (let i = 1; i < filas.length; i++) {
                            var celdas = filas[i].querySelectorAll('td');  // Obtiene todas las celdas de la fila

                            // Asegurarse de que la fila tenga al menos 4 celdas (producto, precio, cantidad, oferta)
                            if (celdas.length >= 4) {
                                // Obtenemos el precio de la segunda celda (y eliminamos cualquier símbolo de moneda si lo tiene)
                                var producto =celdas[0].innerHTML;
                                var id_producto =celdas[0].value;
                                var precio = parseFloat(celdas[1].value);
                                var cantidad = parseFloat(celdas[2].innerHTML) || 0;  // Si no hay valor en el input, asumimos 0
                                var oferta = parseFloat(celdas[3].innerHTML) || 0;  // Si no hay valor de oferta, asumimos 0%
                                // Asegurarnos de que cantidad y precio sean valores válidos
                                
                                if (!isNaN(precio) && !isNaN(cantidad)) {
                                    // Calcular el subtotal
                                    var subtotal = precio * cantidad;

                                    // Aplicar descuento si hay una oferta
                                    if (oferta > 0) {
                                        var descuento = subtotal * (oferta / 100);  // Calculamos el descuento
                                        subtotal -= descuento;  // Restamos el descuento del subtotal
                                    }
                                    total += subtotal;  // Sumar el subtotal al total general
                                    productos.push({producto:producto,precio:precio,cantidad:cantidad,oferta:oferta,id_producto:id_producto});
                                    }
                                }
                            }
                            // Mostrar el total en el elemento con id 'conf'
                            var abono=prompt("Total a pagar: $" + total.toFixed(2),"plata abonada");
                            abono =parseFloat(abono)
                            var exitoso=false
                            var vuel =false
                            if (document.getElementById("cliente").value!=0) {
                                if (abono<0 ) {
                                    alert("Valor ingresado invalido")
                                }else if(isNaN(abono)){
                                    alert("transacción cancelada")
                                }
                                else {
                                    var vuelto = abono - total
                                    if (vuelto==0) {
                                        exitoso=true
                                    }else if(vuelto>0){
                                        alert("El vuelto es de: "+vuelto)
                                        conf=confirm("Descontar de la cuenta")
                                        if (conf) {
                                            exitoso=true
                                        }
                                        else{
                                            alert("transacción cancelada")
                                        }
                                    }
                                    else {
                                        alert("Faltan abonar: "+(vuelto*-1))
                                        conf=confirm("Agregar a la cuenta")
                                        if (conf) {
                                            exitoso=true
                                        }
                                        else{
                                            alert("transacción cancelada")
                                        }
                                    }
                                }
                            } else {
                                if (abono<0 ) {
                                    alert("Valor ingresado invalido")
                                }else if(isNaN(abono)){
                                    alert("transacción cancelada")
                                }
                                else {
                                    var vuelto = abono - total
                                    if(vuelto>=0){
                                        alert("El vuelto es de: "+vuelto)
                                        vuel =true
                                    }
                                    else {
                                        alert("Faltan abonar: "+(vuelto*-1))
                                    }
                                }
                            }
                            //Pasar "filas"
                            if (exitoso) {
                                var xhr = new XMLHttpRequest();
                                var fia = document.getElementById('cliente').value;
                                xhr.open("POST", "admin.php", true);
                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                        console.log(xhr.responseText);  // Procesar la respuesta del servidor si es necesario
                                    }
                                };
                                var data = "filas=" + JSON.stringify(productos) + "&vuelto=" + vuelto+ "&id_cliente=" + fia;
                                xhr.send(data);  // Enviar las variables filas y vuelto
                            }
                            else if(vuel){
                                var xhr = new XMLHttpRequest();
                                xhr.open("POST", "admin.php", true);
                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === 4 && xhr.status === 200) {
                                        console.log(xhr.responseText);  // Procesar la respuesta del servidor si es necesario
                                    }
                                };
                                var data = "filas=" + JSON.stringify(productos);
                                xhr.send(data);  // Enviar las variables filas y vuelto
                            }
                            
                        }
                    
            function cargar(){
                // Obtener la tabla
                var tabla = document.getElementById("tablita");

                // Crear una nueva fila
                var nuevaFila = tabla.insertRow(1); // -1 inserta la fila al final de la tabla

                // Crear las columnas para la fila
                var celdaProducto = nuevaFila.insertCell(0);
                var celdaPrecio = nuevaFila.insertCell(1);
                var celdaCantidad = nuevaFila.insertCell(2);
                var celdaOferta = nuevaFila.insertCell(3);
                var celdacancel = nuevaFila.insertCell(4);



                // Asignar valores a las celdas
                var producto = document.getElementById("producto");
                var precio = document.getElementById("precios").value;
                var cantidad = document.querySelector("input[type='number']").value;
                var oferta = document.querySelector("input[type='number'][step='5']").value;
                celdaProducto.innerHTML = producto.options[producto.selectedIndex].text;
                celdaProducto.value =document.getElementById("producto").value;
                celdaPrecio.innerHTML = precio;
                celdaPrecio.value = precio;
                celdaCantidad.innerHTML = cantidad;
                celdaOferta.innerHTML = oferta + "%";
                celdacancel.innerHTML = "<button onclick='borrrar(this)' id='hola'>X</button>"
                        }
                function juajaja() {
                    document.getElementById("p0").style.display="none"
                    var resultado=document.getElementById("producto").value;
                    <?php
                    $cnx=mysqli_connect("localhost","root","","nano") or die("Problemas con la conexión");
                    
                    //2-CREAR CONSULTA
                    $sql="SELECT precio_unitario,id_producto FROM producto";

                    //3-EJECUTAR LA CONSULTA
                    $resultado=mysqli_query($cnx,$sql) or die("No se pudo subir el archivo");
                    
                    while($fila=mysqli_fetch_array($resultado))
                    {
                        echo "if ('$fila[id_producto]'==resultado)var prec='$fila[precio_unitario]';";
                    }
                    ?>
                    document.getElementById('precios').innerHTML=prec;
                    document.getElementById('precios').value=prec;
                    if (document.getElementById("producto").value=="0") {
                        document.getElementById(id="precios").innerHTML="0";
                    }
                }
    </script>
</head>
<body id="cuerpo">
    <a href="index.html"><img src="atras.png" width="100px" height="60px"></a>
    <section class = "form-register">
    <h4>CAJA</h4>
    <a href="ABM.php"><button class = "botons" type="button">Actualizar datos</button></a>
    <a href="stock.php"><button class = "botons" >Ver stock</button></a>
    <div> <!-- fiados-->
        <select  class = "controls" id="cliente" onchange="precios_fiado();">
            <option value="0">-</option>
            <?php
                //1-CONEXION A BD
                $cnx=mysqli_connect("localhost","root","","nano") or die("Problemas con la conexión");

                //2-CREAR CONSULTA
                $sql="SELECT nombre,apellido,id_cliente FROM cliente";

                //3-EJECUTAR LA CONSULTA
                $resultado=mysqli_query($cnx,$sql) or die("No se pudo subir el archivo");

                //4-CERRAR LA CONEXIÓN A LA BD.
                mysqli_close($cnx);
                
                while($fila=mysqli_fetch_array($resultado))
                {
                    echo "<option value='$fila[id_cliente]'> $fila[nombre] $fila[apellido]</option>";
                }
            ?>
        </select>
    </div>
    <div>  <!--tabla-->
        <table class = "styled-table" border="1px" name="tablas">
            <tbody id="tablita">
            <tr id="encabezado">
                <th>producto</th>
                <th>precio</th>
                <th>cantidad</th>
                <th>oferta</th>
            </tr>
            
            <tr>
                <td>
                    <select class = "controls" id="producto" onclick="juajaja();">
                        <option value="0" id="p0"></option>
                        <?php
                            //1-CONEXION A BD
                            $cnx=mysqli_connect("localhost","root","","nano") or die("Problemas con la conexión");
                            //2-CREAR CONSULTA
                            $sql="SELECT p.`id_producto`,t.`tipo`,m.`marca`
                            FROM `producto` p
                            inner join marcas as m on p.id_marca=m.id_marca
                            inner join tipos as t on p.id_tipo=t.id_tipo";
                            //3-EJECUTAR LA CONSULTA
                            $resultado=mysqli_query($cnx,$sql) or die("No se pudo subir el archivo");
                            $resultado1=mysqli_query($cnx,$sql) or die("No se pudo subir el archivo");
                            while($fila=mysqli_fetch_array($resultado))
                            {
                                echo "<option value='$fila[id_producto]'> $fila[tipo] $fila[marca]</option>";
                            }
                            ?>
                            </select>
                            </td>
                            <td> <label id="precios">0</label>
                    </td>
                <td><input class = "controls" type="number" min="0" style="width:50px" value="0"></td>
                <td><input class = "controls" type="number" step="5" min="0" max="100"style="width:40px" value="0">%</td>
                <td><button class = "botons" onclick="cargar();">OK</button></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div>  <!-- confirmacion-->
        <button class = "botons" type="button" onclick="confirmar()">confirmar</button>
        <br>
        <label id="conf"></label>
    </div>
    </section>
</body>
</html>