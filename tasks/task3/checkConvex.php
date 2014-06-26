<?php

error_reporting(0);
function Convex($polygon)
{
    $flag = 0;
    $NumPoints = count($polygon);

    if($polygon[$NumPoints-1] == $polygon[0]){
        $NumPoints--;
    }else{
        //Add the first point at the end of the array.
        $polygon[$NumPoints] = $polygon[0];
    }

    if ($NumPoints < 3)
        return false;

    for ($i=0;$i<$NumPoints;$i++) {
        $j = ($i + 1) % $NumPoints;
        $k = ($i + 2) % $NumPoints;
        $z  = ($polygon[$j][0] - $polygon[$i][0]) * ($polygon[$k][1] - $polygon[$j][1]);
        $z -= ($polygon[$j][1] - $polygon[$i][1]) * ($polygon[$k][0] - $polygon[$j][0]);
        if ($z < 0)
            $flag |= 1;
        else if ($z > 0)
            $flag |= 2;
        if ($flag == 3)
            return false;
    }
    if ($flag != 0)
        return true;
    else
        return false;
}
$defaultPolygon = $_POST["polygon"];

$defaultPolygon = json_decode($defaultPolygon, true);
echo Convex($defaultPolygon);