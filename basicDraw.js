
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
var testPoints = [];
var polygonPoints = new Array();

var defaultPolygon = [[50,80],[60, 60], [130,80], [170, 60], [190, 85], [140, 120], [100, 90], [80, 100]];
var defaultTestPoints = [[160, 70], [150, 90], [210, 85]];
defaultPolygon.forEach(function(point){
    gr.fillCircle(new jsColor("blue"), new jsPoint(point[0] - 2 , point[1] - 2), 2, 2);
    points[points.length] = new jsPoint(point[0] - 3, point[1] - 3);
     pointsArray.push([point[0], point[1]]);
});
drawPolygon();
defaultTestPoints.forEach(function(point){
    gr.fillCircle(new jsColor("red"), new jsPoint(point[0] - 2 , point[1] - 2), 2, 2);
    points[points.length] = new jsPoint(point[0] - 3, point[1] - 3);
    pointsArray.push([point[0], point[1]]);
});

getTestPoints();


var ie = false;
if (document.all)
    ie = true;
canvasDiv.onmousemove = getMouseXY;
canvasDiv.onclick = drawPoint;

var mouseX = 0
var mouseY = 0

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
    pointsArray.push([mouseX, mouseY]);
}

function drawPolygon() {
    canvasDiv.onclick = drawPoint;
    if (!setPenColor())
        return;
    gr.drawPolygon(pen, points);
    polygonPoints = pointsArray;
    polygonPoints.push(polygonPoints[0]);
    pointsArray = [];
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
    testPoints = pointsArray;
}

function callAlgorithm(){
console.log(polygonPoints);
    //return JSON.stringify( [polygonPoints, testPoints]);
    var request = $.ajax({
        url: "callAlg.php",
        type: "POST",
        data: {polygon :JSON.stringify(polygonPoints), points: JSON.stringify(pointsArray)}
    });

    request.done(function(msg) {
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