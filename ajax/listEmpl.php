<?php
include_once ('../db/config.php');
$dataConfig = new Config();
$dataConfig = $dataConfig->dataConfig();
$conexion= new mysqli($dataConfig['host'],$dataConfig['user'],$dataConfig['pass'],$dataConfig['database']);
$conexion->query("SET NAMES 'utf8'");

$sql = "SELECT e.*, a.nombre AS nombre_area FROM `empleados` AS e 
        INNER JOIN areas AS a ON a.id = e.area_id";
$result = $conexion->query($sql);

$data=array();
while($row = $result->fetch_array(MYSQLI_ASSOC)){
    $data[] = $row;
}


$results = ["sEcho" => 1,
    "iTotalRecords" => count($data),
    "iTotalDisplayRecords" => count($data),
    "aaData" => $data ];
echo json_encode($results);