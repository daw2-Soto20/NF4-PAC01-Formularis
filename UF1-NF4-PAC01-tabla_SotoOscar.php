<?php
$db = mysqli_connect('localhost', 'root') or 
    die ('Unable to connect. Check your connection parameters.');

mysqli_select_db($db,'boardgamesite') or die(mysqli_error($db));
    
//pasamos por parametro el id del diseñador y devuelve su nombre complero
function get_disenyador($disenyador_id) {

    global $db;
    //mysqli_select_db($db,'boardgamesite') or die(mysqli_error($db));

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
    //mysqli_select_db($db,'boardgamesite') or die(mysqli_error($db));

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

// take in the id of a movie type and return the meaningful textual
// description
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

// retrieve information
$query = 'SELECT
        boardgame_id, boardgame_name, boardgame_year, boardgame_designer,
        boardgame_artist, boardgame_type
    FROM
        boardgame
    ORDER BY
        boardgame_name ASC,
        boardgame_year DESC';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

// determine number of rows in returned result
$num_boardgames = mysqli_num_rows($result);

$table = <<<ENDHTML
<div style="text-align: center;">
 <h2>Boardgames review database</h2>
 <table border="1" cellpadding="2" cellspacing="2"
  style="width: 70%; margin-left: auto; margin-right: auto;">
  <tr>
   <th>Titulo Juego</th>
   <th>Año Lanzamiento</th>
   <th>Diseñador Juego</th>
   <th>Artista Juego</th>
   <th>Tipo Juego</th>
  </tr>
ENDHTML;

// Bucle que guarda los resultados en distintas variables
while ($row = mysqli_fetch_assoc($result)) {
    extract($row);
    $disenyador = get_disenyador($boardgame_designer); 
    $artista = get_artista($boardgame_artist);
    $boardgtype = get_boardgtype($boardgame_type);////<-----------VAS POR AQUI

    $table .= <<<ENDHTML
    <tr>
     <td><a href="UF1-NF4-PAC01-comentarios_SotoOscar.php?boardgame_id=$boardgame_id&ordenar=review_date">$boardgame_name</a></td>
     <td>$boardgame_year</td>
     <td>$disenyador</td>
     <td>$artista</td>
     <td>$boardgtype</td>
    </tr>
ENDHTML;
}

$table .= <<<ENDHTML
 </table>
<p>$num_boardgames Juegos</p>
</div>
ENDHTML;

echo $table;
?>
