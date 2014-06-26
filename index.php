<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <script src="jsDraw2d/jsDraw2D.js" type="text/javascript">
    </script>


</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Home</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li id="task1" class="btn"><a>Task 1</a>
                    </li>
                    <li id="task2" class="btn"><a>Task 2</a>
                    </li>
                    <li id="task3" class="btn"><a>Task 3</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container content">
        Geometric algorithms.

    </div>
    <!-- /.container -->

    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#task1").on("click", function(){
            $(this).siblings().removeClass("active");
            $(this).addClass("active");
           $(".content").empty();
            $(".content").load("task1.php");
        });
        $("#task2").on("click", function(){
            $(this).siblings().removeClass("active");
            $(this).addClass("active");
            $(".content").empty();
            $(".content").load("task2.php");
        });
        $("#task3").on("click", function(){
            $(this).siblings().removeClass("active");
            $(this).addClass("active");
            $(".content").empty();
            $(".content").load("task3.php");
        });
    });
</script>

</body>

</html>
