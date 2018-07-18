<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$name = $englishgrade = $mathgrade = $sciencegrade = $filipinograde = $mapehgrade = $gpa = "";
$name_err = $englishgrade_err = $mathgrade_err = $sciencegrade_err = $filipinograde_err = $mapehgrade_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name;
    }
        
    // Validate englishgrade
    $input_englishgrade = trim($_POST["englishgrade"]);
    if(empty($input_englishgrade)){
        $englishgrade_err = "Please enter the Grade in English.";     
    } elseif(!ctype_digit($input_englishgrade)){
        $englishgrade_err = 'Please enter a positive integer value.';
    } else{
        $englishgrade = $input_englishgrade;
    }

    // Validate mathgrade
    $input_mathgrade = trim($_POST["mathgrade"]);
    if(empty($input_mathgrade)){
        $mathgrade_err = "Please enter the Grade in Math.";     
    } elseif(!ctype_digit($input_mathgrade)){
        $mathgrade_err = 'Please enter a positive integer value.';
    } else{
        $mathgrade = $input_mathgrade;
    }
    
    // Validate sciencegrade
    $input_sciencegrade = trim($_POST["sciencegrade"]);
    if(empty($input_sciencegrade)){
        $sciencegrade_err = "Please enter the Grade in Science.";     
    } elseif(!ctype_digit($input_sciencegrade)){
        $sciencegrade_err = 'Please enter a positive integer value.';
    } else{
        $sciencegrade = $input_sciencegrade;
    }

    // Validate filipinograde
    $input_filipinograde = trim($_POST["filipinograde"]);
    if(empty($input_filipinograde)){
        $filipinograde_err = "Please enter the Grade in Filipino.";     
    } elseif(!ctype_digit($input_filipinograde)){
        $filipinograde_err = 'Please enter a positive integer value.';
    } else{
        $filipinograde = $input_filipinograde;
    }

        // Validate mapehgrade
    $input_mapehgrade = trim($_POST["mapehgrade"]);
    if(empty($input_mapehgrade)){
        $mapehgrade_err = "Please enter the Grade in MAPEH.";     
    } elseif(!ctype_digit($input_mapehgrade)){
        $mapehgrade_err = 'Please enter a positive integer value.';
    } else{
        $mapehgrade = $input_mapehgrade;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($englishgrade_err) && empty($mathgrade_err) && empty($sciencegrade_err) && empty($filipinograde_err) && empty($mapehgrade_err)){
        // Prepare an insert statement
        $sql = "UPDATE employees SET name=?, englishgrade=?, mathgrade=? sciencegrade=?, filipinograde=? mapehgrade=? mapehgrade=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "siiiiii", $param_name, $param_englishgrade, $param_mathgrade, $param_sciencegrade,  $param_filipinograde, $param_mapehgrade, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_englishgrade = $englishgrade;
            $param_mathgrade = $mathgrade;
            $param_sciencegrade = $sciencegrade;
            $param_filipinograde = $filipinograde;
            $param_mapehgrade = $mapehgrade;
            //$param_gpa = $gpa;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: students.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM employees WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
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
                    $gpa = $row["gpa"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($englishgrade_err)) ? 'has-error' : ''; ?>">
                            <label>English</label>
                            <input type="text" name="englishgrade" class="form-control" value="<?php echo $englishgrade; ?>">
                            <span class="help-block"><?php echo $englishgrade_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($mathgrade_err)) ? 'has-error' : ''; ?>">
                            <label>Math</label>
                            <input type="text" name="mathgrade" class="form-control" value="<?php echo $mathgrade; ?>">
                            <span class="help-block"><?php echo $mathgrade_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($sciencegrade_err)) ? 'has-error' : ''; ?>">
                            <label>Science</label>
                            <input type="text" name="sciencegrade" class="form-control" value="<?php echo $sciencegrade; ?>">
                            <span class="help-block"><?php echo $sciencegrade_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($filipinograde_err)) ? 'has-error' : ''; ?>">
                            <label>Filipino</label>
                            <input type="text" name="filipinograde" class="form-control" value="<?php echo $filipinograde; ?>">
                            <span class="help-block"><?php echo $filipinograde_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($mapehgrade_err)) ? 'has-error' : ''; ?>">
                            <label>MAPEH</label>
                            <input type="text" name="mapehgrade" class="form-control" value="<?php echo $mapehgrade; ?>">
                            <span class="help-block"><?php echo $mapehgrade_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="students.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>