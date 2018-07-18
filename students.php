<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset="UTF-8">
	<title>DYNASLOPE UNIVERSITY | Students</title>

		<link rel="stylesheet" type="text/css" href="style.css">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

		 <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>

</head>
<body>
		<header class="header">
		<nav class="navbar navbar-style">
			<div class="container">
				<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#micon">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>

				</button>

				<a href="index.html"><img class="logo" src="logo.jpg"></a>
				<h4>Dynaslope University</h4>

				</div>

				<div class="collapse navbar-collapse" id="micon">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="index.html">Home</a></li>
						<li><a href="students.php">Students</a></li>
						<li><a href="graphs.html">Graphs</a></li>
					</ul>
				</div>
			</div>
		</nav>
		</header>

		<section id="showcase">
  			<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Student's Information</h2>
                        <a href="create.php" class="btn btn-success pull-right">Add New Student</a>
                    </div>
                    <?php
                    // Include config file
                    require_once 'config.php';
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM employees";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        /*echo "<th>#</th>";*/
                                        echo "<th>Name</th>";
                                        echo "<th>English</th>";
                                        echo "<th>Math</th>";
                                        echo "<th>Science</th>";
                                        echo "<th>Filipino</th>";
                                        echo "<th>MAPEH</th>";
                                        echo "<th>AVERAGE</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                       /* echo "<td>" . $row['id'] . "</td>";*/
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['englishgrade'] . "</td>";
                                        echo "<td>" . $row['mathgrade'] . "</td>";
                                        echo "<td>" . $row['sciencegrade'] . "</td>";
                                        echo "<td>" . $row['filipinograde'] . "</td>";
                                        echo "<td>" . $row['mapehgrade'] . "</td>";
                                        echo "<td>" . $row['gpa'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>	
		</section>



</body>



</html>