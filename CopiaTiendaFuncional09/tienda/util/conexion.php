<?php
    $_servidor = "127.0.0.1"; // es lo mismo que poner localhost
    $_usuario = "estudiante";
    $_contrasena = "estudiante";
    $_base_de_datos = "tienda_bd";

    //Mysqli o PDO
    $_conexion = new Mysqli($_servidor,$_usuario,$_contrasena,$_base_de_datos)
        or die("Error de conexión");
?>