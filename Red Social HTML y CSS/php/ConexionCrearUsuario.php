<?php

// Incluimos el archivo de conexión
include("conexion1.php");

// Declaramos variables para recibir y guardar los datos enviados desde el formulario
$nickname = $_POST["ninickname"];
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$edad = $_POST["edad"];
$descripcion = $_POST["descripcion"];
$email = $_POST["correo"];
$password = $_POST["contraseña"];

// Hasheamos la contraseña con el algoritmo BCRYPT
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

// Definimos la ruta de la foto de perfil
$fotoPerfil = "img/$nickname/perfil.jpg";

// Verificamos si el nickname ingresado ya existe en la base de datos
$consultaId = "SELECT Nickname FROM persona WHERE Nickname= '$nickname' ";
$consultaId = mysqli_query($conexion, $consultaId);
$consultaId = mysqli_fetch_array($consultaId);

// Si la consulta no devuelve ningún resultado, creamos un nuevo usuario
if (!$consultaId) {

    // Generamos la consulta SQL de inserción
    $aql = "INSERT INTO persona VALUES (   '$nickname', '$nombre' , '$apellidos' , '$edad' , '$descripcion' , '$fotoPerfil', '$email' ,'$passwordHash )";

    // Ejecutamos la consulta y verificamos si se guardaron los datos
    if (mysqli_query($conexion, $aql)) {

        // Creamos una carpeta para el usuario y copiamos la foto de perfil por defecto
        mkdir("../img/$nickname");
        copy("../img/default.jpg", "../img/$nickname/perfil.jpg");

        // Mostramos un mensaje de éxito y un enlace para iniciar sesión
        echo "tu cuenta ha sido creada.";
        echo "<br> <a href=' ../index.html' >Iniciar Secion</a></div>";
    } else {
        // Si hubo un error, mostramos el mensaje de error
        echo "Error:" . $aql . "<br>" . mysqli_error($conexion);
    }
} else {
    // Si el nickname ya existe, mostramos un mensaje de error
    echo "El Nickname ya existe.";
    echo "<a href='index.html' > Intentalo de nuevo.</a></div>";
}

// Cerramos la conexión
mysqli_close($conexion);
?>