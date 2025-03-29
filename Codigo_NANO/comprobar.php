<!DOCTYPE html>
<?php
$contraseña=$_GET['contrasena'];
if  (empty($contraseña)) {
    echo "<script>
                alert('contraseña incorrecta');
                window.location.href = 'index.html';
            </script>";
    exit();
}
if (isset($_GET['admin'])) {
    $usuario=$_GET['usuario1'];

    $cnx=mysqli_connect("localhost","root","","nano") or die("Problemas con la conexión");

    //2-CREAR CONSULTA
    $sql="SELECT `nombre` FROM `usuario` WHERE `contraseña`='$contraseña' AND `nombre`='$usuario'";

    //3-EJECUTAR LA CONSULTA
    $resultado=mysqli_query($cnx,$sql) or die("No se pudo subir el archivo");

    //4-CERRAR LA CONEXIÓN A LA BD.
    mysqli_close($cnx);
    if (mysqli_fetch_row($resultado)>0) {
        echo "<script>
                window.location.href = 'admin.php';
            </script>";
    }else{
        echo "<script>
                alert('contraseña incorrecta');
                window.location.href = 'index.html';
            </script>";
    }
}
else if (isset($_GET['empleado'])) {
    $usuario=$_GET['usuario2'];
    
    $cnx=mysqli_connect("localhost","root","","nano") or die("Problemas con la conexión");

    //2-CREAR CONSULTA
    $sql="SELECT `nombre` FROM `usuario` WHERE `contraseña`='$contraseña' AND `nombre`='$usuario'";

    //3-EJECUTAR LA CONSULTA
    $resultado=mysqli_query($cnx,$sql) or die("No se pudo subir el archivo");

    //4-CERRAR LA CONEXIÓN A LA BD.
    mysqli_close($cnx);
    if (mysqli_fetch_row($resultado)>0) {
        echo "<script>
                window.location.href = 'normi.php';
            </script>";
    }else{
        echo "<script>
                alert('contraseña incorrecta');
                window.location.href = 'index.html';
            </script>";
    }
}
?>
