<?php
include "conexion.php";

$id_mat = 5;
$t_materia = "SELECT * FROM tipo_mat";

$resultado_t_materia = $conexion->query($t_materia);

$materias = array();
while ($row = mysqli_fetch_assoc($resultado_t_materia)) {
    //tomar las primeras 3 letras del nombre de la materia prima
    $materias[$row['id_tip_mat']] = substr($row['nom_tip_mat'], 0, 3);
}

$mater = [
    1 => "cha",
    2 => "chi",
    3 => "pol",
    4 => "pav",
    6 => "pes"
];

$cod = $materias[$id_mat] != null ? $materias[$id_mat] : "emb";

print_r($mater);
echo "<br>";
print_r($materias);

echo "<br>";
echo $cod;
