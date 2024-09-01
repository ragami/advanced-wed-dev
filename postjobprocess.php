<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Assignment 1" />
    <meta name="keywords" content="Web Programming" />
    <title>Assignment 1</title>
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>

<body>
    <div class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a class="active" href="postjobform.php">Job Post</a></li>
            <li><a href="searchjobform.php">Job Search</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="datashow.php">Data Show</a></li>
        </ul>
    </div>
    <h1>Job Vacancy Posting System</h1>
    <?php
    $error = 0; //error message
    //Position ID
    if (!isset($_POST["id"]) && empty($_POST["id"])) { // Additional check if 'id' is not set or empty
        echo "<p id='err'>Position ID is required</p>";
        $error = 1;
    } else {
        $id = $_POST["id"];
        $idlength = strlen($id); // Convert string to number of characters
        if ($idlength != 5) { // Check if ID is not exactly 5 characters long
            echo "<p id='err'>Invalid Position ID. The ID must be exactly 5 characters long, starting with 'ID' followed by 3 digits.</p>";
            $error = 1;
        } elseif (!preg_match("/^ID[0-9]{3}$/", $id)) { // Validate ID format
            echo "<p id='err'>Invalid Position ID. The ID must be exactly 5 characters long, starting with 'ID' followed by 3 digits.</p>";
            $error = 1;
        }
    }
    //title
    if (isset($_POST["title"]) && empty($_POST["title"])) {  //isset title input and if not empty
        echo "<p id='err'>Title is required</p>";
        $error = 1;
    } else {
        $title = $_POST["title"];
        $titlelen = strlen($title); //convert string to number of character
        if ($titlelen > 10) { 
            echo "<p id='err'> Title should be between 1 and 10 in string length";
            $error = 1;
        } elseif (!preg_match("/^[a-zA-Z0-9,.! ]*$/", $title)) { //validate title
            echo "<p id='err'>The title can only contain a maximum
            of 10 alphanumeric characters including spaces, comma, period (full stop), and exclamation
            point. Other characters or symbols are not allowed.</p>";
            $error = 1;
        }
    }
    //Description
    if (isset($_POST["description"]) && empty($_POST["description"])) { //isset description input and if not empty
        echo "<p id='err'>Description is required</p>";
        $error = 1;
    } else {
        $description = $_POST["description"];
        $descriptionclength = strlen($description); //convert string to number of character
        if ($descriptionclength > 250) { //if more than 250 characters, error message error =1
            echo "<p id='err'>Description should be no more than 250 characters</p>";
            $error = 1;
        }
    }
    //Closing Date
    if (isset($_POST["closing_date"]) && empty($_POST["closing_date"])) { //isset closing date input and if not empty
        echo "<p id='err'>Close Date is required</p>";
        $error = 1;
    } else {
        $closing_date = $_POST["closing_date"];
        if (preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $closing_date, $matches)) {
            if (!checkdate($matches[2], $matches[1], $matches[3])) {
                $error = 1;
                echo 'Please enter a valid date in the format - dd/mm/yyyy"';
            }
        } else {
            $error = 1;
            echo 'Only this format - dd/mm/yyyy - is accepted.';
        }
    }
    //position
    if (isset($_POST["position"]) && !empty($_POST["position"])) { //isset position post and checks if not empty
        $position = $_POST["position"];
    } else {
        echo "<p id='err'>Please select a Postion</p>";
        $error = 1;
    }
    //contract
    if (isset($_POST["contract"]) && !empty($_POST["contract"])) { //isset contract post and checks if not empty
        $contract = $_POST["contract"];
    } else {
        echo "<p id='err'>Please select a Contract</p>";
        $error = 1;
    }
    //location
    if (isset($_POST["location"]) && !empty($_POST["location"])) {
        $location = $_POST["location"];
    } else {
        echo "<p id='err'>Please select a Location</p>";
        $error = 1;
    }
    //Application 1 and Application 2
    if ((isset($_POST["type1"]) && !empty($_POST["type1"])) || (isset($_POST["type2"]) && !empty($_POST["type2"]))) { //isset application post and checks if not empty
        if (empty($_POST["type1"])) { //if application1 is empty set application1 to " ", if not set application by post
            $type1 = " ";
        } else {
            $type1 = $_POST["type1"];
        }

        if (empty($_POST["type2"])) { //if application2 is empty set application to " ", if not set application by post
            $type2 = " ";
        } else {
            $type2 = $_POST["type2"];
        }
    } else { //if false error message
        echo "<p id='err'>Please select an application type</p>";
        $error = 1;
    }
    //Read, Write, run validation function 
    if ($error == 0) {
        $filename = "../../data/jobposts/jobs.txt"; //Gets file path.     
        $dir = "../../data/jobposts"; //Gets directory path.               
        if (!(file_exists($dir))) { //check if file exists 
            umask(0007); //set permision for directory 
            mkdir($dir, 02770); //set permision for data directory 
        }
        if (file_exists($filename)) { // check if file exists for reading
            $idData = array(); // create an empty array 
            $handle = fopen($filename, "r") or die("File not found"); // open the file in read mode

            while (!feof($handle)) { // loop while not end of file
                $onedata = fgets($handle); // read a line from the text file
                if ($onedata != "") { // ignore blank lines
                    $data = explode("\t", $onedata); // explode string to array
                    $idData[] = $data[0]; // create an array element
                }
            }
            fclose($handle); //close the file
            $newdata = (!(in_array($id, $idData)));
        } else {
            $newdata = true; // file does not exists, thus it must be a new data
        }
        if ($newdata) { //save to file
            $handle = fopen($filename, "a"); // open the file in append mode
            $data = $id . "\t" . $title . "\t" . $description . "\t" . $closing_date . "\t" . $position . "\t" . $contract . "\t" . $type1 . "\t" . $type2 . "\t" . $location . "\n";
            fputs($handle, $data); // write string to text file
            fclose($handle); // close the text file
            echo "<p>You have successfully posted your job.</p>";
            echo "<p> Return home? <a href=\"index.php\"> Home</a></p>";
        } else {
            echo "<p id='err'>Position ID already exists.</p>";
            echo "<p>Return to <a href=\"index.php\"> Home Page</a>";
            echo "<p>Go to <a href=\"searchjobform.php\">Search Job Vacancy</a></p>";
        }
    } else {
        echo "<p>Return to <a href=\"index.php\"> Home Page</a>";
        echo "<p>Go to <a href=\"searchjobform.php\">Search Job Vacancy</a></p>";
    }
    ?>
</body>

</html>
