<?php

$polygon = $_POST["polygon"];

$polygon = json_decode($polygon, true);
$point = $_POST["point"];
$point = json_decode($point, true);

//echo json_encode($polygon);
// test if a point is Left|On|Right of an infinite line.
// line: p0 - p1; point : p2
// return: -1 : on right; 1 - on left; 0 - on the line
function isLeft( $p0, $p1, $p2)
{
    $result = ($p1[0] - $p0[0])*($p2[1] - $p0[1]) - ($p2[0] - $p0[0])*($p1[1] - $p0[1]);
    if($result > 0){
        return 1;
    }
    else if($result < 0){
        return -1;
    }
    else{
        return 0;
    }
}

// tests for polygon vertex ordering relative to a fixed point P
function above($p, $vi, $vj){
    return (isLeft($p, $vi, $vj) == 1);
}

function below($p, $vi, $vj){
    return (isLeft($p, $vi, $vj) == -1);
}

function findTangents($point, $polygon){
    $n = count($polygon);
    $rtan = 0;
    $ltan = 0;
    $eprev = isLeft($polygon[0], $polygon[1], $point);
    for($i = 1; $i< $n - 1; $i++){
        $enext = isLeft($polygon[$i], $polygon[$i+1], $point);
        if($eprev <= 0 && $enext > 0){
            if(!below($point, $polygon[$i], $polygon[$rtan] )){
                $rtan = $i;
            }
        }

        if($eprev > 0 && $enext <= 0){
            if(!above($point, $polygon[$i], $polygon[$ltan] )){
                $ltan = $i;
            }
        }
        $eprev = $enext;
    }

    return array($polygon[$ltan], $polygon[$rtan]);
}





