<?php
include "pointAlg.php";
$defaultPolygon = $_POST["polygon"];
$defaultPolygon = json_decode($defaultPolygon, true);
$defaultTestPoints = $_POST["points"];
$defaultTestPoints = json_decode($defaultTestPoints, true);
$pointLocation = new pointLocation();
foreach ($defaultTestPoints as $key => $point) {
    echo "point " . ($key + 1) . $pointLocation->pointToString($point) . " : " . $pointLocation->pointInPolygon($point, $defaultPolygon) . "<br>";
}
