
var canvasDiv = document.getElementById("canvas");
var gr = new jsGraphics(canvasDiv);
var penWidth;
var col;
var pen;
var d1, d2;
var msdiv = document.getElementById("timems");
setPenColor(true);
var points = new Array();
var pointsArray = [];
var polygonPoints = new Array();

//var defaultPoints=[[70,90],[100, 80], [150,100], [170, 150], [130, 170], [90, 150]];
//[106.66, 90]
//var defaultTestPoints = [[160, 70], [150, 90], [210, 85]];
var defaultPoints= [[60,90],[90, 70], [80,110], [150, 90], [110, 150], [210, 100], [210, 100], [210, 100], [130, 60],
    [230, 120], [170, 210], [160, 80]];

defaultPoints.forEach(function(point){
    gr.fillCircle(new jsColor("red"), new jsPoint(point[0] - 2 , point[1] - 2), 2, 2);
    points[points.length] = new jsPoint(point[0] - 3, point[1] - 3);
    pointsArray.push([point[0], point[1]]);
});

var drawColorPoint = function(color, point)
{
    gr.fillCircle(new jsColor(color), new jsPoint(point[0] - 2, point[1] - 2), 2, 2);

};

var ie = false;
if (document.all)
    ie = true;
canvasDiv.onmousemove = getMouseXY;
canvasDiv.onclick = drawPoint;

var mouseX = 0;
var mouseY = 0;

//Get mouse position
function getMouseXY(e) {
    if (ie) {
        mouseX = event.clientX + document.body.parentElement.scrollLeft;
        mouseY = event.clientY + document.body.parentElement.scrollTop;
    } else {
        mouseX = e.pageX
        mouseY = e.pageY
    }

    if (mouseX < 0) {
        mouseX = 0
    }
    if (mouseY < 0) {
        mouseY = 0
    }

    mouseX = mouseX - canvasDiv.offsetLeft;
    mouseY = mouseY - canvasDiv.offsetTop;

    return true;
}

function setPenColor(noAlert) {
    if (document.getElementById("color").value != "")
        col = new jsColor(document.getElementById("color").value);
    else
        col = new jsColor("blue");

    if (document.getElementById("penwidth").value != "")
        penWidth = document.getElementById("penwidth").value;

    if (!isNaN(penWidth))
        pen = new jsPen(col, penWidth);
    else
        pen = new jsPen(col, 1);

    if (!noAlert) {
        if (points.length == 0) {
            alert("Please click at any location on the blank canvas at left side to plot the points!");
            return false;
        }
        else if (points.length == 1) {
            alert("2 or more points are required to draw a line, polyline or polygon! Please plot more points by clicking at any location on the blank canvas at left side.");
            return false;
        }
    }
    return true;
}

function drawPoint() {
    gr.fillCircle(new jsColor("blue"), new jsPoint(mouseX - 2, mouseY - 2), 2, 2);
    points[points.length] = new jsPoint(mouseX - 3, mouseY - 3);
   // console.log(points.length, [mouseX, mouseY])
    pointsArray.push([mouseX, mouseY]);
}

function drawPolygon() {
    gr.drawPolygon(pen, points);
    polygonPoints = pointsArray;
    polygonPoints.push(polygonPoints[0]);
    pointsArray = [];
    points=new Array();
}

function drawPolyline() {
    if (!setPenColor())
        return;
    d1 = (new Date()).getTime();
    gr.drawPolyline(pen, points);
    d2 = (new Date()).getTime();
    msdiv.innerHTML = (d2 - d1);
    ShowPoints();
    //points=new Array();
}

function drawLine() {
    if (!setPenColor())
        return;
    d1 = (new Date()).getTime();
    gr.drawLine(pen, points[points.length - 2], points[points.length - 1]);
    d2 = (new Date()).getTime();
    msdiv.innerHTML = (d2 - d1);
    ShowPoints();
    pointsArray = [];
    points=new Array();
}
function getTestPoints(){
    $point  = pointsArray[0];
    var request1 = $.ajax({
        url: "tasks/task3/call.php",
        type: "POST",
        data: {polygon :JSON.stringify(polygonPoints), point: JSON.stringify(pointsArray[0])}
    });
    request1.done(function(msg) {
        var points = jQuery.parseJSON(msg);
        points.forEach(function(point){
            drawColorPoint("green", point);
        });
        $("#result").html(msg);
    });

    request1.fail(function(jqXHR, textStatus) {
        alert( "Request failed: " + textStatus );
    });
}

function callAlgorithm(){
    console.log(pointsArray);
    var request = $.ajax({
        url: "tasks/task3/callAlg.php",
        type: "POST",
        data: {polygon :JSON.stringify(polygonPoints), points: JSON.stringify(pointsArray)}
    });

    request.done(function(msg) {

        var points = jQuery.parseJSON(msg);
        points.forEach(function(point){
            drawColorPoint("yellow", point);
        });

        $("#result").html(msg);

    });

    request.fail(function(jqXHR, textStatus) {
        alert( "Request failed: " + textStatus );
    });

}

function fillPolygon() {
    if (!setPenColor())
        return;
    d1 = (new Date()).getTime();
    gr.fillPolygon(col, points);
    d2 = (new Date()).getTime();
    msdiv.innerHTML = (d2 - d1);
    ShowPoints();
    //points=new Array();
}


function clearCanvas() {
    gr.clear();
    points = new Array();
    pointsArray = [];
    testPoints = [];
    polygonPoints = new Array();
    $("#result").empty();
}

function clearPreviousPoints() {
    points = new Array();
}

function ShowPoints() {
    var txt = document.getElementById("txt");
    txt.value = "";
    for (var i = 0; i < points.length; i++) {
        txt.value = txt.value + "new jsPoint(" + points[i].x + "," + points[i].y + "),";
    }
}