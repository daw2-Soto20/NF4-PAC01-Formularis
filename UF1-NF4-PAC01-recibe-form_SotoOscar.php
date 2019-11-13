<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibe Formulario</title>
</head>
<body>
    <h1>ACABAS DE INSERTAR DATOS EN LA TABLA DE COMENTARIOS</h1>
</body>
</html>
<?php
    $db = mysqli_connect('localhost', 'root') or die ('Unable to connect. Check your connection parameters.');

    mysqli_select_db($db,'boardgamesite') or die(mysqli_error($db));

    if (isset($_POST['submit'])){
        $id = $_POST['idjuego'];
        $nombre = $_POST['nombre'];
        $fecha = $_POST['fecha'];
        $reviewer = $_POST['reviewer'];
        $valoracion = $_POST['valoracion'];
        $comentario = $_POST['comentario'];

        //INSERTO DATOS DEL FORMULARIO EN LA TABLA
        $query=<<<INICIOSQL
        INSERT INTO reviews
            (review_boardgame_id, review_date, reviewer_name, review_comment,
                review_rating)
        VALUES 
            ($id, "$fecha", "$reviewer", "$comentario", $valoracion)
INICIOSQL;
        mysqli_query($db,$query) or die (mysqli_error($db));
}
$imprime.=<<<IMP
    <br>
    <p style="font-weight: bold;font-size: x-large;"><a href="UF1-NF4-PAC01-comentarios_SotoOscar.php?boardgame_id=$id&ordenar=review_date">Volver a la pagina detalles para visualizar los cambios</a></p>
IMP;
echo $imprime;
?>