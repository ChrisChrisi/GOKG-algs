
<div class="container">
    <div class="main">
        <div class="content">
            <div class="section">
                <br>
                <table>
                    <tr>
                        <td valign="top">
                            <div id="canvas"
                                 style="overflow:hidden;position:relative;width:600px;height:370px;border:#999999 1px solid;"></div>

                        <td valign="top" style="padding-left:10px">
                            <table>
                                <tr>
                                    <td><b>Pen Width:</b></td>
                                    <td><input id="penwidth" type="text" value="1" size="20"/></td>
                                </tr>
                                <tr>
                                    <td><b>Color:</b></td>
                                    <td><input id="color" type="text" value="#0000ff" size="20""/></td>
                                </tr>
                            </table>
                            <br>
                            <input style="font-weight:bold" type="button" value="Draw Polygon"
                                   onclick="drawPolygon();"/>
                            <br><br>
                            <input style="font-weight:bold" type="button" value="Set test points"
                                   onclick="getTestPoints();"/>
                            <br><br>
                            <input style="font-weight:bold" type="button" value="Get points position"
                                   onclick="callAlgorithm()"/>
                            <br><br>
                            <input style="font-weight:bold" type="button" value="Clear Canvas"
                                   onclick="clearCanvas();"/>
                            <br><br>
                        <td>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="result">
            </div>

        </div>
    </div>
</div>
<script src="jsDraw2d/jsDraw2D.js" type="text/javascript">
</script>
<script src="basicDraw.js" type="text/javascript">
</script>
