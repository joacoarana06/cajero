<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Stock</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<a href="admin.php"><img src="atras.png" width="100px" height="60px"></a>
	<section class = "form-register">
	<h1>Lista de productos</h1>
	<?php
		//1-CONEXION A BD
	$cnx=mysqli_connect("localhost", "root", "", "nano") or die("Problemas con la conexión");
	//2-CREAR CONSULTA
	$sql = "SELECT p.`id_producto`,t.`tipo`,m.`marca`,r.`rubro`,p.`precio_unitario`,p.`stock`
						FROM `producto` p
						inner join marcas as m on p.id_marca=m.id_marca
						inner join tipos as t on p.id_tipo=t.id_tipo
						inner join rubro as r on p.id_rubro=r.id_rubro";
	//3-EJECUTAR LA CONSULTA
	$resultado=mysqli_query($cnx,$sql) or die("No se pudo mostrar la lista de alumnos/as");
	//4-CERRAR LA CONEXIÓN A LA BD.
	mysqli_close($cnx);
	?>
	<table class = "styled-table" border="5px">
		<tr>
			<th>Producto</th>
			<th>Stock</th>
			<th>Precio</th>
		</tr>
	<?php
	while($fila=mysqli_fetch_array($resultado))
	{
		echo "<tr>";
		echo "<td>$fila[tipo] $fila[marca]</td>";
		echo "<td>$fila[stock]</td>";
		echo "<td>$fila[precio_unitario]</td>";
		echo "</tr>";
	}
	?>
	</table>
	</section>
</body>
</html>