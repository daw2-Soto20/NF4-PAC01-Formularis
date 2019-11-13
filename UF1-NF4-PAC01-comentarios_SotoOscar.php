<?php
$db = mysqli_connect('localhost', 'root') or die ('Unable to connect. Check your connection parameters.');

mysqli_select_db($db,'boardgamesite') or die(mysqli_error($db));

//FUNCION PARA GENERAR EL RATIO DE VALORACIONES
function generate_ratings($rating) {
    $boardgame_rating = '';
    for ($i = 0; $i < $rating; $i++) {
        $boardgame_rating .= '<img src="star.png" alt="star"/>';
    }
    return $boardgame_rating;
}


// ENVIAR EL ID DEL DIRECTOR Y DEVOLVER SU NOMBRE
function get_disenyador($disenyador_id) {

    global $db;

    $query = 'SELECT 
            people_fullname 
       FROM
           people
       WHERE
           people_id = ' . $disenyador_id;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $people_fullname;
}

function get_artista($artista_id) {

    global $db;

    $query = 'SELECT
            people_fullname
        FROM
            people 
        WHERE
            people_id = ' . $artista_id;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $people_fullname;
}

// FUNCION A LA QUE ENVIAMOS EL ID TIPO Y NOS DEVUELVE LA DESCRIPCION
function get_boardgtype($type_id) {

    global $db;

    $query = 'SELECT 
            boardgtype_label
       FROM
           boardgametype
       WHERE
           boardgtype_id = ' . $type_id;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $boardgtype_label;
}


// FUNCION PARA CALCULA SI UN JUEGO HA TENIDO BENEFICIOS O PERDIDAS
function calculate_differences($takings, $cost) {

    $difference = $takings - $cost;

    if ($difference < 0) {     
        $color = 'red';
        $difference = '$' . abs($difference) . ' million';
    } elseif ($difference > 0) {
        $color ='green';
        $difference = '$' . $difference . ' million';
    } else {
        $color = 'blue';
        $difference = 'broke even';
    }

    return '<span style="color:' . $color . ';">' . $difference . '</span>';
}

$variable_get = $_GET['boardgame_id'];

// RECUPERAMOS DATOS
$query = 'SELECT
        boardgame_name, boardgame_year, boardgame_designer, boardgame_artist, boardgame_type, boardgame_duracion, boardgame_precio, boardgame_beneficios
    FROM
        boardgame
    WHERE
        boardgame_id = ' . $variable_get;
        
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$row = mysqli_fetch_assoc($result);
extract($row);

$name = $boardgame_name;
$designer = get_disenyador($boardgame_designer);
$artist = get_artista($boardgame_artist);
$year = $boardgame_year;
$duracion = $boardgame_duracion . " mins";
$beneficios = $boardgame_beneficios . " million";
$precio = $boardgame_precio . " million";
$perdidas = calculate_differences($boardgame_beneficios,$boardgame_precio);

// MOSTRAMOS LOS DATOS A TRAVES DE UNA TABLA HTML QUE FORMATEAMOS
echo <<<ENDHTML
<html>
 <head>
    <title>Detalles y Reviews for: $boardgame_name</title>
 </head>
 <body>
  <div style="text-align: center;">
   <h2>$name</h2>
   <h3><em>Detalles</em></h3>
   <table border="1" cellpadding="2" cellspacing="2" style="width: 70%; margin-left: auto; margin-right: auto; border-collapse: collapse;">
    <tr>
     <td><strong>Title</strong></strong></td>
     <td>$name</td>
     <td><strong>Año Lanzamiento</strong></strong></td>
     <td>$year</td>
    </tr>
    <tr>
     <td><strong>Diseñador Juego</strong></td>
     <td>$designer</td>
     <td><strong>Costes</strong></td>
     <td>$precio</td>
    </tr>
    <tr>
     <td><strong>Artista</strong></td>
     <td>$artist</td>
     <td><strong>Recaudacion</strong></td>
     <td>$beneficios</td>
    </tr>
    <tr>
     <td><strong>Duracion</strong></td>
     <td>$duracion</td>
     <td><strong>Diferencia</strong></td>
     <td>$perdidas</td>
    </tr>
   </table>
ENDHTML;

$orden = $_GET['ordenar'];

// RECUPERAMOS LAS REVIEWS
$query = 'SELECT
        review_boardgame_id, review_date, reviewer_name, review_comment, review_rating
    FROM
        reviews
    WHERE
        review_boardgame_id =' . $variable_get . '
    ORDER BY ' . $orden . ' DESC';

$result = mysqli_query($db, $query) or die(mysqli_error($db));

