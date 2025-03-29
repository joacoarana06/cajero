<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATOS NANO</title>
    <link rel="stylesheet" href="style.css">
    <script>
        // Función para actualizar el formulario dinámicamente basado en el botón y la tabla seleccionada
        function actualizarFormulario() {
            var tabla = document.getElementById("tabla").value;
            var accion = document.querySelector('input[name="accion"]:checked').value;
            document.getElementById('1:').value=""
            document.getElementById('2:').value=""
            document.getElementById('3:').value=""
            document.getElementById('4:').value=""
            // Mostrar los campos correspondientes basados en la acción seleccionada
            if (accion === "Nuevo") {
                document.getElementById("title").innerHTML= "Crear Nuevo Registro";
                document.getElementById("conexiones").style.display = "none";
                document.getElementById("nuevoForm").style.display = "block";
                document.getElementById("actualizarForm").style.display = "none";
                document.getElementById("borrarForm").style.display = "none";
                document.getElementById("borrarForm_p2").style.display = "none";
                document.getElementById("selectDatos").style.display = "none";
            } else if (accion === "Actualizar" ) {
                document.getElementById("title").innerHTML= "Actualizar Registro";
                document.getElementById("conexiones").style.display = "none";
                document.getElementById("nuevoForm").style.display = "block";
                document.getElementById("actualizarForm").style.display = "block";
                document.getElementById("borrarForm").style.display = "none";
                document.getElementById("borrarForm_p2").style.display = "none";
                document.getElementById("selectDatos").style.display = "block";
                cargarDatos(tabla); // Cargar datos dinámicamente según la tabla seleccionada
            }
            else if (accion === "Borrar") {
                document.getElementById("title").innerHTML= "Borrar Registro";
                document.getElementById("nuevoForm").style.display = "none";
                document.getElementById("actualizarForm").style.display = "none";
                document.getElementById("borrarForm").style.display = "block";
                document.getElementById("borrarForm_p2").style.display = "block";
                document.getElementById("selectDatos").style.display = "block";
                cargarDatos(tabla); // Cargar datos dinámicamente según la tabla seleccionada
        }
        if (tabla==="cliente") {
            document.getElementById("conexiones").style.display = "none";
            document.getElementById('1:').type="text"
            document.getElementById('2:').type="text"
            document.getElementById('3:').type="number"
            document.getElementById('4:').type="number"
            document.getElementById('1:').placeholder = 'Nombre';
            document.getElementById('2:').placeholder = 'Apellido';
            document.getElementById('3:').placeholder = 'teléfono';
            document.getElementById('4:').placeholder = 'fiado';
            document.getElementById('2:').style.display = 'inline';
            document.getElementById('3:').style.display = 'inline';
            document.getElementById('4:').style.display = 'inline';
        }
        else if(tabla==="marcas"){
            document.getElementById("conexiones").style.display = "none";
            document.getElementById('1:').type="text"
            document.getElementById('1:').placeholder = 'Marca';
            document.getElementById('2:').style.display = 'none';
            document.getElementById('3:').style.display = 'none';
            document.getElementById('4:').style.display = 'none';
        }
        else if(tabla==="producto"){
            document.getElementById("conexiones").style.display = "block";
            if (accion === "Borrar") {
                document.getElementById("conexiones").style.display = "none";
            }
            else{document.getElementById("conexiones").style.display = "block";}
            document.getElementById('1:').type="number"
            document.getElementById('2:').type="number"
            document.getElementById('3:').type="number"
            document.getElementById('1:').placeholder = 'Precio Unitario';
            document.getElementById('2:').placeholder = 'Stock';
            document.getElementById('3:').placeholder = 'Código';
            document.getElementById('2:').style.display = 'inline';
            document.getElementById('3:').style.display = 'inline';
            document.getElementById('4:').style.display = 'none';
            
        }
        else if(tabla==="proveedor"){
            document.getElementById("conexiones").style.display = "none";
            document.getElementById('1:').type="email"
            document.getElementById('2:').type="text"
            document.getElementById('3:').type="number"
            document.getElementById('1:').placeholder = 'mail';
            document.getElementById('2:').placeholder = 'ubicación';
            document.getElementById('3:').placeholder = 'teléfono';
            document.getElementById('2:').style.display = 'inline';
            document.getElementById('3:').style.display = 'inline';
            document.getElementById('4:').style.display = 'none';
        }
        else if(tabla==="rubro"){
            document.getElementById("conexiones").style.display = "none";
            document.getElementById('1:').type="text"
            document.getElementById('1:').placeholder = 'Rubro';
            document.getElementById('2:').style.display = 'none';
            document.getElementById('3:').style.display = 'none';
            document.getElementById('4:').style.display = 'none';
        }
        else if(tabla==="tipo"){
            document.getElementById("conexiones").style.display = "none";
            document.getElementById('1:').type="text"
            document.getElementById('1:').placeholder = 'Tipo';
            document.getElementById('2:').style.display = 'none';
            document.getElementById('3:').style.display = 'none';
            document.getElementById('4:').style.display = 'none';
        }
    }
        // Función para cargar datos (clientes, marcas, productos, etc.) desde la base de datos según la tabla seleccionada
        function cargarDatos(tabla) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "ABM/cargar_datos.php?tabla=" + tabla, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("selectDatos").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
        function errase() {
            document.getElementById("errase").style.display= "none";
        }
        function validar() {
            var tabla = document.getElementById("tabla").value;
            var accion = document.querySelector('input[name="accion"]:checked').value;
            var v1= document.getElementById('1:').value;
            var v2= document.getElementById('2:').value;
            var v3= document.getElementById('3:').value;
            var v4= document.getElementById('4:').value;
            if (accion!=="Borrar") {
                if (tabla === "cliente" && v1!="" && v2!="" && v3!="") {
                    return true;
                }else if (tabla === "marcas" && v1!="") {
                    return true;
                }else if (tabla === "tipo" && v1!="") {
                    return true;
                }else if (tabla === "producto" && v1!="" && v2!="" && v3!="") {
                    return true;
                }else if (tabla === "proveedor" && v1!="" && v3!="") {
                    return true;
                }else if (tabla === "rubro" && v1!="") {
                    return true;
                }else{
                    alert("complete todos los campos")
                    return false;
                }
            }
            }
    </script>
