<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once 'config.php';
    
    // Prepare a select statement
    $sql = "SELECT * FROM employees WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                $englishgrade = $row["englishgrade"];
                $mathgrade = $row["mathgrade"];
                $sciencegrade = $row["sciencegrade"];
                $filipinograde = $row["filipinograde"];
                $mapehgrade = $row["mapehgrade"];
                //$gpa = $row["gpa"];

            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>English</label>
                        <p class="form-control-static"><?php echo $row["englishgrade"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Math</label>
                        <p class="form-control-static"><?php echo $row["mathgrade"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Science</label>
                        <p class="form-control-static"><?php echo $row["sciencegrade"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Filipino</label>
                        <p class="form-control-static"><?php echo $row["filipinograde"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>MAPEH</label>
                        <p class="form-control-static"><?php echo $row["mapehgrade"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>AVERAGE</label>
                        <p class="form-control-static"><?php echo $row["gpa"]; ?></p>
                    </div>
                    <p><a href="students.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>