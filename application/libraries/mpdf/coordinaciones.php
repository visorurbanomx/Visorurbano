<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
header('Content-type: text/plain; charset=utf-8');
$mysqli = new mysqli('localhost', 'root', '', 'becas');

if ($mysqli->connect_errno) {
  
    echo "Lo sentimos, este sitio web está experimentando problemas.";

    echo "Error: Fallo al conectarse a MySQL debido a: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
  
    exit;
}

// Realizar una consulta SQL
$sql = "SELECT `id_alumno`, `numero`, `alumno`, `preparatoria`, `semestre`, `tutor`, `activo`, `asistio`, `color` FROM `alumnos` WHERE `activo` = 'S' AND `asistio` = 'N';";
if (!$resultado = $mysqli->query($sql)) {
    // ¡Oh, no! La consulta falló. 
    echo "Lo sentimos, este sitio web está experimentando problemas.";

    echo "Error: La ejecución de la consulta falló debido a: \n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;

}

// ¡Uf, lo conseguimos!. Sabemos que nuestra conexión a MySQL y nuestra consulta
// tuvieron éxito, pero ¿tenemos un resultado?
if ($resultado->num_rows === 0) {
   
    echo json_encode(array('status' => FALSE, 'error' => 'No hay registros que mostrar'));
    exit;
}

$results = array();

while($row = $resultado->fetch_assoc())
{
   $results[] = array(
      'id_alumno' => $row['id_alumno'],
      'numero' => $row['numero'],
      'alumno' => utf8_encode($row['alumno']),
      'tutor' => utf8_encode($row['tutor']),
      'asistio' => utf8_encode($row['asistio']),
      'semestre' => $row['semestre'],
      'preparatoria' => utf8_encode($row['preparatoria']),
      'color' => utf8_encode($row['color'])
   );
}

echo json_encode(array('status' => TRUE, 'data' => $results));

$resultado->free();
$mysqli->close();
?>