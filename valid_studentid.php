<?php
    require("db.php");
    $studentNum = '';
    $studentNum_err = '';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if (empty(trim($_POST["regisNum"]))){
            // ! Checks if input field is empty
            $studentNum_err = 'Field is empty, please enter value!';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["regisNum"]))){
            // ! Checks if the inputted field contains special characters
            $studentNum_err = 'Value contains special characters. Please enter only numerical 
            and alphabetical values only!';
        } else if(strlen(trim($_POST["regisNum"])) != 7){
            // ! Checks if the value is exactly 7 characters long
            $studentNum_err = 'Error';
        } else{
            // ! Assigned the inputted value into the variable
            $studentNum = trim($_POST["regisNum"]);
        }

        if (empty($studentNum_err)){
            $sql = "INSERT INTO ubdstudentid (studentid) VALUE (?)";
            if($stmt = mysqli_prepare($conn, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_studentNum);
                $param_studentNum = $studentNum;

                if(mysqli_stmt_execute($stmt)){
                    echo "Student ID registration successful!" ;
                } else{
                    echo "There is something wrong!";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID</title>
</head>
<body>
    <h1>UBD Student ID</h1>
    <h2>Please enter your Student ID</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <label>Student ID: </label>

        <input type="text" name="regisNum" id="regisNum">
        <label><?php echo $studentNum_err?></label>

        <input type="submit" value="submit">
    </form>
</body>
</html>