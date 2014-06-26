<?php

include "../../pointAlg.php";

$points = $_POST["points"];
$points = json_decode($points, true);


function findQl($point, $polygon)
{
    for($i = 1; $i <count($polygon); $i+=1){
        $sp = orientedArea($point, $polygon[$i], $polygon[$i - 1]);
        $ss = orientedArea($point, $polygon[$i], $polygon[$i + 1]);
        $help = $sp* $ss;

        if($help >= 0 && $sp < 0){
            $ql = $polygon[$i];
        }

        if($help >= 0 && $ss > 0){
            $qr = $polygon[$i];
        }
        return array($ql, $qr);
    }

}

function isPointOnLine($linePointA, $linePointB, $point)
{
    $a = ($linePointB[1] - $linePointA[1]) / ($linePointB[0] - $linePointA[0]);
   $b = $linePointA[1] - $a * $linePointA[0];
   if ( abs($point[1] - ($a*$point[0]+$b)) < 0.0001)
   {
       return true;
   }

   return false;
}

function dist($p1, $p2){
    return sqrt(pow(($p2[0] - $p1[0]), 2) + pow(($p2[1] - $p1[1]), 2));
}

function makeConvexHull($points){

    //

    $pointLocation = new pointLocation();
    $result = array();

    $firstPoint = array_shift($points);

    $result[] = $firstPoint;

    $secondPoint = array_shift($points);

    $result[] = $secondPoint;



    while((count($result)< 3) || !count($points) ){
        $thirdPoint = array_shift($points);

        if(isPointOnLine($result[0], $result[1], $thirdPoint)){
            if(dist($firstPoint, $thirdPoint) > dist($firstPoint, $secondPoint)){
                unset($result[1]);
                $result[1] = $thirdPoint;
            }
            if(dist($thirdPoint, $secondPoint) > dist($firstPoint, $secondPoint)){
                unset($result[0]);
                $result[0] = $thirdPoint;
            }
        }else{
            $result[] = $thirdPoint;
        }
    }



    while(count($points)){
        $cur = array_shift($points);
        if($pointLocation->pointInPolygon($cur, $result) === "outside" ){

        }
    }

}

echo  json_encode(makeConvexHull($points));