// MOSTRAMOS TODAS LAS REVIEWS DEL JUEGO ESCOGIDO
echo <<<ENDHTML
    <br/>
   <h3><em>Reviews</em></h3>
   <table border="1" cellpadding="2" cellspacing="2" style="width: 70%; margin-left: auto; margin-right: auto; border-collapse: collapse;">
    <tr>
     <th style="width: 7em;"><a href="UF1-NF4-PAC01-comentarios_SotoOscar.php?boardgame_id=$variable_get&ordenar=review_date">Fecha</a></th>
     <th style="width: 10em;"><a href="UF1-NF4-PAC01-comentarios_SotoOscar.php?boardgame_id=$variable_get&ordenar=reviewer_name">Reviewer</a></th>
     <th><a href="UF1-NF4-PAC01-comentarios_SotoOscar.php?boardgame_id=$variable_get&ordenar=review_comment">Comentarios</a></th>
     <th style="width: 5em;"><a href="UF1-NF4-PAC01-comentarios_SotoOscar.php?boardgame_id=$variable_get&ordenar=review_rating">Rating</a></th>
    </tr>
ENDHTML;

$cont=0;
$media_total=0;

//BUCLE PARA GUARDAR EN VARIABLES EL RESULTADO DE LAS FUNCIONES
while ($row = mysqli_fetch_assoc($result)) {
    $date = $row['review_date'];
    $name = $row['reviewer_name'];
    $comment = $row['review_comment'];
    $rating = generate_ratings($row['review_rating']);
    $media_rating = $row['review_rating'];
    
    if ($cont%2!=0){
        $background = "background-color: #EFB585";
    }
    else{
        $background = "background-color: #9FC0D3";
    }
    
    $cont++;
    
    $media_total += $media_rating; // declaro variable para ir acumulando los rating de cada registro
    
    echo <<<ENDHTML
    <tr>
      <td style="vertical-align:top; text-align: center;$background">$date</td>
      <td style="vertical-align:top; text-align: center;$background">$name</td>
      <td style="vertical-align:top; text-align: center;$background">$comment</td>
      <td style="vertical-align:top; text-align: center;$background">$rating</td>
    </tr>
ENDHTML;
}

$media_total = ($media_total)/$cont; //calculo la media
$parte_entera = intval($media_total); //saco la parte entera
$parte_decimal = $media_total-$parte_entera; //calculo la parte decimal
$parte_rating = generate_ratings($parte_entera); //calculo el rating de la parte entera que mostraré con estrellas
$percent = 0;

//Condicion para pintar la parte de estrella necesaria en funcion del tanto porciento
if ($parte_decimal>0){// si parte decimal es mayor 
    $percent = $parte_decimal*100;
    $percent = intval(100-$percent);
    $parte_rating .= '<img src="star.png" alt="star" style="clip-path:inset(0% '. $percent .'% 0% 0%);"/>';
}


echo <<<ENDHTML
    <tr style="border:2px solid">
        <td colspan="3" style="vertical-align:top; text-align: center; background-color: #CEE3EA"><strong>Media</strong></td>
        <td style="vertical-align:top; text-align: center; background-color: #CEE3EA">$parte_rating</td>
    </tr>
    </table>
  </div>
ENDHTML;

/////////////////////////UF1-NF4-PAC01//////////////////
$formulario.= <<<FORM
        <div style="margin-top:50px; margin-left:450px">
            <form action="UF1-NF4-PAC01-recibe-form_SotoOscar.php" method="post">
                <table>
                <tr>
                  <td>Id Juego: </td>
                  <td><input type="hidden" name="idjuego" value="$variable_get"/>$variable_get</td>
                 </tr>
                 <tr>
                  <td>Nombre Juego: </td>
                  <td><input type="hidden" name="nombre" value="$boardgame_name"/>$boardgame_name</td>
                 </tr>
                <tr>
                  <td>Fecha: </td>
                  <td><input type="date" name="fecha"/></td>
                 </tr>
                 <tr>
                    <td>Reviewer: </td>
                  <td><input type="text" name="reviewer"/></td>
                 </tr>
                <tr>
                  <td>Comentario: </td>
                  <td><textarea name="comentario" cols="40" rows="5"></textarea></td>
                 </tr>
                <tr>
                  <td>Valoracion: </td>
                  <td><select name="valoracion">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                  </td>
                 </tr>
                 <tr>
                   <td colspan="2" style="text-align: center">
                   <input type="submit" name="submit" value="Enviar"/></td>
                 </tr>
                </table>
            </form>
        </div>
    </body>
</html>
FORM;
echo $formulario;
?>