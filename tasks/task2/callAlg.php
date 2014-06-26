<?php
$defaultPolygon = $_POST["polygon"];

$defaultPolygon = json_decode($defaultPolygon, true);
$defaultTestPoints = $_POST["points"];
$defaultTestPoints = json_decode($defaultTestPoints, true);
function findAngle($p0,$p1,$p2) {
    $a = pow($p1[0]-$p0[0],2) + pow($p1[1]-$p0[1],2);
      $b =pow($p1[0]-$p2[0],2) +pow($p1[1]-$p2[1],2);
      $c =pow($p2[0]-$p0[0],2) + pow($p2[1]-$p0[1],2);
  return acos( ($a+$b-$c) / sqrt(4*$a*$b) );
}

function orientedArea($p0,$p1,$p2){
  return  0.5*(($p1[0]-$p0[0])*($p2[1]-$p0[1])
              -($p2[0]-$p0[0])*($p1[1]-$p0[1])
              );
}


function pointInPolygon($defaultPolygon, $points)
{
    $last = count($defaultPolygon) - 1;
    $center = null;
    foreach ($defaultPolygon as $i => $point) {
        if (($defaultPolygon[$i][0] * ($defaultPolygon[$i + 1][1] - $defaultPolygon[$i + 2][0]) +
                $defaultPolygon[$i + 1][0] * ($defaultPolygon[$i + 2][1] - $defaultPolygon[$i][0]) +
                $defaultPolygon[$i + 2][0] * ($defaultPolygon[$i][1] - $defaultPolygon[$i + 1][0])) != 0
        ) {
            $center = array((1/3) * ($defaultPolygon[$i][0]
                                    + $defaultPolygon[$i + 1][0]
                                    + $defaultPolygon[$i + 2][0]),
                           (1/3) * ($defaultPolygon[$i][1]
                                  + $defaultPolygon[$i + 1][1]
                                  + $defaultPolygon[$i + 2][1]));
            break;

        }
    }

    foreach($points as $j => $testPoint){
        $begin = $defaultPolygon[0];
        $b = 0;
        $e = $last;
        $end = $defaultPolygon[$last];
        while($e - $b > 1){
            $m = round(($b + $e)/2);
            $mid = $defaultPolygon[$m];
            if(findAngle($begin, $center, $testPoint) < findAngle($begin, $center, $mid)){
                $end = $mid;
                $e = $m;
            }
            else{
                $begin = $mid;
                $b = $m;
            }
        }

       if(orientedArea($begin, $end, $testPoint) > 0){
           echo "point ". $j .": (".$testPoint[0]. ", ".$testPoint[1] . ") -  inside. <br/>";
       }
        else{
            echo "point ". $j .": (".$testPoint[0]. ", ".$testPoint[1] . ") - outside. <br/>";
        }
    }

}

pointInPolygon($defaultPolygon, $defaultTestPoints);