</head>
<body>
<section class = "form-register">
<form method="POST" action="ABM/nuevo.php" onsubmit="return validar()">
    <!-- Selección de la tabla -->
    <select id="tabla" class = "controls" name="tabla" onchange="actualizarFormulario()" onclick="errase()" required>
        <option value="" id="errase">Seleccione una tabla</option>
        <option value="cliente">Cliente</option>
        <option value="marcas">Marca</option>
        <option value="tipo">Tipo</option>
        <option value="producto">Producto</option>
        <option value="proveedor">Proveedor</option>
        <option value="rubro">Rubro</option>
    </select>
    <br>
    <!-- Selección de acción -->
    <input type="radio" id="nuevo" name="accion" value="Nuevo" onchange="actualizarFormulario()" required> Nuevo
    <input type="radio" id="actualizar" name="accion" value="Actualizar" onchange="actualizarFormulario()" required> Actualizar
    <input type="radio" id="borrar" name="accion" value="Borrar" onchange="actualizarFormulario()" required> Borrar
    <br>
    <h3 id="title"></h3>
    <!-- Formulario dinámico para Actualizar/Borrar -->
    <div id="actualizarForm" style="display:none;">
        Seleccione Registro:
        <br>
    </div>
    <div id="borrarForm" style="display:none;">
        Seleccione Registro:
        <br>
    </div>
    <select id="selectDatos" class = "controls" name="registro" style="display:none;">
            <!-- Aquí se cargarán los datos dinámicamente desde la base de datos -->
    </select>
    <div id="borrarForm_p2" style="display:none;">
        <p>¿Está seguro de que desea borrar este registro?</p>
    </div>
    <div id="conexiones" style="display:none;">
        Tipo:
        <select name="tipos" class = "controls">
            <?php
                $cnx = mysqli_connect("localhost", "root", "", "nano") or die("Problemas con la conexión");
                $sql = "SELECT * FROM `tipos`";
                $resultado = mysqli_query($cnx, $sql) or die("No se pudo subir el archivo");
                mysqli_close($cnx);
                while($fila = mysqli_fetch_array($resultado)) {
                    echo "<option value='$fila[id_tipo]'>$fila[tipo]</option>";
                }
            ?>
        </select><br>
        Marca:
        <select name="marcas" class = "controls">
            <?php
                $cnx = mysqli_connect("localhost", "root", "", "nano") or die("Problemas con la conexión");
                $sql = "SELECT * FROM `marcas`";
                $resultado = mysqli_query($cnx, $sql) or die("No se pudo subir el archivo");
                mysqli_close($cnx);
                while($fila = mysqli_fetch_array($resultado)) {
                    echo "<option value='$fila[id_marca]'>$fila[marca]</option>";
                }
            ?>
        </select><br>
        Rubro:
        <select name="rubro" class = "controls">
            <?php
                $cnx = mysqli_connect("localhost", "root", "", "nano") or die("Problemas con la conexión");
                $sql = "SELECT * FROM `rubro`";
                $resultado = mysqli_query($cnx, $sql) or die("No se pudo subir el archivo");
                mysqli_close($cnx);
                while($fila = mysqli_fetch_array($resultado)) {
                    echo "<option value='$fila[id_rubro]'>$fila[rubro]</option>";
                }
            ?>
        </select><br>
    </div>
    <!-- Formulario dinámico para Nuevo -->
    <div id="nuevoForm" style="display:none;">
        <input type="text" class = "controls" name="1" id="1:"><br>
        <input type="text" class = "controls" name="2" id="2:"><br>
        <input type="text" class = "controls" name="3" id="3:"><br>
        <input type="text" class = "controls" name="4" id="4:">
    </div>
    <div id="code">
        
    </div>
    <input type="submit" value="Enviar" class="botons">
</form>

<br>
<a class="link" href="admin.php">Volver</a>
</section>
</body>
</html>
